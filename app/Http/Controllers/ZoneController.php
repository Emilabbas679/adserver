<?php

namespace App\Http\Controllers;

use App\Http\Helpers\PaginationLinks;
use Illuminate\Http\Request;

class ZoneController extends Controller
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
        $format = '';
        if ($request->has('format_type_id') and $request->format_type_id != '0'){
            $opt['format_type_id'] = $request->format_type_id;
            $format = "&format_type_id=".$opt['format_type_id'];
        }
        $dimension = '';
        if ($request->has('dimension_id') and $request->dimension_id != '0'){
            $opt['dimension_id'] = $request->dimension_id;
            $dimension = "&dimension_id=".$opt['dimension_id'];
        }
        $status = '';
        if ($request->has('status_id') and $request->status_id != '' and $request->status_id != '0'){
            $opt['status_id'] = $request->status_id;
            $status = "&status_id=".$opt['status_id'];
        }

        $data = $this->api->get_slot($opt)->post();
        $items = [];
        $cur_page = $page;
        $pagination = '';
        if (isset($data['status']) and $data['status'] == 'success') {
            $items = $data['data']['rows'];
            $count = $data['data']['count'];
            $pages = ceil($count/10);
            if (count($items) > 0 )
                $pagination = PaginationLinks::paginationCreate($cur_page,$pages,2,
                    '<li class="page-item"><a class="page-link" href="?page=%d'.$status.$format.$dimension.'">%d</a></li>',
                );
        }
        return view('zone.index', compact('pagination', 'page', 'cur_page', 'items', 'request'));
    }


    public function create(Request $request, $lang)
    {
        $sites = $this->api->get_site(['user_id' => auth()->id(), 'status_id' => 11, 'limit' => 100])->post();
        if (isset($sites['status']) and isset($sites['data']) and $sites['data']['count'] > 0)
            $sites = $sites['data']['rows'];
        else
            return redirect()->route('zone.index', app()->getLocale())->with('error', __('adnetwork.slot_404'));

        if ($request->isMethod('post')){
            $request->validate([
                'name' => ['required', 'string'],
            ],
                [
                    'name.required' => __('adnetwork.error_name'),
                ]
            );
            $opt = [
                'site_id' => $request->site_id,
                'name' => $request->name,
                'format_type_id' => $request->format_type_id,
                'dimension_id' => $request->dimension_id,
                'model_id' => $request->model_id,
                'eligible_period' => $request->eligible_period,
                'spent_cpm' => $request->spent_cpm,
                'spent_cpc' => $request->spent_cpc,
                'earning_cpm' => $request->earning_cpm,
                'earning_cpc' => $request->earning_cpc,
                'ad_id' => $request->ad_id,
                'adserving' => $request->adserving,
                'user_id' => auth()->id()
            ];
            $data = $this->api->create_slot($opt)->post();
            if (isset($data['status']) and $data['status'] == 'success')
                return redirect()->route('zone.index', app()->getLocale())->with('success', __('adnetwork.successfully_created'));
            else{
                $messages = [];
                if (isset($data['messages']))
                    $messages = $data['messages'];
                return redirect()->back()->withInput()->with(['error' => __('adnetwork.something_went_wrong'), 'messages' => $messages]);
            }
        }


        $page['title'] = __('adnetwork.publisher_zone_add');
        $page['form']['action'] = route('zone.create', ['lang' => app()->getLocale()]);
        $page['form']['method'] = 'post';
        $page['breadcrumbs'][] = ['route' => route('home'), 'title' => 'Smartbee', 'breadcrumbs' => true];
        $page['breadcrumbs'][] = ['route' => route('zone.index', app()->getLocale()), 'title' => __('adnetwork.publisher_zone_list'), 'breadcrumbs' => true];
        $page['breadcrumbs'][] = ['title' => $page['title'], 'breadcrumbs' => false];


        $form = [];
        $site_options = [];
        foreach ($sites as $item){
            $site_options[] = [
                'selected' => 0,
                'id' => $item['site_id'],
                'text' => $item['name']
            ];
        }

        $form[] = ['type' => 'select2', 'required' => 1, 'id' => 'site_id', 'name' => 'site_id', 'title' => __('adnetwork.site_name'), 'value' => old('site_name'), 'placeholder' => '', 'options' => $site_options];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'name', 'name' => 'name', 'title' => __('adnetwork.zone_name'), 'value' => old('name'), 'placeholder' => __('adnetwork.zone_name')];
        $form[] = ['type' => 'select2', 'required' => 1, 'id' => 'format_type_id', 'name' => 'format_type_id', 'title' => __('adnetwork.format_type_id'), 'value' => old('format_type_id'), 'placeholder' => '', 'options' => [
            ['selected' => 0, 'id' => '0', 'text' => __('adnetwork.all_banner')],
            ['selected' => 0, 'id' => '12', 'text' => __('adnetwork.ad_static_name_12')],
            ['selected' => 0, 'id' => '15', 'text' => __('adnetwork.ad_static_name_15')],
            ['selected' => 0, 'id' => '83', 'text' => __('adnetwork.ad_static_name_83')],
            ['selected' => 0, 'id' => '260', 'text' => __('adnetwork.ad_static_name_260')],
            ['selected' => 0, 'id' => '261', 'text' => __('adnetwork.ad_static_name_261')],
        ]];


        $form[] = ['type' => 'select2', 'required' => 1, 'id' => 'dimension_id', 'name' => 'dimension_id', 'title' => __('adnetwork.dimension_id'), 'value' => '', 'placeholder' => '', 'options' => [
            ['selected' => 0, 'id' => '3', 'text' => '728x90'],
            ['selected' => 0, 'id' => '5', 'text' => '320x100'],
            ['selected' => 0, 'id' => '6', 'text' => '300x600'],
            ['selected' => 1, 'id' => '7', 'text' => '300x250'],
            ['selected' => 0, 'id' => '12', 'text' => '468x60'],
            ['selected' => 0, 'id' => '16', 'text' => '240x400'],
            ['selected' => 0, 'id' => '17', 'text' => '160x600'],
            ['selected' => 0, 'id' => '30', 'text' => __('adnetwork.ad_static_dimension_name_30')],
        ]];
        $form[] = ['type' => 'select2', 'required' => 1, 'id' => 'model_id', 'name' => 'model_id', 'title' => __('adnetwork.model_id'), 'value' => '', 'placeholder' => '', 'options' => [
            ['selected' => 1, 'id' => '0', 'text' => __('adnetwork.all')],
            ['selected' => 0, 'id' => '1', 'text' => 'CPC'],
            ['selected' => 0, 'id' => '2', 'text' => 'CPM'],
            ['selected' => 0, 'id' => '4', 'text' => 'CPV'],
        ]];

        $form[] = ['type' => 'select2', 'required' => 1, 'id' => 'eligible_period', 'name' => 'eligible_period', 'title' => __('adnetwork.eligible_period'), 'value' => '', 'placeholder' => '', 'options' => [
            ['selected' => 0, 'id' => '0', 'text' => __('adnetwork.all')],
            ['selected' => 0, 'id' => '10', 'text' => __('adnetwork.10_seconds')],
            ['selected' => 0, 'id' => '15', 'text' => __('adnetwork.15_seconds')],
            ['selected' => 0, 'id' => '30', 'text' => __('adnetwork.30_seconds')],
            ['selected' => 0, 'id' => '60', 'text' => __('adnetwork.1_minute')],
            ['selected' => 0, 'id' => '180', 'text' => __('adnetwork.3_minute')],
            ['selected' => 0, 'id' => '300', 'text' => __('adnetwork.5_minutes')],
            ['selected' => 0, 'id' => '600', 'text' => __('adnetwork.10_minute')],
            ['selected' => 0, 'id' => '900', 'text' => __('adnetwork.15_minutes')],
            ['selected' => 0, 'id' => '1200', 'text' => __('adnetwork.20_minutes')],
            ['selected' => 0, 'id' => '1800', 'text' => __('adnetwork.30_minutes')],
            ['selected' => 0, 'id' => '3600', 'text' => __('adnetwork.one_hours')],
            ['selected' => 0, 'id' => '7200', 'text' => __('adnetwork.two_hours')],
            ['selected' => 0, 'id' => '14400', 'text' => __('adnetwork.four_hours')],
            ['selected' => 0, 'id' => '21600', 'text' => __('adnetwork.six_hours')],
            ['selected' => 0, 'id' => '33200', 'text' => __('adnetwork.twelve_hours')],
            ['selected' => 0, 'id' => '86400', 'text' => __('adnetwork.one_days')],
            ['selected' => 0, 'id' => '604800', 'text' => __('adnetwork.one_week')],
            ['selected' => 0, 'id' => '2592000', 'text' => __('adnetwork.one_month')],

        ]];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'spent_cpm', 'name' => 'spent_cpm', 'title' => __('adnetwork.spent_cpm'), 'value' => '0.2', 'placeholder' => ''];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'spent_cpc', 'name' => 'spent_cpc', 'title' => __('adnetwork.spent_cpc'), 'value' => '0.2', 'placeholder' => ''];

        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'earning_cpm', 'name' => 'earning_cpm', 'title' => __('adnetwork.earning_cpm'), 'value' => '0.05', 'placeholder' => ''];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'earning_cpc', 'name' => 'earning_cpc', 'title' => __('adnetwork.earning_cpc'), 'value' => '0.05', 'placeholder' => ''];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'ad_id', 'name' => 'ad_id', 'title' => __('adnetwork.ad_id'), 'value' => '0', 'placeholder' => ''];
        $form[] = ['type' => 'select2', 'required' => 1, 'id' => 'adserving', 'name' => 'adserving', 'title' => __('adnetwork.adserving'), 'value' => old('adserving'), 'placeholder' => '', 'options' => [
            ['selected' => 0, 'id' => '0', 'text' => __('adnetwork.standard') ],
            ['selected' => 0, 'id' => '1', 'text' => __('adnetwork.adserving') ],
        ]];

        return view('form', compact('request', 'page' ,'form'));
    }

    public function status(Request $request,$lang, $id, $status_id)
    {

        $item = $this->api->get_slot(['slot_id' => $id])->post();
        if (isset($item['status']) and $item['status'] == 'success' and count($item['data']['rows']) > 0) {
            $item = $item['data']['rows'][0];
            $opt = ['user_id' => $item['user_id'], 'slot_id' => $id, 'status_id' => $status_id];
            $result = $this->api->update_slot_status($opt)->post();
            if (isset($result['status']) and $result['status'] == 'success')
                return redirect()->route('zone.index', app()->getLocale())->with('success', __('adnetwork.successfully_updated'));
            else
                return redirect()->route('zone.index', app()->getLocale())->with('error', __('adnetwork.something_went_wrong'));
        }
        return redirect()->route('zone.index', app()->getLocale())->with('error', __('adnetwork.slot_not_found'));
    }


    public function edit(Request $request, $lang, $id){
        $item = $this->api->get_slot(['slot_id' => $id])->post();
        if (isset($item['status']) and $item['status'] == 'success' and count($item['data']['rows']) > 0)
            $item = $item['data']['rows'][0];
        else
            return redirect()->route('zone.index', app()->getLocale())->with('error', __('adnetwork.slot_not_found'));



        if ($request->isMethod('post')){
            $request->validate([
                'name' => ['required', 'string'],
            ],
                [
                    'name.required' => __('adnetwork.error_name'),
                ]
            );
            $opt = [
                'site_id' => $item['site_id'],
                'name' => $request->name,
                'format_type_id' => $item['format_type_id'],
                'dimension_id' => $item['dimension_id'],
                'model_id' => $request->model_id,
                'eligible_period' => $request->eligible_period,
                'spent_cpm' => $request->spent_cpm,
                'spent_cpc' => $request->spent_cpc,
                'earning_cpm' => $request->earning_cpm,
                'earning_cpc' => $request->earning_cpc,
                'ad_id' => $request->ad_id,
                'adserving' => $request->adserving,
                'user_id' => auth()->id(),
                'slot_id' => $id,
            ];

            $data = $this->api->update_slot($opt)->post();
            if(isset($data['status']) and $data['status'] == 'success')
                return redirect()->route('zone.index', app()->getLocale())->with('success', __('adnetwork.successfully_created'));
            else {
                $messages = [];
                if (isset($data['messages']))
                    $messages = $data['messages'];
                return redirect()->back()->withInput()->with(['error' => __('adnetwork.something_went_wrong'), 'messages' => $messages]);
            }
        }

        $page['title'] = $item['name'];
        $page['form']['action'] = route('zone.edit', ['lang' => app()->getLocale(), 'id' => $item['slot_id']]);
        $page['form']['method'] = 'post';
        $page['breadcrumbs'][] = ['route' => route('home'), 'title' => 'Smartbee', 'breadcrumbs' => true];
        $page['breadcrumbs'][] = ['route' => route('zone.index', app()->getLocale()), 'title' => __('adnetwork.publisher_zone_list'), 'breadcrumbs' => true];
        $page['breadcrumbs'][] = ['title' => $page['title'], 'breadcrumbs' => false];


        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'name', 'name' => 'name', 'title' => __('adnetwork.zone_name'), 'value' => $item['name'], 'placeholder' => __('adnetwork.zone_name')];
        $form[] = ['type' => 'select2', 'required' => 1, 'id' => 'format_type_id', 'name' => 'format_type_id', 'title' => __('adnetwork.format_type_id'), 'value' => $item['format_type_id'], 'placeholder' => '', 'disabled' => 1, 'options' => [
            ['selected' => ($item['format_type_id'] =='0') ? 1 : 0, 'id' => '0', 'text' => __('adnetwork.all_banner')],
            ['selected' => ($item['format_type_id'] =='12') ? 1 : 0, 'id' => '12', 'text' => __('adnetwork.ad_static_name_12')],
            ['selected' => ($item['format_type_id'] =='15') ? 1 : 0, 'id' => '15', 'text' => __('adnetwork.ad_static_name_15')],
            ['selected' => ($item['format_type_id'] =='83') ? 1 : 0, 'id' => '83', 'text' => __('adnetwork.ad_static_name_83')],
            ['selected' => ($item['format_type_id'] =='260') ? 1 : 0, 'id' => '260', 'text' => __('adnetwork.ad_static_name_260')],
            ['selected' => ($item['format_type_id'] =='261') ? 1 : 0, 'id' => '261', 'text' => __('adnetwork.ad_static_name_261')],
        ]];


        $form[] = ['type' => 'select2', 'required' => 1, 'id' => 'dimension_id', 'name' => 'dimension_id', 'title' => __('adnetwork.dimension_id'), 'value' => $item['dimension_id'], 'placeholder' => '','disabled' => 1, 'options' => [
            ['selected' => ($item['dimension_id'] =='3') ? 1 : 0, 'id' => '3', 'text' => '728x90'],
            ['selected' => ($item['dimension_id'] =='5') ? 1 : 0, 'id' => '5', 'text' => '320x100'],
            ['selected' => ($item['dimension_id'] =='6') ? 1 : 0, 'id' => '6', 'text' => '300x600'],
            ['selected' => ($item['dimension_id'] =='7') ? 1 : 0, 'id' => '7', 'text' => '300x250'],
            ['selected' => ($item['dimension_id'] =='12') ? 1 : 0, 'id' => '12', 'text' => '468x60'],
            ['selected' => ($item['dimension_id'] =='16') ? 1 : 0, 'id' => '16', 'text' => '240x400'],
            ['selected' => ($item['dimension_id'] =='17') ? 1 : 0, 'id' => '17', 'text' => '160x600'],
            ['selected' => ($item['dimension_id'] =='30') ? 1 : 0, 'id' => '30', 'text' => __('adnetwork.ad_static_dimension_name_30')],
        ]];
        $form[] = ['type' => 'select2', 'required' => 1, 'id' => 'model_id', 'name' => 'model_id', 'title' => __('adnetwork.model_id'), 'value' => $item['model_id'], 'placeholder' => '', 'options' => [
            ['selected' => ($item['model_id'] =='0') ? 1 : 0, 'id' => '0', 'text' => __('adnetwork.all')],
            ['selected' => ($item['model_id'] =='1') ? 1 : 0, 'id' => '1', 'text' => 'CPC'],
            ['selected' => ($item['model_id'] =='2') ? 1 : 0, 'id' => '2', 'text' => 'CPM'],
            ['selected' => ($item['model_id'] =='4') ? 1 : 0, 'id' => '4', 'text' => 'CPV'],
        ]];

        $form[] = ['type' => 'select2', 'required' => 1, 'id' => 'eligible_period', 'name' => 'eligible_period', 'title' => __('adnetwork.eligible_period'), 'value' => $item['eligible_period'], 'placeholder' => '', 'options' => [
            ['selected' => ($item['eligible_period'] =='0') ? 1 : 0, 'id' => '0', 'text' => __('adnetwork.all')],
            ['selected' => ($item['eligible_period'] =='10') ? 1 : 0, 'id' => '10', 'text' => __('adnetwork.10_seconds')],
            ['selected' => ($item['eligible_period'] =='15') ? 1 : 0, 'id' => '15', 'text' => __('adnetwork.15_seconds')],
            ['selected' => ($item['eligible_period'] =='30') ? 1 : 0, 'id' => '30', 'text' => __('adnetwork.30_seconds')],
            ['selected' => ($item['eligible_period'] =='60') ? 1 : 0, 'id' => '60', 'text' => __('adnetwork.1_minute')],
            ['selected' => ($item['eligible_period'] =='180') ? 1 : 0, 'id' => '180', 'text' => __('adnetwork.3_minute')],
            ['selected' => ($item['eligible_period'] =='300') ? 1 : 0, 'id' => '300', 'text' => __('adnetwork.5_minutes')],
            ['selected' => ($item['eligible_period'] =='600') ? 1 : 0, 'id' => '600', 'text' => __('adnetwork.10_minute')],
            ['selected' => ($item['eligible_period'] =='900') ? 1 : 0, 'id' => '900', 'text' => __('adnetwork.15_minutes')],
            ['selected' => ($item['eligible_period'] =='1200') ? 1 : 0, 'id' => '1200', 'text' => __('adnetwork.20_minutes')],
            ['selected' => ($item['eligible_period'] =='1800') ? 1 : 0, 'id' => '1800', 'text' => __('adnetwork.30_minutes')],
            ['selected' => ($item['eligible_period'] =='3600') ? 1 : 0, 'id' => '3600', 'text' => __('adnetwork.one_hours')],
            ['selected' => ($item['eligible_period'] =='7200') ? 1 : 0, 'id' => '7200', 'text' => __('adnetwork.two_hours')],
            ['selected' => ($item['eligible_period'] =='14400') ? 1 : 0, 'id' => '14400', 'text' => __('adnetwork.four_hours')],
            ['selected' => ($item['eligible_period'] =='21600') ? 1 : 0, 'id' => '21600', 'text' => __('adnetwork.six_hours')],
            ['selected' => ($item['eligible_period'] =='33200') ? 1 : 0, 'id' => '33200', 'text' => __('adnetwork.twelve_hours')],
            ['selected' => ($item['eligible_period'] =='86400') ? 1 : 0, 'id' => '86400', 'text' => __('adnetwork.one_days')],
            ['selected' => ($item['eligible_period'] =='604800') ? 1 : 0, 'id' => '604800', 'text' => __('adnetwork.one_week')],
            ['selected' => ($item['eligible_period'] =='2592000') ? 1 : 0, 'id' => '2592000', 'text' => __('adnetwork.one_month')],

        ]];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'spent_cpm', 'name' => 'spent_cpm', 'title' => __('adnetwork.spent_cpm'), 'value' => $item['spent_cpm'], 'placeholder' => ''];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'spent_cpc', 'name' => 'spent_cpc', 'title' => __('adnetwork.spent_cpc'), 'value' => $item['spent_cpc'], 'placeholder' => ''];

        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'earning_cpm', 'name' => 'earning_cpm', 'title' => __('adnetwork.earning_cpm'), 'value' => $item['earning_cpm'], 'placeholder' => ''];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'earning_cpc', 'name' => 'earning_cpc', 'title' => __('adnetwork.earning_cpc'), 'value' =>$item['earning_cpc'], 'placeholder' => ''];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'ad_id', 'name' => 'ad_id', 'title' => __('adnetwork.ad_id'), 'value' => $item['ad_id'], 'placeholder' => ''];
        $form[] = ['type' => 'select2', 'required' => 1, 'id' => 'adserving', 'name' => 'adserving', 'title' => __('adnetwork.adserving'), 'value' => $item['adserving'], 'placeholder' => '', 'options' => [
            ['selected' => ($item['adserving'] =='0') ? 1 : 0, 'id' => '0', 'text' => __('adnetwork.standard') ],
            ['selected' => ($item['adserving'] =='1') ? 1 : 0, 'id' => '1', 'text' => __('adnetwork.adserving') ],
        ]];

        return view('form', compact('item', 'request', 'page' ,'form'));
    }
}
