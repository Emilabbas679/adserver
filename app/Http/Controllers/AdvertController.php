<?php

namespace App\Http\Controllers;

use App\Http\Helpers\PaginationLinks;
use Illuminate\Http\Request;

class AdvertController extends Controller
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
        $user_api = [];
        $user_get = '';
        if ($request->has('user_id') and $request->user_id != '' and $request->user_id != 0){
            $opt['user_id'] = $request->user_id;
            $user_get = "&user_id=".$opt['user_id'];
            $user_api = $this->api->get_user(['user_id'=>$opt['user_id']])->post();
            if (!isset($user_api['status']) or (isset($user_api['status']) and $user_api['status'] == 'failed'))
                return redirect()->route('advert.index', app()->getLocale())->with('error', __('notification.user_not_found'));
            $user_api = $user_api['data'][0];
        }

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
        $format = '';
        if ($request->has('format_type_id') and $request->format_type_id != ''){
            $opt['format_type_id'] = $request->format_type_id;
            $format = "&format_type_id=".$opt['format_type_id'];
        }



        $data = $this->api->get_ad($opt)->post();
        $items = [];
        $cur_page = $page;
        $pagination = '';
        if (isset($data['status']) and $data['status'] == 'success') {
            $items = $data['data']['rows'];
            $count = $data['data']['count'];
            $pages = round($count/10);
            if (count($items) > 0 )
                $pagination = PaginationLinks::paginationCreate($cur_page,$pages,2,
                    '<li class="page-item"><a class="page-link" href="?page=%d'.$status.$query.$user_get.$format.'">%d</a></li>',
                );
        }
        return view('advert.index', compact('pagination', 'page', 'cur_page', 'items', 'request','user_api'));

    }



    public function statistic(Request $request,$lang, $id, $type)
    {

        $start_date = "01.".date('m.Y');
        $end_date = date('d.m.Y');
        $stats_type = "get_spent_ad";
        $diff=date_diff(date_create($start_date), date_create($end_date));
        $diff = $diff->format('%a')+1;
        $page = 1;
        $limit = 100;


        if ($request->has('start_date') and $request->start_date  != '')
            $start_date = $request->start_date;

        if ($request->has('end_date') and $request->start_date  != '')
            $end_date = $request->end_date;

        if ($request->has('stats_type') and $request->stats_type != '')
            $stats_type = $request->stats_type;


        if ($stats_type == 'get_spent_ad_archive')
            $limit = $diff;
        $opt = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'stats_type' => $stats_type,
            'limit' => $limit,
            'page' => $page,
        ];

        if ($type == 'advert') {
            $ad = $this->api->send('get_ad',['ad_id'=>$id]);
            $ad = $ad['data']['rows'][0];
            $opt['campaign_id'] = $ad['campaign_id'];
            $opt['ad_id'] = $id;
        }
        elseif ($type == 'campaign')
            $opt['campaign_id'] = $id;
        elseif($type == 'adset')
            $opt['set_id'] = $id;
        else
            abort(404);


        $result = $this->api->click_impression_stats($opt)->post();

        if (isset($result['status']) and $result['status'] == 'success') {
            $items = $result['data']['stats'];
//            dd($items);
            return view('advert.statistic', compact('items' , 'request', 'id', 'stats_type'));

        }
        return redirect()->route('advert.index', app()->getLocale())->with('error', __('adnetwork.something_went_wrong'));
    }


    public function edit(Request $request, $lang, $id)
    {
        dd($lang);
    }

}
