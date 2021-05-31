<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Helpers\PaginationLinks;


class UsersController extends Controller
{
    public function __construct(Request $request)
    {
        $this->api = new API();
    }


    public function index(Request $request)
    {
        $page = 1;
        if ($request->has("page"))
            $page = $request->page;
        $opt = ["limit"=>10, "page"=>$page];
        $query = '';
        if ($request->has('search_name') and $request->search_name != '') {
            $opt['search_name'] = $request->search_name;
            $query = "&search_name=".$opt['search_name'];
        }
        $payment_info_status = '';
        if ($request->has('payment_info_status_id') and $request->payment_info_status_id != '') {
            $opt['payment_info_status_id'] = $request->payment_info_status_id;
            $payment_info_status = "&payment_info_status_id=".$opt['payment_info_status_id'];
        }

        $user_api = [];
        $user_get = '';
        if ($request->has('user_id') and $request->user_id != ''){
            $opt['user_id'] = $request->user_id;
            $user_get = "&user_id=".$opt['user_id'];
            $user_api = $this->api->get_user(['user_id'=>$opt['user_id']])->post();
            if (!isset($user_api['status']) or (isset($user_api['status']) and $user_api['status'] == 'failed'))
                return redirect()->route('users.index')->with('error', __('adnetwork.user_not_found'));
            $user_api = $user_api['data'][0];
        }


        $data = $this->api->get_user_list($opt)->post();
        $items = [];
        if (isset($data['status']) and $data['status'] == 'success') {
            $count = $data['data']['count'];
            $items = $data['data']['rows'];
            $pages = ceil($count/10);
            $cur_page = $page;
            if (count($items) > 0 )
                $pagination = PaginationLinks::paginationCreate($cur_page,$pages,2,
                    '<li class="page-item"><a class="page-link" href="?page=%d'.$query.$user_get.$payment_info_status.'">%d</a></li>',
                );

        }
        return view('users.index', compact('items' ,'request', 'pagination', 'user_api', 'request'));

    }


    public function azerforumRevenueDaily(Request $request, $lang, $id)
    {
        $data = $this->api->get_slot(['user_id' => $id, 'limit' => 150])->post();
        $user = $this->api->get_user(['user_id' => $id])->post();
        if (isset($user) and $user['status'] == 'success')
            $user = $user['data'][0];
        else
            abort(404);

        if (isset($data['data']) and isset($data['data']['rows']) and count($data['data']['rows'])) {
            $data = $data['data']['rows'];
            $slot_ids = array_column($data, 'slot_id');
            $start_date = "01.".date('m.Y');
            $end_date = date('d.m.Y');

            if ($request->has('start_date'))
                $start_date = $request->start_date;
            if ($request->has('end_date'))
                $end_date = $request->end_date;


            $opt = [
                "stats_type" => "get_azerforum_revenue_daily",
                'slot_ids' => $slot_ids,
                'start_date'=>$start_date,
                "end_date" => $end_date
            ];
            $data = $this->api->click_impression_stats($opt)->post();
            $items = [];
            if (isset($data['status']) and $data['status'] == 'success')
                $items = $data['data']['stats'];
            return view('users.azerforum_revenue_daily', compact('items', 'user', 'request', 'start_date', 'end_date'));
        }
        return redirect()->route('users.index', app()->getLocale())->with('error', __('adnetwork.user_not_any_slot'));

    }


    public function stats(Request $request, $lang, $user_id)
    {
        $data = $this->api->get_pub_wallet_log(['user_id' => $user_id])->post();
        $items = [];
        if (isset($data['data']) and isset($data['data']['rows']))
            $items = $data['data']['rows'];
        $new_items = [];
        $dates = array_column($items,'date');
        $i=0;
        foreach ($dates as $date) {
            $date_arr = explode('-', $date);
            $date = $date_arr[1].'-'.$date_arr[0];
            $new_items[$date][] = $items[($i)];
            $i++;
        }
        $items = $new_items;
        return view('users.stats', compact('items'));
    }


    public function editPayment(Request $request, $lang, $user_id)
    {
        $item = $this->api->get_user(['user_id' => $user_id])->post();
        if (isset($item['status']) and $item['status'] == 'success' and count($item['data'])>0)
            $item = $item['data'][0];
        else
            abort(404);
        $item['payment_info'] = (array) json_decode($item['payment_info']);

        if ($request->isMethod('POST')) {

            if ($request->payment_provider == '1') {
                $validations['bank_card'] = ['required'];
                $validations['bank_card_end_date'] = ['required', 'string'];
                $validation_messages['bank_card.required'] = __('adnetwork.error_bank_card');
                $validation_messages['bank_card_end_date.required'] = __('adnetwork.error_bank_card_end_date');
            }
            else{
                $validations['voen'] = ['required'];
                $validation_messages['voen.required'] = __('adnetwork.error_voen');
            }
            $request->validate($validations,$validation_messages);
            $opt = [
                "user_id" => $item['user_id'],
                'payment_info' => [
                    "payment_provider" => $request->payment_provider,
                    'voen' => $request->voen,
                    'bank_card' => str_replace(' ', '', $request->bank_card),
                    "bank_card_end_date" => $request->bank_card_end_date,
                    "status_id" => $request->status_id
                ],
            ];
            $this->api->user_payment_update($opt)->post();
            return redirect()->route('users.index', app()->getLocale())->with('success'. __('adnetwork.succesfully_updated'));
        }
        return view('users.payment_detail', compact('request', 'item'));

    }

}
