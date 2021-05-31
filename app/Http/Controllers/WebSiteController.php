<?php

namespace App\Http\Controllers;

use App\Http\Helpers\PaginationLinks;
use Illuminate\Http\Request;

class WebSiteController extends Controller
{
    public function __construct()
    {
        $this->api = new API();
    }

    public function index(Request $request, $lang)
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
        if ($request->has('user_id') and $request->user_id != '' and $request->user_id != '0'){
            $opt['user_id'] = $request->user_id;
            $user_get = "&user_id=".$opt['user_id'];
            $user_api = $this->api->get_user(['user_id'=>$opt['user_id']])->post();
            if (!isset($user_api['status']) or (isset($user_api['status']) and $user_api['status'] == 'failed'))
                return redirect()->route('campaign.index', app()->getLocale())->with('error', __('notification.user_not_found'));
            $user_api = $user_api['data'][0];
        }

        $data = $this->api->get_site($opt)->post();
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
        return view('website.index', compact('pagination', 'page', 'cur_page', 'items', 'request','user_api'));

    }

    public function status(Request $request,$lang)
    {
        $site_id = $request->site_id;
        $status_id = $request->status_id;
        $item = $this->api->get_site(['site_id' => $site_id])->post();
        if (isset($item['status']) and $item['status'] == 'success' and count($item['data']['rows']) > 0) {
            $item = $item['data']['rows'][0];
            $opt = ['user_id' => $item['user_id'], 'site_id' => $site_id, 'status_id' => $status_id, 'text' => $request->text];
            $result = $this->api->update_site_status($opt)->post();
            if (isset($result['status']) and  $result['status'] == 'success')
                return redirect()->route('site.index', app()->getLocale())->with('success', __('adnetwork.successfully_updated'));
            else
                return redirect()->route('site.index', app()->getLocale())->with('error', __('adnetwork.something_went_wrong'));
        }
        return redirect()->route('site.index', app()->getLocale())->with('error', __('adnetwork.site_not_found'));
    }


    public function edit(Request $request, $lang, $id){
        $item = $this->api->get_site(['site_id' => $id])->post();
        if (isset($item['status']) and $item['status'] == 'success' and count($item['data']['rows']) > 0)
            $item = $item['data']['rows'][0];
        else
            return redirect()->route('site.index', app()->getLocale())->with('error', __('adnetwork.site_not_found'));


        if ($request->isMethod('post')){
            $request->validate([
                'name' => ['required', 'string'],
                'domain' => ['required', 'string'],
            ],
                [
                    'name.required' => __('adnetwork.error_name'),
                    'domain.required' => __('adnetwork.error_domain'),
                ]
            );
            $opt = ['user_id' => $item['user_id'], 'site_id' => $id, 'domain' => $request->domain, 'name' => $request->name];
            $result = $this->api->update_site($opt)->post();
            if (isset($result['status']) and $result['status'] == 'success')
                return redirect()->route('site.index', app()->getLocale())->with('success', __('adnetwork.successfully_updated'));
            else
                return redirect()->back()->with('error', __('adnetwork.something_went_wrong'));
        }
        $page['title'] = $item['name'];
        $page['form']['action'] = route('site.edit', ['lang' => app()->getLocale(), 'id' => $id]);
        $page['form']['method'] = 'post';
        $page['breadcrumbs'][] = ['route' => route('home'), 'title' => 'Smartbee', 'breadcrumbs' => true];
        $page['breadcrumbs'][] = ['route' => route('site.index', app()->getLocale()), 'title' => __('adnetwork.website_list'), 'breadcrumbs' => true];
        $page['breadcrumbs'][] = ['title' => $page['title'], 'breadcrumbs' => false];
        $form = [];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'name', 'name' => 'name', 'title' => __('adnetwork.website_name'), 'value' => $item['name'], 'placeholder' => ''];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'domain', 'name' => 'domain', 'title' => __('adnetwork.domain'), 'value' => $item['domain'], 'placeholder' => ''];
//        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'spent_cpm', 'name' => 'spent_cpm', 'title' => __('adnetwork.spent_cpm'), 'value' => $item['spent_cpm'], 'placeholder' => ''];
//        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'spent_cpc', 'name' => 'spent_cpc', 'title' => __('adnetwork.spent_cpc'), 'value' => $item['spent_cpc'], 'placeholder' => ''];
//        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'earning_cpm', 'name' => 'earning_cpm', 'title' => __('adnetwork.earning_cpm'), 'value' => $item['earning_cpm'], 'placeholder' => ''];
//        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'earning_cpc', 'name' => 'earning_cpc', 'title' => __('adnetwork.earning_cpc'), 'value' => $item['earning_cpc'], 'placeholder' => ''];
//        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'impressions_max', 'name' => 'impressions_max', 'title' => __('adnetwork.impressions_max'), 'value' => $item['impressions_max'], 'placeholder' => '0'];
//        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'clicks_max', 'name' => 'clicks_max', 'title' => __('adnetwork.clicks_max'), 'value' => $item['clicks_max'], 'placeholder' => '0'];
//        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'clicks_max', 'name' => 'earnings_max', 'title' => __('adnetwork.earnings_max'), 'value' => $item['earnings_max'], 'placeholder' => '0'];
        return view('form', compact('item', 'request', 'page' ,'form'));
    }
}
