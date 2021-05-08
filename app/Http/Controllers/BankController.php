<?php

namespace App\Http\Controllers;

use App\Http\Helpers\PaginationLinks;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function __construct()
    {
        $this->api = new API();
    }

    public function accountingIndex(Request $request)
    {
        $start_date = "01." . date('m.Y');
        $end_date = date('d.m.Y');

        $account_no = 'all';
        $opt = ['start_date' => $start_date, 'end_date' => $end_date];
        if ($request->has('searchQuery') and $request->searchQuery != '')
            $opt['searchQuery'] = $request->searchQuery;

        if ($request->has('amount_type') and $request->amount_type != 0)
            $opt['amount_type'] = $request->amount_type;

        if ($request->has('account_no') and $request->account_no != 'all') {
            $opt['account_no'] = $request->account_no;
            $account_no = $request->account_no;
        }

        $accounts_api = $this->api->get_bank_account_numbers(['status_id' => 11])->post();
        $accounts = [];
        if (isset($accounts_api['status']) and $accounts_api['status'] == 'success')
            $accounts = $accounts_api['data']['rows'];



        if ($request->has('start_date') and $request->start_date != '') {
            $opt['start_date'] = $request->start_date;
            $start_date = $opt['start_date'];
        }
        if ($request->has('end_date') and $request->end_date != '') {
            $opt['end_date'] = $request->end_date;
            $end_date = $opt['end_date'];
        }
        $data = $this->api->get_bank_transactions($opt)->post();
        if (isset($data['status']) and $data['status'] == 'success')
            $items = $data['data']['rows'];
        else
            abort(404);
        return view('bank.accounting.index', compact('items', 'request', 'start_date', 'end_date', 'accounts' , 'account_no'));
    }

    public function accountingMonthly(Request $request)
    {
        $account_no = 'all';
        $opt = [];
        if ($request->has('account_no') and $request->account_no != 'all') {
            $opt['account_no'] = $request->account_no;
            $account_no = $request->account_no;
        }
        $accounts_api = $this->api->get_bank_account_numbers(['status_id' => 11])->post();
        $accounts = [];
        if (isset($accounts_api['status']) and $accounts_api['status'] == 'success')
            $accounts = $accounts_api['data']['rows'];
        $data = $this->api->get_bank_transactions_month($opt)->post();
        if (isset($data['status']) and $data['status'] == 'success'){
            $items = $data['data']['rows'];
            return view('bank.accounting.monthly', compact('items', 'request', 'account_no', 'accounts'));
        }
        else
            abort(404);

    }

    public function accountingCreate(Request $request, $lang, $type)
    {
        if ($type != 'debit' and $type != 'credit')
            abort(404);
        if ($request->isMethod('POST')) {
            $request->validate([
                'account_no' => ['required', 'string'],
                'date' => ['required', 'string'],
                'amount' => ['required', 'string'],
            ],
                [
                    'amount.required' => __('notification.amount_is_required'),
                    'date.required' => __('notification.date_is_required'),
                    'account_no.required' => __('notification.account_no_is_required'),
                ]
            );
            $opt = ['account_no' => $request->account_no, 'date' => $request->date, 'description' => $request->description];
            if ($type == 'debit')
                $opt['debit'] = $request->amount;
            else
                $opt['credit'] = $request->amount;
            $result = $this->api->bank_transaction_add($opt)->post();
            if (isset($result) and $result['status'] == 'success') {
                return redirect()->back()->withInput()->with(['success' => __('adnetwork.successfully_created')]);
            } else {
                $messages = $result['messages'];
                return redirect()->back()->withInput()->with(['error' => __('adnetwork.something_went_wrong'), 'messages' => $messages]);
            }
        }
        $accounts_api = $this->api->get_bank_account_numbers(['status_id' => 11])->post();
        if (isset($accounts_api['status']) and $accounts_api['status'] == 'success'){
            $accounts = $accounts_api['data']['rows'];
            $options = [];
            foreach ($accounts as $item){
                $selected = 0;
                if ($item['id'] == 1)
                    $selected = 1;
                $options[] = [
                    'selected' => $selected,
                    'id' => $item['account_no'],
                    'text' => $item['account_no'].' '.$item['account_owner']
                ];
            }


            $page['form']['action'] = route('bank.accounting.create', ['lang' => app()->getLocale(), 'type' => $type]);
            if ($type == 'credit')
                $page['title'] == __('adnetwork.credit');
            else
                $page['title'] = __('adnetwork.debit');
            $page['form']['method'] = 'post';
            $page['breadcrumbs'][] = ['route' => route('home'), 'title' => 'Smartbee', 'breadcrumbs' => true];
            $page['breadcrumbs'][] = ['route' => route('bank.accounting.index', app()->getLocale()), 'title' => __('adnetwork.bank_account_transactions'), 'breadcrumbs' => true];
            $page['breadcrumbs'][] = ['title' => $page['title'], 'breadcrumbs' => false];

            $form = [];
            $form[] = ['type' => 'select', 'required' => 1, 'id' => 'account_no', 'acount_no', 'title' => __('adnetwork.account_no'),'placeholder' => __('adnetwork.account_no'), 'value' => '380300001634854A75', 'options' => $options];
            $form[] = ['type' => 'input:date', 'required' => 1, 'id' => 'date', 'name' => 'date', 'title' => __('adnetwork.date'), 'value' => date('Y-m-d')];
            $form[] = ['type' => 'textarea', 'id' => 'description', 'name' => 'description', 'title' => __('adnetwork.description'), 'value' => '', 'placeholder' => __('adnetwork.description')];
            $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'amount', 'name' => 'amount', 'title' => __('adnetwork.amount'), 'value' => '', 'placeholder' => '0'];
            return view('form', compact('form', 'page'));


        }
        abort(404);

    }

    public function accountsIndex(Request $request)
    {
        $opt = [];
        if ($request->has('searchQuery') and $request->searchQuery != '')
            $opt['searchQuery'] = $request->searchQuery;
        $items = [];
        $data = $this->api->get_bank_account_numbers($opt)->post();
        if (isset($data['status']) and $data['status'] == 'success')
            $items = $data['data']['rows'];
        return view('bank.accounts.index', compact('items', 'request'));
    }

    public function accountNumberCreate(Request $request)
    {
        if ($request->isMethod('post')){
            $request->validate([
                'account_owner' => ['required', 'string'],
                'bank' => ['required', 'string'],
                'customer_code' => ['required', 'string'],
                'iban' => ['required', 'string'],
                'swift' => ['required', 'string'],
                'correspondent' => ['required', 'string'],
                'account_no' => ['required', 'string'],
                'voen' => ['required', 'string'],
                'code' => ['required', 'string'],
            ],
                [
                    'account_owner.required' => __('adnetwork.error_account_owner'),
                    'bank.required' => __('adnetwork.error_bank'),
                    'customer_code.required' => __('adnetwork.error_customer_code'),
                    'iban.required' => __('adnetwork.error_iban'),
                    'swift.required' => __('adnetwork.error_swift'),
                    'correspondent.required' => __('adnetwork.error_correspondent'),
                    'account_no.required' => __('adnetwork.error_account_no'),
                    'voen.required' => __('adnetwork.error_voen'),
                    'code.required' => __('adnetwork.error_code'),
                ]
            );

            $opt = $request->all();
            unset($opt['_token']);
            $data = $this->api->bank_account_ad($opt)->post();
            if (isset($data['status']) and $data['status'] == 'success')
                return redirect()->route('bank.accounts.index', app()->getLocale())->with('success', __('adnetwork.successfully_created'));
            else
                return redirect()->back()->withInput()->with('error', __('adnetwork.something_went_wrong'));
        }

        $page['form']['action'] =route('bank.account_number.create', ['lang' => app()->getLocale()]);
        $page['title'] = __('adnetwork.create_bank_account');
        $page['form']['method'] = 'post';
        $page['breadcrumbs'][] = ['route' => route('home'), 'title' => 'Smartbee', 'breadcrumbs' => true];
        $page['breadcrumbs'][] = ['route' => route('bank.accounts.index', app()->getLocale()), 'title' => __('adnetwork.bank_accounts'), 'breadcrumbs' => true];
        $page['breadcrumbs'][] = ['title' => $page['title'], 'breadcrumbs' => false];


        $form = [];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'account_owner', 'name' => 'account_owner', 'title' => __('adnetwork.bank_account_owner'), 'value' => ''];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'bank', 'name' => 'bank', 'title' => __('adnetwork.bank'), 'value' => ''];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'account_no', 'name' => 'account_no', 'title' => __('adnetwork.account_no'), 'value' => ''];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'customer_code', 'name' => 'customer_code', 'title' => __('adnetwork.customer_code'), 'value' => ''];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'iban', 'name' => 'iban', 'title' => __('adnetwork.iban'), 'value' => ''];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'swift', 'name' => 'swift', 'title' => __('adnetwork.swift'), 'value' => ''];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'correspondent', 'name' => 'correspondent', 'title' => __('adnetwork.correspondent'), 'value' => ''];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'voen', 'name' => 'voen', 'title' => __('adnetwork.voen'), 'value' => ''];
        $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'code', 'name' => 'code', 'title' => __('adnetwork.code'), 'value' => ''];
        return view('form' , compact('form', 'page'));

    }

    public function accountsStatusUpdate(Request $request, $lang,$id,$status_id)
    {
        $a_api = $this->api->get_bank_account_numbers(['id' => $id])->post();
        if (isset($a_api['status']) and $a_api['status'] == 'success' and count($a_api['data']['rows'])>0){
            $item = $a_api['data']['rows'][0];
            $item['status_id'] = $status_id;
            $data = $this->api->bank_account_update($item)->post();
            if (isset($data['status']) and $data['status'] == 'success')
                return redirect()->route('bank.accounts.index', app()->getLocale())->with('success', __('adnetwork.successfully_updated'));
            else
                return redirect()->route('bank.accounts.index', app()->getLocale())->with('error', __('adnetwork.something_went_wrong'));
        }
        return redirect()->route('bank.accounts.index', app()->getLocale())->with('error', __('adnetwork.not_found'));
    }

    public function accountNumberEdit(Request $request, $lang, $id)
    {
        $data = $this->api->get_bank_account_numbers(['id' => $id])->post();
        if (isset($data['status']) and $data['status'] == 'success' and count($data['data']['rows'])>0)
            $item = $data['data']['rows'][0];
        else
            return redirect()->route('bank.accounts.index', app()->getLocale())->with('error', __('adnetwork.not_found'));

        if ($request->isMethod('post')){
            $request->validate([
                'account_owner' => ['required', 'string'],
                'bank' => ['required', 'string'],
                'customer_code' => ['required', 'string'],
                'iban' => ['required', 'string'],
                'swift' => ['required', 'string'],
                'correspondent' => ['required', 'string'],
                'account_no' => ['required', 'string'],
                'voen' => ['required', 'string'],
                'code' => ['required', 'string'],
            ],
                [
                    'account_owner.required' => __('adnetwork.error_account_owner'),
                    'bank.required' => __('adnetwork.error_bank'),
                    'customer_code.required' => __('adnetwork.error_customer_code'),
                    'iban.required' => __('adnetwork.error_iban'),
                    'swift.required' => __('adnetwork.error_swift'),
                    'correspondent.required' => __('adnetwork.error_correspondent'),
                    'account_no.required' => __('adnetwork.error_account_no'),
                    'voen.required' => __('adnetwork.error_voen'),
                    'code.required' => __('adnetwork.error_code'),
                ]
            );

            $opt = $request->all();
            unset($opt['_token']);
            $opt['id'] = $id;
            $data = $this->api->bank_account_update($opt)->post();
            if (isset($data['status']) and $data['status'] == 'success')
                return redirect()->route('bank.accounts.index', app()->getLocale())->with('success', __('adnetwork.successfully_updated'));
            else
                return redirect()->back()->withInput()->with('error', __('adnetwork.something_went_wrong'));
        }

        $page['form']['action'] = route('bank.account_number.edit', ['lang' => app()->getLocale(), 'id'=>$item['id']]);
        $page['title'] = $item['bank'];
        $page['form']['method'] = 'post';
        $page['breadcrumbs'][] = ['route' => route('home'), 'title' => 'Smartbee', 'breadcrumbs' => true];
        $page['breadcrumbs'][] = ['route' => route('bank.accounts.index', app()->getLocale()), 'title' => __('adnetwork.bank_accounts'), 'breadcrumbs' => true];
        $page['breadcrumbs'][] = ['title' => $page['title'], 'breadcrumbs' => false];


        $form = [];
        foreach ($item as $k=>$v) {
            if ($k!='id')
                $form[] = ['type' => 'input:text', 'required' => 1, 'id' => $k, 'name' => $k, 'title' => __("adnetwork.$k"), 'value' => $v];
        }
        return view('form', compact('form', 'page'));
    }

    public function financeCampaignIndex(Request $request)
    {
        $page = 1;
        if ($request->has("page"))
            $page = $request->page;
        $cur_page = $page;
        $opt = [];
        $query = '';
        $pagination = '';
        if ($request->has('chargeable_amount') and $request->chargeable_amount != ''){
            $opt['chargeable_amount'] = $request->chargeable_amount;
            $query = "&chargeable_amount=".$opt['chargeable_amount'];
        }
        $charged = '';
        if ($request->has('charged_amount') and $request->charged_amount != ''){
            $opt['charged_amount'] = $request->charged_amount;
            $charged = "&charged_amount=".$opt['charged_amount'];
        }
        $campaign = [];
        $campaign_id = '';
        if ($request->has('campaign_id') and $request->campaign_id != ''){
            $opt['campaign_id'] = $request->campaign_id;
            $campaign_id = "&campaign_id=".$opt['campaign_id'];
            $campaign = $this->api->get_campaign(['campaign_id' => $request->campaign_id])->post();
            if (isset($campaign['status']) and $campaign['status'] == 'success')
                $campaign = $campaign['data']['rows'][0];
        }
        $data = $this->api->get_finance_campaign($opt)->post();
        if (isset($data['status']) and $data['status'] == 'success') {
            $count = $data['data']['info']['count'];
            $items = $data['data']['rows'];
            $pages = round($count/10);
            if (count($items) > 0 )
                $pagination = PaginationLinks::paginationCreate($page,$pages,2,
                    '<li class="page-item"><a class="page-link" href="?page=%d'.$query.$campaign_id.$charged.'">%d</a></li>',
                );
        }
        else
            abort(404);

        return view('bank.finance.campaign.index', compact('pagination', 'page', 'cur_page', 'items', 'request', 'campaign'));

    }

    public function pubWalletIndex(Request $request)
    {
        $page = 1;
        if ($request->has("page"))
            $page = $request->page;
        $opt = ["limit"=>10, "page"=>$page];
        $user_api = [];
        $user_get = '';
        if ($request->has('user_id') and $request->user_id != '0'){
            $opt['user_id'] = $request->user_id;
            $user_get = "&user_id=".$opt['user_id'];
            $user_api = $this->api->get_user(['user_id'=>$opt['user_id']])->post();
            if (!isset($user_api['status']) or (isset($user_api['status']) and $user_api['status'] == 'failed'))
                return redirect()->route('campaign.index')->with('error', __('notification.user_not_found'));
            $user_api = $user_api['data'][0];
        }
        $data = $this->api->get_pub_all_wallet($opt)->post();
        $items = [];
        $cur_page = $page;
        $pagination = '';
        if (isset($data['status']) and $data['status'] == 'success') {
            $items = $data['data']['rows'];
            $count = $data['data']['info']['count'];
            $pages = round($count/10);
            if (count($items) > 0 )
                $pagination = PaginationLinks::paginationCreate($cur_page,$pages,2,
                    '<li class="page-item"><a class="page-link" href="?page=%d'.$user_get.'">%d</a></li>',
                );
        }
        return view('bank.pub.index', compact('request', 'items', 'user_api', 'pagination'));
    }

    public function pubWalletTransactions(Request $request, $lang, $id)
    {
        $items = [];
        return view('bank.pub.user_transactions', compact('items'));
    }

    public function costIndex(Request $request)
    {
        $page = 1;
        if ($request->has("page"))
            $page = $request->page;

        $items = [];
        $pagination = '';
        $start_date = "01." . date('m.Y');
        $end_date = date('d.m.Y');
        $opt = ['start_date' => $start_date, 'end_date' => $end_date, 'page' => $page];

        $start_date_txt = '';
        if ($request->has('start_date') and $request->start_date != ''){
            $opt['start_date'] = $request->start_date;
            $start_date = $request->start_date;
            $start_date_txt = "&start_date=".$opt['start_date'];
        }
        $end_date_txt = '';
        if ($request->has('start_date') and $request->end_date != ''){
            $opt['end_date'] = $request->end_date;
            $end_date_txt = "&end_date=".$opt['end_date'];
            $end_date = $request->$end_date;

        }

        $category_id = '';
        if ($request->has('category_id') and $request->category_id != 'all'){
            $opt['category_id'] = $request->category_id;
            $category_id = "&category_id=".$opt['category_id'];
        }
        $search = '';
        if ($request->has('searchQuery') and $request->searchQuery != ''){
            $opt['searchQuery'] = $request->searchQuery;
            $search = "&searchQuery=".$opt['searchQuery'];
        }
        $categories = $this->api->get_cost_category()->post()['data']['getRows'];
        $data = $this->api->get_cost($opt)->post();
        if (isset($data['status']) and $data['status'] == 'success') {
            $items = $data['data']['rows'];
            $count = $data['data']['info']['count'];
            $pages = round($count/10);
            if (count($items) > 0 )
                $pagination = PaginationLinks::paginationCreate($page,$pages,2,
                    '<li class="page-item"><a class="page-link" href="?page=%d'.$start_date_txt.$end_date_txt.$search.$category_id.'">%d</a></li>',
                );
        }


        return view('bank.cost.index', compact('items', 'request','start_date','end_date','categories', 'pagination'));
    }


    public function costCreate(Request $request)
    {
        if ($request->isMethod('post'))
        {

            $request->validate([
                'category_id' => ['required', 'string'],
                'cost_time' => ['required', 'string'],
                'amount' => ['required', 'string'],
            ],
                [
                    'amount.required' => __('notification.amount_is_required'),
                    'cost_time.required' => __('notification.cost_time_is_required'),
                    'category_id.required' => __('notification.category_id_is_required'),
                ]
            );
            $opt = ['amount' => $request->amount, 'description' => $request->description, 'user_id' => auth()->id(),'cost_time' => $request->cost_time,'category_id' => $request->category_id];
            $data = $this->api->create_cost($opt)->post();
            if (isset($data['status']) and  $data['status'] == 'success')
                return redirect()->route('bank.cost.index', app()->getLocale())->with('success', __('adnetwork.successfully_created'));
            else
                return redirect()->back()->withInput()->with('error', __('adnetwork.something_went_wrong'));

        }

        $categories_api = $this->api->get_cost_category(['status_id' => 11])->post();
        if (isset($categories_api['status']) and $categories_api['status'] == 'success'){
            $categories = $categories_api['data']['getRows'];
            $options = [];
            foreach ($categories as $item){
                $options[] = [
                    'selected' => 0,
                    'id' => $item['id'],
                    'text' => $item['name']
                ];
            }

            $page['title'] = __('adnetwork.add_cost');
            $page['form']['action'] = route('bank.cost.create', app()->getLocale());
            $page['form']['method'] = 'post';
            $page['breadcrumbs'][] = ['route' => route('home'), 'title' => 'Smartbee', 'breadcrumbs' => true];
            $page['breadcrumbs'][] = ['route' => route('bank.cost.index', app()->getLocale()), 'title' => __('adnetwork.costs'), 'breadcrumbs' => true];
            $page['breadcrumbs'][] = ['title' => __('adnetwork.add_cost'), 'breadcrumbs' => false];

            $form = [];
            $form[] = ['type' => 'select', 'required' => 1, 'id' => 'category_id', 'title' => __('adnetwork.category_id'),'placeholder' => __('adnetwork.category_id'), 'options' => $options];
            $form[] = ['type' => 'input:date', 'required' => 1, 'id' => 'cost_time', 'name' => 'cost_time', 'title' => __('adnetwork.cost_time'), 'value' => date('Y-m-d')];
            $form[] = ['type' => 'textarea', 'id' => 'description', 'name' => 'description', 'title' => __('adnetwork.description'), 'value' => '', 'placeholder' => __('adnetwork.description')];
            $form[] = ['type' => 'input:text', 'required' => 1, 'id' => 'amount', 'name' => 'amount', 'title' => __('adnetwork.amount'), 'value' => '', 'placeholder' => '0'];
            return view('form', compact('form', 'page'));

        }
        return redirect()->route('bank.cost.index', app()->getLocale());
    }

    public function impressionStatsMonthly(Request $request)
    {
        $data = $this->api->click_impression_stats(['stats_type' => 'ad_calculated_archive_month'])->post();
        if (isset($data['status']) and $data['status'] == 'success'){
            $items = $data['data']['stats'];
            return view('bank.stats.impression_monthly', compact('items'));
        }
        else
            abort(404);
    }

}