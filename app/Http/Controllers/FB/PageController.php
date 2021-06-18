<?php

namespace App\Http\Controllers\FB;

use App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Helpers\PaginationLinks;
use Illuminate\Http\Request;

class PageController extends Controller
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
        $opt = ['limit' => 10];
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
        $user_api = [];
        $user_get = '';
        if ($request->has('user_id') and $request->user_id != '' and $request->user_id != '0'){
            $opt['user_id'] = $request->user_id;
            $user_get = "&user_id=".$opt['user_id'];
            $user_api = $this->api->get_fb_users(['id'=>$opt['user_id']])->post();
            if (!isset($user_api['status']) or (isset($user_api['status']) and $user_api['status'] == 'failed'))
                return redirect()->route('fb_page.index', app()->getLocale())->with('error', __('adnetwork.user_not_found'));
            $user_api = $user_api['data']['rows'][0];
        }
        $data = $this->api->get_fb_pages($opt)->post();
        $items = [];
        $cur_page = $page;
        $pagination = '';
        if (isset($data['status']) and $data['status'] == 'success') {
            $items = $data['data']['rows'];
            $count = $data['data']['count'];
            $pages = ceil($count/10);
            if (count($items) > 0 )
                $pagination = PaginationLinks::paginationCreate($cur_page,$pages,2,
                    '<li class="page-item"><a class="page-link" href="?page=%d'.$query.$status.$user_get.'">%d</a></li>',
                );
        }
        return view('fb.pages.index', compact('items', 'request', 'page', 'pagination', 'user_api'));
    }


}
