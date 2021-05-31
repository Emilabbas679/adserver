<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->api = new API();
    }


    public function selectUsers(Request $request)
    {
        $page = $request->page;
        $opt = ['page' => $page, 'limit'=>10];
        if($request->has('search'))
            $opt['search_name'] = $request->search;
        $data = $this->api->get_user_list($opt)->post();
        if (isset($data['status']) and $data['status'] == 'success'){
            $count = $data['data']['count'];
            $rows = $data['data']['rows'];
            $more = false;
            if ($count > $page*10)
                $more = true;
            $emails = array_column($rows,'email');
            $ids = array_column($rows,'user_id');
            $items = [];
            if ($page == 1)
                $items[] = ['id' => 0, 'text'=>__('adnetwork.no_user')];
            for ($i=0;$i<10;$i++){
                if (isset($ids[$i]))
                    $items[] = ['id'=>$ids[$i], 'text'=>$emails[$i]];
            }
            $data = ['results' => $items, 'pagination' => ['more' => $more]];
            return $data;
        }
        return false;
    }

    public function selectCampaigns(Request $request)
    {
        $page = $request->page;
        $opt = ['page' => $page, 'limit'=>10];
        if($request->has('search'))
            $opt['searchQuery'] = $request->search;
        $data = $this->api->get_campaign($opt)->post();
        if (isset($data['status']) and $data['status'] == 'success'){
            $count = $data['data']['count'];
            $rows = $data['data']['rows'];
            $more = false;
            if ($count > $page*10)
                $more = true;
            $names = array_column($rows,'name');
            $ids = array_column($rows,'campaign_id');

            $items = [];
            if ($page == 1)
                $items[] = ['id' => 0, 'text'=>__('adnetwork.no_user')];
            for ($i=0;$i<10;$i++){
                if (isset($ids[$i]))
                    $items[] = ['id'=>$ids[$i], 'text'=>$names[$i]];
            }
            $data = ['results' => $items, 'pagination' => ['more' => $more]];
            return $data;
        }
        return false;
    }


    public function selectAgencies(Request $request)
    {
        $page = $request->page;
        $opt = ['page' => $page, 'limit'=>10];
        if($request->has('search'))
            $opt['agency_name'] = $request->search;
        $data = $this->api->get_agency($opt)->post();
        if (isset($data['status']) and $data['status'] == 'success'){
            $count = $data['data']['count'];
            $rows = $data['data']['rows'];
            $more = false;
            if ($count > $page*10)
                $more = true;
            $names = array_column($rows,'agency_name');
            $ids = array_column($rows,'agency_id');
            $items = [];
            if ($page == 1)
                $items[] = ['id' => 0, 'text'=>__('adnetwork.no_agency')];
            for ($i=0;$i<10;$i++){
                if (isset($ids[$i]))
                    $items[] = ['id'=>$ids[$i], 'text'=>$names[$i]];
            }
            $data = ['results' => $items, 'pagination' => ['more' => $more]];

            return $data;
        }
        return false;
    }



    public function selectSites(Request $request)
    {
        $page = $request->page;
        $opt = ['page' => $page, 'limit'=>10];
        if($request->has('search'))
            $opt['searchQuery'] = $request->search;
        $data = $this->api->get_site($opt)->post();
        if (isset($data['status']) and $data['status'] == 'success'){
            $count = $data['data']['count'];
            $rows = $data['data']['rows'];
            $more = false;
            if ($count > $page*10)
                $more = true;
            $domains = array_column($rows,'domain');
            $ids = array_column($rows,'site_id');
            $items = [];
            if ($page == 1)
                $items[] = ['id' => 0, 'text'=>__('adnetwork.no_user')];
            for ($i=0;$i<10;$i++){
                if (isset($ids[$i]))
                    $items[] = ['id'=>$ids[$i], 'text'=>$domains[$i]];
            }
            $data = ['results' => $items, 'pagination' => ['more' => $more]];
            return $data;
        }
        return false;
    }


    public function selectFinanceCost(Request $request)
    {
        $page = $request->page;
        $opt = ['page' => $page, 'limit'=>10, "start_date" => '01.01.2020', "end_date" => date('d.m.Y')];
        if($request->has('search'))
            $opt['searchQuery'] = $request->search;


        $data = $this->api->get_cost($opt)->post();
        if (isset($data['status']) and $data['status'] == 'success'){
            $count = $data['data']['info']['count'];
            $rows = $data['data']['rows'];
            $more = false;
            if ($count > $page*10)
                $more = true;
            $texts = array_column($rows,'cost_category_name');
            $amounts = array_column($rows,'amount');
            $descriptions = array_column($rows,'description');
            $ids = array_column($rows,'id');

            $items = [];

            for ($i=0;$i<10;$i++){
                if (isset($ids[$i]))
                    $items[] = ['id'=>$ids[$i], 'text'=>$amounts[$i].' - '.$texts[$i].' - '.$descriptions[$i]];
            }
            $data = ['results' => $items, 'pagination' => ['more' => $more]];
            return $data;
        }
        return false;
    }
}
