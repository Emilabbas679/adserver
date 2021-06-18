<?php

namespace App\Http\Controllers\FB;

use App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Helpers\PaginationLinks;
use Illuminate\Http\Request;

class UserController extends Controller
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
        $opt = ['limit' => 1000];
        $query = '';
        if ($request->has('searchQuery') and $request->searchQuery != ''){
            $opt['searchQuery'] = $request->searchQuery;
            $query = "&searchQuery=".$opt['searchQuery'];
        }
        $status = '';
        if ($request->has('status') and $request->status != ''){
            $opt['status'] = $request->status;
            $status = "&status=".$opt['status'];
        }
        $page_api = [];
        $page_get = '';
        if ($request->has('page_id') and $request->page_id != '' and $request->page_id != '0'){
            $opt['page_id'] = $request->page_id;
            $page_get = "&page_id=".$opt['page_id'];
            $page_api = $this->api->get_fb_pages(['page_id'=>$opt['page_id']])->post();
            if (!isset($page_api['status']) or (isset($page_api['status']) and $page_api['status'] == 'failed'))
                return redirect()->route('fb_page.index', app()->getLocale())->with('error', __('adnetwork.user_not_found'));
            $page_api = $page_api['data']['rows'][0];
        }
        $data = $this->api->get_fb_users(['limit' => 1000])->post();
        $items = [];
        $cur_page = $page;
        $pagination = '';
        if (isset($data['status']) and $data['status'] == 'success') {
            $items = $data['data']['rows'];
            $count = $data['data']['count'];
            $pages = ceil($count/10);
            if (count($items) > 0 )
                $pagination = PaginationLinks::paginationCreate($cur_page,$pages,2,
                    '<li class="page-item"><a class="page-link" href="?page=%d'.$query.$status.$page_get.'">%d</a></li>',
                );
        }
        return view('fb.users.index', compact('items', 'request', 'page', 'pagination', 'page_api'));
    }


    public function create(Request $request, $lang)
    {
        if ($request->isMethod('post')){
            $opt['name'] = $request->name;
            $opt['app_id'] = $request->app_id;
            $opt['app_secret'] = $request->app_secret;
            $opt['token'] = $request->token;
            $opt['status'] = $request->status;
            if ($request->has('fb_pages')) {
                $arr = [];
                foreach ($request->fb_pages as $key => $val)
                    $arr[$val] = $val;
                $opt['fb_pages'] = json_encode($arr);
            }
            $data = $this->api->create_fb_users($opt)->post();
            dd($data);

        }

        $page['title'] = __('adnetwork.add_user');
        $page['form']['action'] = route('fb_user.create', ['lang' => app()->getLocale()]);
        $page['form']['method'] = 'post';
        $page['breadcrumbs'][] = ['route' => route('home'), 'title' => 'Smartbee', 'breadcrumbs' => true];
        $page['breadcrumbs'][] = ['route' => route('fb_user.index', app()->getLocale()), 'title' => __('adnetwork.fb_users'), 'breadcrumbs' => true];
        $page['breadcrumbs'][] = ['title' => $page['title'], 'breadcrumbs' => false];

        $form = [];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'name', 'name' => 'name', 'title' => __('adnetwork.name'), 'value' => old('name'), 'placeholder' => __('adnetwork.name')];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'app_id', 'name' => 'app_id', 'title' => __('adnetwork.app_id'), 'value' => old('app_id'), 'placeholder' => __('adnetwork.app_id')];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'app_secret', 'name' => 'app_secret', 'title' => __('adnetwork.app_secret'), 'value' => old('app_secret'), 'placeholder' => __('adnetwork.app_secret')];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'token', 'name' => 'token', 'title' => __('adnetwork.token'), 'value' => old('token'), 'placeholder' => __('adnetwork.token')];
        $form[] = ['type' => 'select', 'required' => 1, 'id' => 'status', 'name' => 'status', 'title' => __('adnetwork.status'), 'value' => old('status'), 'placeholder' => __('adnetwork.status'),
            'options' => [
                ['selected' => 1, 'id' => 'active', 'text' => __('adnetwork.active')],
                ['selected' => 0, 'id' => 'inactive', 'text' => __('adnetwork.inactive')]]];
        $form[] = ['type' => 'select2','multiple'=>1, 'required' => 1, 'id' => 'fb_pages', 'name' => 'fb_pages[]', 'title' => __('adnetwork.fb_pages'), 'value' => old('fb_pages'), 'placeholder' => __('adnetwork.fb_pages'),
            'options' => []];
        return view('form', compact('form', 'page'));


    }
}
