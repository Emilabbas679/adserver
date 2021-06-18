<?php

namespace App\Http\Controllers;

use App\Http\Helpers\PaginationLinks;
use Illuminate\Http\Request;

class DebitorController extends Controller
{

    public function campaigns(Request $request)
    {
        $pagination = '';
        $page = 1;
        if ($request->has("page"))
            $page = $request->page;
        $agencies = $this->api->get_agency(['limit' => 100])->post()['data']['rows'];
        $agency = '';
        $opt['page'] = $page;
        if ($request->has('agency_id') and $request->agency_id != 'all'){
            $opt['agency_id'] = $request->agency_id;
            $agency = "&agency_id=".$opt['agency_id'];
        }
        $campaign = [];
        $campaign_get = '';
        if ($request->has('campaign_id') and $request->campaign_id != '0'){
            $opt['campaign_id'] = $request->campaign_id;
            $campaign_get = "&campaign_id=".$opt['campaign_id'];
            $campaign = $this->api->get_campaign(['campaign_id'=>$opt['campaign_id']])->post();
            if (!isset($campaign['status']) or (isset($campaign['status']) and $campaign['status'] == 'failed'))
                return redirect()->route('debitor.campaigns', app()->getLocale())->with('error', __('adnetwork.not_found'));
            $campaign = $campaign['data']['rows'][0];
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

        $data = $this->api->get_campaign_finance($opt)->post();
        if (isset($data['status']) and $data['status'] == 'success'){
            $count = $data['data']['count'];
            $items = $data['data']['rows'];
            $pages = ceil($count/10);
            if (count($items) > 0 )
                $pagination = PaginationLinks::paginationCreate($page,$pages,2,
                    '<li class="page-item"><a class="page-link" href="?page=%d'.$agency.$campaign_get.$user_get.'">%d</a></li>',
                );
        }
        else
            abort(404);

        return view('bank.debitor.campaigns', compact('page', 'items', 'pagination', 'request', 'agencies', 'campaign', 'user_api'));
    }


    public function financeCreate(Request $request, $lang, $campaign_id, $agency_id)
    {
        if ($request->isMethod('post')){
            dd($request->all());
        }
        if ($agency_id != 0)
            $opt = ['agency_id' => $agency_id];
        else
            $opt = ['campaign_id' => $campaign_id];
        $opt['limit'] = 1000;
        $data = $this->api->get_campaign_finance($opt)->post();
        if (isset($data['status']) and $data['status'] == 'success')
            $items = $data['data']['rows'];
        else
            return redirect()->route('debitor.campaigns', app()->getLocale())->with('error', __('adnetwork.not_found'));

//        dd($items);
        return view('bank.debitor.debitors', compact('items', 'campaign_id', 'agency_id'));


    }

    public function create(Request $request)
    {
        if ($request->isMethod('post'))
            return $request->all();
        $page['form']['action'] =route('debitor.create', ['lang' => app()->getLocale()]);
        $page['title'] = __('adnetwork.create_debitor');
        $page['form']['method'] = 'post';
        $page['breadcrumbs'][] = ['route' => route('home'), 'title' => 'Smartbee', 'breadcrumbs' => true];
        $page['breadcrumbs'][] = ['title' => $page['title'], 'breadcrumbs' => false];

        return view('bank.debitor.create', compact('page'));
    }


    public function getAgencyDebitors(Request $request, $lang)
    {
        if ($request->agency_id == null)
            return '';

        $opt=['agency_id' => $request->agency_id];
        $result = $this->api->get_finance_agency_debitors($opt)->post();
        $count = ceil($result['data']['count']);
        $items = $result['data']['rows'];
        $page = $request->page;

        return view('partials.debitor', compact('count', 'items', 'page'));
    }
}
