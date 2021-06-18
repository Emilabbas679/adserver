<?php

namespace App\Http\Controllers;

use App\Http\Helpers\PaginationLinks;
use Illuminate\Http\Request;

class CampaignController extends Controller
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

        $opt = ["limit"=>10, "page"=>$page, 'calculated'=> 1];
        if (auth_group_id() != 1)
            $opt['user_id'] = auth_id();

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
        if ($request->has('user_id') and $request->user_id != '' and $request->user_id != '0'){
            $opt['user_id'] = $request->user_id;
            $user_get = "&user_id=".$opt['user_id'];
            $user_api = $this->api->get_user(['user_id'=>$opt['user_id']])->post();
            if (!isset($user_api['status']) or (isset($user_api['status']) and $user_api['status'] == 'failed'))
                return redirect()->route('campaign.index', app()->getLocale())->with('error', __('notification.user_not_found'));
            $user_api = $user_api['data'][0];
        }


        $data = $this->api->get_campaign($opt)->post();
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
        return view('campaign.index', compact('pagination', 'page', 'cur_page', 'items', 'request','user_api'));
    }

    public function edit(Request $request, $lang, $id)
    {

        if ($request->isMethod('post'))
        {
            $opt = ['campaign_id'=>$id,'change_user_id'=>auth_id(),'name' => $request->name,'user_id' => $request->user_id, 'agency_id' => $request->agency_id];
            $upd = $this->api->update_campaign($opt)->post();
            if (isset($upd['status']) and $upd['status'] == 'success')
                return redirect()->route('campaign.index', app()->getLocale())->with(['success'=>__('adnetwork.successfully_updated')]);
            return redirect()->back()->with(['error'=>__('adnetwork.something_went_wrong')]);

        }
        $item = $this->api->get_campaign(['campaign_id'=>$id])->post();
        if (isset($item['status']) and $item['status'] == 'success')
        {
            $item = $item['data']['rows'][0];
            if (auth_group_id()!= 1 and $item['user_id'] != auth_id())
                return redirect()->route('campaign.index', app()->getLocale())->with(['error'=>__('adnetwork.not_found')]);
            if ($item['user_id'] == 0 )
                $user = ['user_id' => 0, 'email'=> __('notification.no_user')];
            else{
                $user_item = $this->api->get_user(['user_id'=>$item['user_id']])->post();
                $user = $user_item['data'][0];
            }
            if ($item['agency_id'] == 0)
                $agency = ['agency_id'=>0, 'agency_name' => __('notification.no_agency')];
            else{
                $agency_item = $this->api->get_agency(['agency_id'=>$item['agency_id']])->post();
                $agency = $agency_item['data']['rows'][0];
            }


            $page['title'] = $item['name'];
            $page['form']['action'] = route('campaign.edit', ['lang' => app()->getLocale(), 'id'=>$item['campaign_id']]);
            $page['form']['method'] = 'post';
            $page['breadcrumbs'][] = ['route' => route('home'), 'title' => 'Smartbee', 'breadcrumbs' => true];
            $page['breadcrumbs'][] = ['route' => route('campaign.index', app()->getLocale()), 'title' => __('adnetwork.campaign_list'), 'breadcrumbs' => true];
            $page['breadcrumbs'][] = ['title' => $item['name'], 'breadcrumbs' => false];

            $form = [];
            $form[] = ['type' => 'input:text', 'required' => 1, 'id'=>'name','name'=>'name', 'title' => __('adnetwork.campaign_name'), 'value'=>$item['name']];
            $form[] = ['type' => 'select2', 'id'=>'users', 'name'=>'user_id', 'title'=> __('adnetwork.userid'), 'placeholder' => __('placeholders.userid'), 'options' =>[['id'=>$user['user_id'], 'text' => $user['email'],'selected' => 1 ]]];
            $form[] = ['type' => 'select2', 'id'=>'agencies', 'name'=>'agency_id', 'title'=> __('adnetwork.agency'), 'placeholder' => __('placeholders.agency'), 'options' =>[['id'=>$agency['agency_id'], 'text' => $agency['agency_name'],'selected' => 1 ]]];
            return view('form', compact('form', 'page'));

        }
        else
            return redirect()->route('campaign.index', app()->getLocale())->with(['error', __('notification.not_found')]);

    }

    public function statusUpdate(Request $request, $lang,$campaign_id, $status_id)
    {
        $upd = $this->api->update_campaign_status(['campaign_id' => $campaign_id, 'status_id' => $status_id])->post();
        if (isset($upd['status']) and $upd['status'] == 'success')
            return redirect()->route('campaign.index', app()->getLocale())->with('success', __('notification.successfully_updated'));
        else
            return redirect()->back()->with(['error'=>__('notification.something_went_wrong')]);
    }

    public function statistics(Request $request, $lang, $id)
    {
        $start_date = '01'.date('.m.Y');
        $end_date = date('d.m.Y');
        $stats_type = 'get_spent_ad';
        $opt = ['campaign_id' => $id, 'start_date' => $start_date, 'end_date' => $end_date, 'stats_type' => $stats_type];
        $data = $this->api->click_impression_stats($opt)->post();
        $items = $data['data']['stats'];
        $campaign = $this->api->get_campaign(['campaign_id' => $id])->post();
        $campaign = $campaign['data']['rows'][0];
        return view('campaign.statistics', compact('request', 'items', 'campaign'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')){
            $request->validate([
                'name' => ['required', 'string'],
                'user_id' => ['required', 'string'],
            ],
                [
                    'name.required' => __('adnetwork.name_is_required'),
                    'user_id.required' => __('adnetwork.user_is_required'),
                ]
            );
            $opt = ['name' => $request->name, 'user_id' => $request->user_id, 'agency_id' => $request->agency_id];
            $result = $this->api->create_campaign($opt)->post();
            if (isset($result['status']) and $result['status'] == 'success')
                return redirect()->route('campaign.index', app()->getLocale())->with('success', __('adnetwork.successfully_created'));
            return redirect()->back()->with('error', __('adnetwork.something_went_wrong'));
        }

        $page['title'] = __('adnetwork.campaign_add');
        $page['form']['action'] = route('campaign.create', app()->getLocale());
        $page['form']['method'] = 'post';
        $page['breadcrumbs'][] = ['route' => route('home'), 'title' => 'Smartbee', 'breadcrumbs' => true];
        $page['breadcrumbs'][] = ['route' => route('campaign.index', app()->getLocale()), 'title' => __('adnetwork.campaign_list'), 'breadcrumbs' => true];
        $page['breadcrumbs'][] = ['title' => __('adnetwork.campaign_add'), 'breadcrumbs' => false];


        $form = [];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id'=>'name','name'=>'name', 'title' => __('adnetwork.campaign_name'), 'value'=>old('name')];
        if (auth_group_id() == 1)
            $form[] = ['type' => 'select2', 'id'=>'users', 'name'=>'user_id', 'title'=> __('adnetwork.userid'), 'placeholder' => __('adnetwork.userid'), 'options' =>[]];
        else
            $form[] = ['type' => 'input:hidden', 'id'=>'user_id', 'name'=>'user_id', 'title'=> __('adnetwork.userid'), 'placeholder' => __('adnetwork.userid'), 'value' =>auth_id()];

        $form[] = ['type' => 'select2', 'id'=>'agencies', 'name'=>'agency_id', 'title'=> __('adnetwork.agency'), 'placeholder' => __('adnetwork.agency'), 'options' =>[['id'=>0, 'text' => __('adnetwork.no_agency'),'selected' => 1 ]]];

        return view('form', compact('form', 'page'));
    }
}
