<?php

namespace App\Http\Controllers;

use App\Http\Helpers\PaginationLinks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use File;

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

    public function create(Request $request)
    {
        if ($request->isMethod('post')){
            $request->validate([
                'name' => ['required', 'string'],
                'target_url' => ['required', 'string'],

            ],
                [
                    'name.required' => __('notification.ads_name_is_required'),
                    'target_url.required' => __('notification.target_url_is_required'),
                ]
            );
            $sites = [];
            $excluded = [];
            if (isset($request->sites))
                $sites = $request->sites;
            if (isset($request->forbidden_sites))
                $excluded = $request->forbidden_sites;

            $frequency_period = 'day';
            if ($request->frequency_period != '')
                $frequency_period = $request->frequency_period;

            $capping = 0;
            if ($request->frequency_capping != '')
                $capping = $request->frequency_capping;


            $opt = [
                'set_id' => $request->set_id,
                'user_id' => auth()->id(),
                'campaign_id' => $request->campaign_id,
                'name' => $request->name,
                "ad_url" => $request->target_url,
                "format_type_id" => $request->get('format'),
                "dimension_id" => $request->dimension_id,
                'text' => $request->text,
                'display_name' => $request->display_name,
                'model_id' => $request->model_id,
                'budget_level' => $request->budget_level,
                'budget_type' => $request->budget_type,
                'budget_planned' => $request->budget_planned,
                'unit_cost_min' => $request->unit_cost_min,
                'unit_cost_max' => $request->unit_cost_max,
                "status_description" => "approve_ad",
                "no_earning" => $request->no_earning,
                'no_spent' => $request->no_spent,
                'ref_user_id' => $request->ref_user_id,
                "ref_share_rate" => $request->ref_share_rate,
                "frequency" => $request->frequency,
                "accelerated" => $request->accelerated,

                'targeting'=>[
                    "frequency_capping" => $capping,
                    'week_day_hours' => json_encode($request->week_day_hours),
                    "frequency_period" =>  $frequency_period,
                    "site" => json_encode($sites),
                    "excluded_site" => json_encode($excluded),
                ],
            ];

            if ($request->has('frequency'))
                $opt['targeting']['frequency'] = 1;

            $result = $this->api->create_ad($opt)->post();
            if (isset($result['status']) and $result['status'] == 'success') {
                if (isset($result['status']) and $result['status'] == 'success') {
                    $ad_id = $result['data']['ad_id'];
                    $opt['ad_id'] = $ad_id;
                    if ($request->has('file')) {
                        $file = trim( $request->file, '"');
                        $file = stripslashes($file);
                        $file = public_path($file);
                        if (is_file($file)) {
                            $mime = mime_content_type($file);
                            $ext = array_reverse(explode('.', $file))[0];
                            $time = time();
                            $new_file =  public_path('uploads/adverts/'.$time.'-'.str_replace(' ', '-', $request->name).'.'.$ext);
                            $filename = env('APP_URL')."/public/uploads/adverts/$time".'-'.strtolower(str_replace(' ', '-', $request->name)).'.'.$ext;
                            $filesize = filesize($file);
                            File::move($file, $new_file);
                            $opt['file_data'] = json_encode(
                                [
                                    'html' => null,
                                    'dir_url' => $filename,
                                    'down_url' => $filename,
                                    'id' => $ad_id,
                                    'ad_id' =>$ad_id,
                                    'size' => $filesize,
                                    'format' => $mime,
                                    'type' => $mime,
                                    'dimension_id' => 30,
                                ]
                            );
                        }
                        $r = $this->api->update_ad($opt)->post();
                    }
                }
                return redirect()->route('advert.index', app()->getLocale())->with('success', __('adnetwork.successfully_updated'));
            }
            $messages = $result['messages'];
            return redirect()->back()->withInput()->with(['error' => __('adnetwork.something_went_wrong'), 'messages' => $messages]);
        }

        $campaigns = $this->api->get_campaign(['user_id' => auth()->id()])->post();
        if (isset($campaigns['status']) and $campaigns['status'] == 'success')
            $campaigns = $campaigns['data']['rows'];
        else
            return redirect()->route('adset.index', app()->getLocale())->with('error', __('adnetwork.you_havenot_any_active_campaign'));
        $groups = $this->api->get_adset(['user_id' => auth()->id()])->post();
        if (isset($groups['status']) and $groups['status'] == 'success')
            $groups = $groups['data']['rows'];
        else
            return redirect()->route('advert.index', app()->getLocale())->with('error', __('adnetwork.you_havenot_any_active_group'));

        ;
        $sites = Cache::remember('sites', now()->addMinutes(10), function () {
            $result = $this->api->get_site(['status_id' => 11, 'limit' => 1000])->post();
            return $result['data']['rows'];
        });
        return view('advert.create', compact('sites', 'campaigns', 'groups'));
    }

    public function edit(Request $request, $lang, $id)
    {
        $advert = $this->api->get_one_ad(['ad_id' => $id])->post();
        if ($advert['status'] != 'success')
            return redirect()->route('advert.index', app()->getLocale())->with('error', __('adnetwork.ads_not_found'));
        $item = $advert['data'];


        if ($request->isMethod('post')){
            $request->validate([
                'name' => ['required', 'string'],
                'target_url' => ['required', 'string'],
            ],
                [
                    'name.required' => __('notification.ads_name_is_required'),
                    'target_url.required' => __('notification.target_url_is_required'),
                ]
            );
            $sites = [];
            $excluded = [];
            if (isset($request->sites))
                $sites = $request->sites;
            if (isset($request->forbidden_sites))
                $excluded = $request->forbidden_sites;

            $frequency_period = 'day';
            if ($request->frequency_period != '')
                $frequency_period = $request->frequency_period;

            $capping = 0;
            if ($request->frequency_capping != '')
                $capping = $request->frequency_capping;
            $opt = [
                "ad_id" => $id,
                'set_id' => $item['set_id'],
                'user_id' => auth()->id(),
                'campaign_id' => $item['campaign_id'],
                'name' => $request->name,
                "ad_url" => $request->target_url,
                "format_type_id" => $request->get('format'),
                "dimension_id" => $request->dimension_id,
                'text' => $request->text,
                'display_name' => $request->display_name,
                'model_id' => $request->model_id,
                'budget_level' => $request->budget_level,
                'budget_type' => $request->budget_type,
                'budget_planned' => $request->budget_planned,
                'unit_cost_min' => $request->unit_cost_min,
                'unit_cost_max' => $request->unit_cost_max,
                "status_description" => "approve_ad",
                "no_earning" => $request->no_earning,
                'no_spent' => $request->no_spent,
                'ref_user_id' => $request->ref_user_id,
                "ref_share_rate" => $request->ref_share_rate,
                "frequency" => $request->frequency,
                "accelerated" => $request->accelerated,
                'targeting'=>[
                    "site" => json_encode($sites),
                    "excluded_site" => json_encode($excluded),
                    "frequency_capping" => $capping,
                    'week_day_hours' => json_encode($request->week_day_hours),
                    "frequency_period" =>  $frequency_period,
                ],
            ];

            if ($request->has('frequency'))
                $opt['targeting']['frequency'] = 1;

            if ($request->ads_file == null){

                $item_file = json_decode($item['file_data']);
                if (gettype($item_file) != 'integer') {
                    if (isset($item_file->dir_url) and str_contains($item_file->dir_url,env('APP_URL'))) {
                        $file = str_replace(env('APP_URL').'/public','', $item_file->dir_url);
                        $file = public_path($file);
                        if(is_file($file)) {
                           unlink($file);
                        }
                    }
                    $opt['file_data'] = json_encode([
                        'html' => null,
                        'dir_url' => "",
                        'down_url' => "",
                        'id' => $id,
                        'ad_id' =>$id,
                        'size' => 0,
                        'format' => "",
                        'type' => "",
                    ]);
                }
            }
            else{
                $item_file = json_decode($item['file_data']);
                if (gettype($item_file) != 'integer' and $item_file != null) {
                    if (str_contains($item_file->dir_url,env('APP_URL'))) {
                        $file = str_replace(env('APP_URL').'/public','', $item_file->dir_url);
                        $file = public_path($file);
                        if(is_file($file)) {
                           unlink($file);
                        }
                    }
                }
                if ($item_file == null or $item_file->dir_url != $request->ads_file) {
                    $file = trim( $request->ads_file, '"');
                    $file = stripslashes($file);
                    $file = public_path($file);

                    if (is_file($file)) {
                        $mime = mime_content_type($file);
                        $ext = array_reverse(explode('.', $file))[0];
                        $time = time();
                        $new_file =  public_path('uploads/adverts/'.$time.'-'.str_replace(' ', '-', $request->name).'.'.$ext);
                        $filename = env('APP_URL')."/public/uploads/adverts/$time".'-'.strtolower(str_replace(' ', '-', $request->name)).'.'.$ext;
                        $filesize = filesize($file);
                        File::move($file, $new_file);
                        $opt['file_data'] = json_encode(
                            [
                                'html' => null,
                                'dir_url' => $filename,
                                'down_url' => $filename,
                                'id' => $id,
                                'ad_id' =>$id,
                                'size' => $filesize,
                                'format' => $mime,
                                'type' => $mime,
                                'dimension_id' => 30,
                            ]
                        );
                    }
                }
//                $opt['file_data'] = json_encode([
//                    'html' => null,
//                    'dir_url' => $filename,
//                    'down_url' => $filename,
//                    'id' => $id,
//                    'ad_id' =>$id,
//                    'size' => $filesize,
//                    'format' => $mime,
//                    'type' => $mime,
//                    'dimension_id' => 30,
//                ]);
            }
            $result = $this->api->update_ad($opt)->post();
            if (isset($result['status']) and $result['status'] == 'success')
                return redirect()->route('advert.index', app()->getLocale())->with('success', __('adnetwork.successfully_updated'));
            $messages = $result['messages'];

            return redirect()->back()->withInput()->with(['error' => __('adnetwork.something_went_wrong'), 'messages' => $messages]);
        }



        $s_sites = [];
        $excludeds = [];
        if ($item['targeting']['site'] != null and count((array) json_decode(stripslashes($item['targeting']['site']))) != 0)
            $s_sites = $this->api->get_site(['site_ids' => (array) json_decode($item['targeting']['site'])])->post()['data']['rows'];

        if ($item['targeting']['excluded_site'] != null and count((array) json_decode(stripslashes($item['targeting']['excluded_site']))) != 0)
            $excludeds = $this->api->get_site(['site_ids' => (array) json_decode($item['targeting']['excluded_site'])])->post()['data']['rows'];

        $campaigns = $this->api->get_campaign(['user_id' => auth()->id()])->post();
        if (isset($campaigns['status']) and $campaigns['status'] == 'success')
            $campaigns = $campaigns['data']['rows'];
        else
            return redirect()->route('adset.index', app()->getLocale())->with('error', __('adnetwork.you_havenot_any_active_campaign'));
        $groups = $this->api->get_adset(['user_id' => auth()->id()])->post();
        if (isset($groups['status']) and $groups['status'] == 'success')
            $groups = $groups['data']['rows'];
        else
            return redirect()->route('advert.index', app()->getLocale())->with('error', __('adnetwork.you_havenot_any_active_group'));
        $sites = Cache::remember('sites', now()->addMinutes(10), function () {
            $result = $this->api->get_site(['status_id' => 11, 'limit' => 1000])->post();
            return $result['data']['rows'];
        });
        return view('advert.edit', compact('item', 'campaigns','groups', 'sites', 's_sites', 'excludeds'));
    }

    public function fileUpload(Request $request)
    {
        if($request->hasFile('file')) {
            $fileName = time().'_'.str_replace(' ', '-', $request->file->getClientOriginalName());
            $request->file->move(public_path('/uploads/tmp'), $fileName);
            $data = "/uploads/tmp/$fileName";
        }
        else
            $data = "";
        return json_encode($data);
    }

    public function fileDelete(Request $request)
    {
        return true;
//        return $request->getContent();
    }

    public function statusUpdate($lang, $ad_id, $status_id) {
        $opt = ['ad_id' => $ad_id, 'status_id' => $status_id];
        $method = 'ad_status';
        if ($status_id == 11) {
            $item = $this->api->get_one_ad(['ad_id' => $ad_id])->post();
            if (isset($item['status']) and $item['status'] == 'success') {
                $opt['unit_cost_max'] = $item['data']['unit_cost_max'];
                $opt['unit_cost_min'] = $item['data']['unit_cost_min'];
            }
            else
                return redirect()->route('advert.index', app()->getLocale())->with('error', __('adnetwork.ad_not_found'));
            $method = 'approve_ad';
        }
        $result = $this->api->$method($opt)->post();
        if (isset($result['status']) and $result['status'] == 'success')
            return redirect()->route('advert.index', app()->getLocale())->with('success', __('adnetwork.successfully_updated'));

        $messages = [];
        if (isset($result['messages']))
            $messages = $result['messages'];
        return redirect()->back()->withInput()->with(['error' => __('adnetwork.something_went_wrong'), 'messages' => $messages]);

    }
}
