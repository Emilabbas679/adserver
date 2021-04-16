<?php

namespace App\Http\Controllers;

use App\Http\Helpers\PaginationLinks;
use Illuminate\Http\Request;

class AdsetController extends Controller
{
    public function __construct()
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
        if ($request->has('searchQuery') and $request->searchQuery != ''){
            $opt['searchQuery'] = $request->searchQuery;
            $query = "&searchQuery=".$opt['searchQuery'];
        }
        $status = '';
        if ($request->has('status_id') and $request->status_id != ''){
            $opt['status_id'] = $request->status_id;
            $status = "&status_id=".$opt['status_id'];
        }
        $user_api = [];
        $user_get = '';
        if ($request->has('user_id') and $request->user_id != '' and $request->user_id != 0){
            $opt['user_id'] = $request->user_id;
            $user_get = "&user_id=".$opt['user_id'];
            $user_api = $this->api->get_user(['user_id'=>$opt['user_id']])->post();
            if (!isset($user_api['status']) or (isset($user_api['status']) and $user_api['status'] == 'failed'))
                return redirect()->route('adset.index', app()->getLocale())->with('error', __('notification.user_not_found'));
            $user_api = $user_api['data'][0];
        }
        $data = $this->api->get_adset($opt)->post();
        $items = [];
        $cur_page = $page;
        $pagination = '';
        if (isset($data['status']) and $data['status'] == 'success') {
            $items = $data['data']['rows'];
            $count = $data['data']['count'];
            $pages = round($count/10);
            if (count($items) > 0 )
                $pagination = PaginationLinks::paginationCreate($cur_page,$pages,2,
                    '<li class="page-item"><a class="page-link" href="?page=%d'.$status.$query.$user_get.'">%d</a></li>',
                );
        }
        return view('adset.index', compact('pagination', 'page', 'cur_page', 'items', 'request', 'user_api'));
    }


    public function statusUpdate(Request $request,$lang, $adset_id, $status_id)
    {
        $opt = ['set_id'=> $adset_id, 'status_id' => $status_id];
        $result = $this->api->update_adset_status($opt)->post();
        if (isset($result['status']) and $result['status'] == 'success')
            return redirect()->route('adset.index', app()->getLocale())->with('success', __('notification.successfully_updated'));
        else
            return redirect()->back()->with(['error'=>__('notification.something_went_wrong')]);
    }

    public function edit(Request $request, $lang, $id)
    {
        $ad = $this->api->get_adset(['set_id' => $id])->post();
        if (isset($ad['status']) and $ad['status'] == 'success') {
            $item = $ad['data']['rows'][0];
//            $campaign = $this->api->get_campaign(['campaign_id' => $ad['campaign_id']])->post()['data']['rows'][0];
            if ($request->isMethod('POST')){

            }

            return view('adset.edit', compact('request', 'item' ));
        }
        return redirect()->route('adset.index', app()->getLocale())->with('adnetwork.not_found');




    }


}
