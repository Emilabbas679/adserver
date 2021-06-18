<?php

namespace App\Http\Controllers;

use App\Http\Helpers\PaginationLinks;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    public function index(Request $request)
    {
        $page = 1;
        if ($request->has("page"))
            $page = $request->page;
        $opt = ["limit"=>10, "page"=>$page];
        $query = '';
        if ($request->has('agency_name') and $request->agency_name != '') {
            $opt['agency_name'] = $request->agency_name;
            $query = "&agency_name=".$opt['agency_name'];
        }
        $data = $this->api->get_agency($opt)->post();
        $items = [];
        if (isset($data['status']) and $data['status'] == 'success') {
            $count = $data['data']['count'];
            $items = $data['data']['rows'];
            $pages = ceil($count/10);
            $cur_page = $page;
            if (count($items) > 0 )
                $pagination = PaginationLinks::paginationCreate($cur_page,$pages,2,
                    '<li class="page-item"><a class="page-link" href="?page=%d'.$query.'">%d</a></li>',
                );

        }
        return view('agency.index', compact('items' ,'request', 'pagination'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')){
            $request->validate([
                'agency_name' => ['required', 'string'],
                'agency_address' => ['required', 'string'],
                'voen' => ['required', 'string'],
            ],
                [
                    'voen.required' => __('adnetwork.voen_is_required'),
                    'agency_address.required' => __('adnetwork.agency_address_is_required'),
                    'agency_name.required' => __('adnetwork.agency_name_is_required'),
                ]
            );
            $opt = ['agency_name' => $request->agency_name, 'agency_address' => $request->agency_address, 'voen' => $request->voen, 'user_id' => auth_id()];
            $data = $this->api->agency_create($opt)->post();
            if (isset($data['status']) and $data['status'] == 'success')
                return redirect()->route('agency.index', app()->getLocale())->with('success', __('adnetwork.successfully_created'));
            else{
                $messages = [];
                if (isset($data['messages']))
                    $messages = $data['messages'];
                return redirect()->back()->withInput()->with(['error' => __('adnetwork.something_went_wrong'), 'messages' => $messages]);
            }
        }


        $page['title'] = __('adnetwork.add_agency');
        $page['form']['action'] = route('agency.create', app()->getLocale());
        $page['form']['method'] = 'post';
        $page['breadcrumbs'][] = ['route' => route('home'), 'title' => 'Smartbee', 'breadcrumbs' => true];
        $page['breadcrumbs'][] = ['route' => route('agency.index', app()->getLocale()), 'title' => __('adnetwork.agencies'), 'breadcrumbs' => true];
        $page['breadcrumbs'][] = ['title' => __('adnetwork.add_agency'), 'breadcrumbs' => false];

        $form = [];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id'=>'agency_name','name'=>'agency_name', 'title' => __('adnetwork.agency_name'), 'value'=>old('agency_name')];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id'=>'agency_address','name'=>'agency_address', 'title' => __('adnetwork.agency_address'), 'value'=>old('agency_address')];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id'=>'voen','name'=>'voen', 'title' => __('adnetwork.voen'), 'value'=>old('voen')];

        return view('form', compact('form', 'page'));
    }

    public function edit(Request $request, $lang,$id)
    {
        $item = $this->api->get_agency(['agency_id' => $id])->post();
        if (isset($item['status']) and $item['status'] == 'success' and count($item['data']['rows'])>0)
            $item = $item['data']['rows'][0];
        else
            return redirect()->route('agency.index', app()->getLocale())->with('error', __('adnetwork.not_found'));
        if ($request->isMethod('post')) {
            $request->validate([
                'agency_name' => ['required', 'string'],
                'agency_address' => ['required', 'string'],
                'voen' => ['required', 'string'],
            ],
                [
                    'voen.required' => __('adnetwork.voen_is_required'),
                    'agency_address.required' => __('adnetwork.agency_address_is_required'),
                    'agency_name.required' => __('adnetwork.agency_name_is_required'),
                ]
            );
            $opt = ['agency_name' => $request->agency_name, 'agency_address' => $request->agency_address, 'voen' => $request->voen, 'user_id' => auth_id(), 'agency_id' => $id];
            $data = $this->api->agency_update($opt)->post();
            if (isset($data['status']) and $data['status'] == 'success')
                return redirect()->route('agency.index', app()->getLocale())->with('success', __('adnetwork.successfully_created'));
            else{
                $messages = [];
                if (isset($result['messages']))
                    $messages = $result['messages'];
                return redirect()->back()->withInput()->with(['error' => __('adnetwork.something_went_wrong'), 'messages' => $messages]);
            }
        }

        $page['title'] = $item['agency_name'];
        $page['form']['action'] = route('agency.edit', ['lang' => app()->getLocale(), 'id' => $item['agency_id']]);
        $page['form']['method'] = 'post';
        $page['breadcrumbs'][] = ['route' => route('home'), 'title' => 'Smartbee', 'breadcrumbs' => true];
        $page['breadcrumbs'][] = ['route' => route('agency.index', app()->getLocale()), 'title' => __('adnetwork.agencies'), 'breadcrumbs' => true];
        $page['breadcrumbs'][] = ['title' => $item['agency_name'], 'breadcrumbs' => false];
        $form = [];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id'=>'agency_name','name'=>'agency_name', 'title' => __('adnetwork.agency_name'), 'value'=>$item['agency_name']];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id'=>'agency_address','name'=>'agency_address', 'title' => __('adnetwork.agency_address'), 'value'=>$item['agency_address']];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id'=>'voen','name'=>'voen', 'title' => __('adnetwork.voen'), 'value'=>$item['voen']];
        return view('form', compact('form', 'page'));
    }
}
