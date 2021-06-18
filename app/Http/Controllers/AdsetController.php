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
        if (auth_group_id() != 1)
            $opt['user_id'] = auth_id();


        $data = $this->api->get_adset($opt)->post();
        $items = [];
        $cur_page = $page;
        $pagination = '';
        if (isset($data['status']) and $data['status'] == 'success') {
            $items = $data['data']['rows'];
            $count = $data['data']['count'];
            $pages = ceil($count/10);
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
            if (auth_group_id() != 1 and $item['user_id'] != auth_id())
                return redirect()->route('adset.index', app()->getLocale())->with(['error'=>__('adnetwork.not_found')]);

            if ($request->isMethod('POST')){
                $opt = [];
                $opt['set_id'] = $id;
                $opt['campaign_id'] = $item['campaign_id'];
                $opt['campaign_name'] = $item['campaign_name'];
                $opt['name'] = $item['name'];
                if ($request->has('os_id'))
                    $opt['os_id'] = $request->get('os_id');
                if ($request->has('device_id'))
                    $opt['device_id'] = $request->get('device_id');
                if ($request->has('connection_type_id'))
                    $opt['connection_type_id'] = $request->get('connection_type_id');
                if ($request->has('operator_id'))
                    $opt['operator_id'] = $request->get('operator_id');
                if ($request->has('age_group_id'))
                    $opt['age_group_id'] = $request->get('age_group_id');
                if ($request->has('gender'))
                    $opt['gender'] = $request->get('gender');
                if ($request->has('country_id'))
                    $opt['country_id'] = $request->get('country_id');
                if ($request->has('tags')) {
                    $tags = (array) json_decode($request->tags);
                    $tags = array_column($tags, 'value');
                    $opt['tags'] = implode(',', $tags);
                }
                if ($request->has('negative_tags')){
                    $tags = (array) json_decode($request->negative_tags);
                    $tags = array_column($tags, 'value');
                    $opt['negative_tags'] = implode(',', $tags);
                }

                $end_date = $request->get('end_date').' '.$request->end_date_time;
                $opt['end_time'] = strtotime($end_date);
                $start_date = $request->get('start_date').' '.$request->start_date_time;
                $opt['start_time'] = strtotime($start_date);

                $opt['budget_type'] =  $request->get('budget_type');
                $opt['budget_planned'] =  $request->get('budget_planned');
                $result = $this->api->update_adset($opt)->post();

                if (isset($result['status']) and $result['status'] == 'success')
                    return redirect()->route('adset.index', app()->getLocale())->with('success', __('adnetwork.successfully_updated'));
                else
                    return redirect()->back()->with('error', __('adnetwork.something_went_wrong'));
            }
            return view('adset.edit', compact('request', 'item' ));
        }
        return redirect()->route('adset.index', app()->getLocale())->with('adnetwork.not_found');

    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')){
            $request->validate([
                'name' => ['required', 'string'],
                'budget_type' => ['required', 'string'],
                'budget_planned' => ['required', 'string'],
                'start_date' => ['required', 'string'],
                'start_date_time' => ['required', 'string'],
                'end_date' => ['required', 'string'],
                'end_date_time' => ['required', 'string'],
            ],
                [
                    'name.required' => __('notification.name_is_required'),
                    'user_id.required' => __('notification.user_is_required'),
                ]
            );
            $opt = [];
            $opt['campaign_id'] = $request->campaign_id;
            $opt['name'] = $request->name;
            $opt['user_id'] = auth_id();
            if ($request->has('os_id'))
                $opt['os_id'] = $request->get('os_id');

            if ($request->has('device_id'))
                $opt['device_id'] = $request->get('device_id');

            if ($request->has('connection_type_id'))
                $opt['connection_type_id'] = $request->get('connection_type_id');

            if ($request->has('operator_id'))
                $opt['operator_id'] = $request->get('operator_id');

            if ($request->has('age_group_id'))
                $opt['age_group_id'] = $request->get('age_group_id');

            if ($request->has('gender'))
                $opt['gender'] = $request->get('gender');

            if ($request->has('country_id'))
                $opt['country_id'] = $request->get('country_id');

            if ($request->has('tags')) {
                $tags = (array) json_decode($request->tags);
                $tags = array_column($tags, 'value');
                $opt['tags'] = implode(',', $tags);
            }
            if ($request->has('negative_tags')){
                $tags = (array) json_decode($request->negative_tags);
                $tags = array_column($tags, 'value');
                $opt['negative_tags'] = implode(',', $tags);
            }

            $end_date = $request->get('end_date').' '.$request->end_date_time;
            $opt['end_time'] = strtotime($end_date);
            $start_date = $request->get('start_date').' '.$request->start_date_time;
            $opt['start_time'] = strtotime($start_date);

            $opt['budget_type'] =  $request->get('budget_type');
            $opt['budget_planned'] =  $request->get('budget_planned');
            $result = $this->api->create_adset($opt)->post();
            if (isset($result['status']) and $result['status'] == 'success')
                return redirect()->route('adset.index', app()->getLocale())->with('success', __('adnetwork.successfully_created'));
            else
                return redirect()->back()->withInput()->with('error', __('adnetwork.something_went_wrong'));

        }
        $campaigns = $this->api->get_campaign(['user_id' => auth_id()])->post();
        if (isset($campaigns['status']) and $campaigns['status'] == 'success')
            $campaigns = $campaigns['data']['rows'];
        else
            return redirect()->route('adset.index', app()->getLocale())->with('error', __('adnetwork.you_havenot_any_active_campaign'));


        return view('adset.create', compact('campaigns'));
    }


}
