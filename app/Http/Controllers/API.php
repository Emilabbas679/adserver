<?php
namespace App\Http\Controllers;


use http\Env\Url;

class API extends Controller {

	/* var */
	public $send_data = [];
	public $result = [];
	/* some magic */


    public function __call($method, $args)
    {

		if(!isset($args[0])) $args[0] = [];

		return $this->prepare($method, $args[0]);
    }


    public function prepare($action = 'get_advert', $parameters = array()){
		$this->send_data['action'] = $action;
		$parameters['ip_address'] = $this->getUserIP();
		$parameters['url'] = env('APP_NAME');
		$this->send_data['parameters'] = $parameters;
		return $this;
	}

    public function getUserIP() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function send($action = 'get_advert', $parameters = array()) {
        $url = 'http://49.12.92.130/api2/';
        $data = array();
        $data['action'] = $action;
        $data['site_title'] = env('APP_NAME');
//        $data['ssp_id'] = 7;
        $data['actionBy'] = /*AIN::isUser() ? AIN::getUserBy('email') : */'Guest';
		$parameters['user_hash'] = session("user_hash") ? session("user_hash") : null;
//        $parameters['ssp_id'] = 7;
        $parameters['site_title'] = env('APP_NAME');

        foreach ($parameters as $key => $value) {
            if (gettype($value) == "integer") {
                $parameters[$key] = (string) $value;
            } elseif (gettype($value) == "array") {
                foreach ($value as $key2 => $value2) {
                    if (gettype($value2) == "integer") {
                        $parameters[$key][$key2] = (string) $value2;
                    }
                }
            }
        }

        $parameters['page'] = isset($parameters['page']) ? $parameters['page'] : '1';
        $parameters['size'] = isset($parameters['size']) ? $parameters['size'] : '100';



        $data['parameters'] = $parameters;
        $headers = array('Accept: application/json', 'Content-Type: application/json');
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);  // Seems like good practice
        $result = json_decode($result, true);
		// Ops!
		$this->result = $result;

//		if(isset($result['status']) && $result['status']== 'failed'){
//            $this->throwError($result['messages']);
//        }
		return $result;
    }

	public function get($count = null){
		if($count != null && $count != -1)
			$this->send_data['parameters']['limit'] = $count;
		if($count == -1){
			$this->send_data['parameters']['limit'] = $count;

			// Get max element
			$count = $this->send($this->send_data['action'], $this->send_data['parameters'])['count'];
			$this->send_data['parameters']['limit'] = $count;
		}
		return ($this->send($this->send_data['action'], $this->send_data['parameters']));
	}

	public function first(){
		$data = $this->send($this->send_data['action'], $this->send_data['parameters'])['data'];
		if(isset($data[0])){
			return ($data[0]);
		}else {
			return ($data);
		}
	}

	public function paginate($limit = 40){
		$this->send_data['parameters']['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
		$this->send_data['parameters']['limit'] = $limit;
		$response = $this->send($this->send_data['action'], $this->send_data['parameters']);
		$paginator = new \Illuminate\Pagination\LengthAwarePaginator(
			$response['data'],
			$response['data']['count'],
			$limit,
			\Illuminate\Pagination\Paginator::resolveCurrentPage(),
			['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
		);
		return $paginator;
	}

	public function post(){

		$response = $this->send($this->send_data['action'], $this->send_data['parameters']);
		if(isset($response['data'])){
			return $response;
		}else{
			return $response;
		}
	}

	public function create(array $datum = []){
		$this->send_data['parameters'] = array_merge($this->send_data['parameters'],$datum);
		return $this->send($this->send_data['action'], $this->send_data['parameters'])['data'];
	}

	public function update(array $datum = []){
		$this->send_data['parameters'] = array_merge($this->send_data['parameters'],$datum);
		return $this->send($this->send_data['action'], $this->send_data['parameters'])['data'];
	}

	public function delete(array $datum = []){
		$this->send_data['parameters'] = array_merge($this->send_data['parameters'],$datum);
		return $this->send($this->send_data['action'], $this->send_data['parameters'])['data'];
	}


	public function throwError($result){
		$error_message = (isset($result['status']) && $result['status'] == 'failed') ? $result['messages'] : $result[''];
		$error = \Illuminate\Validation\ValidationException::withMessages($error_message);
		throw $error;
	}

	public function throwErrorAjax($result){
		if(isset($result['status']) && $result['status'] == 'failed'){
			$error_message = isset($result['errors']) ? $result['messages'] : $result[''];
			return ["type"=>"error","messages"=>$result['messages']];
		}
	}

}

?>
