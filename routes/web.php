<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TranslateController as Translate;
use App\Http\Controllers\HomeController as Home;
use App\Http\Controllers\UserController as User;
use App\Http\Controllers\UsersController as Users;
use App\Http\Controllers\ProfileController as Profile;
use App\Http\Controllers\CampaignController as Campaign;
use App\Http\Controllers\WebSiteController as Site;
use App\Http\Controllers\ZoneController as Zone;
use App\Http\Controllers\AdsetController as Adset;
use App\Http\Controllers\AdvertController as Advert;
use App\Http\Controllers\ApiController as Api;
use App\Http\Controllers\WalletController as Wallet;
use App\Http\Controllers\BankController as Bank;
use App\Http\Controllers\AgencyController as Agency;
use App\Http\Controllers\DebitorController as Debitor;
use App\Http\Controllers\FB\UserController as FbUser;
use App\Http\Controllers\FB\PageController as FbPage;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Auth::routes();

//

Route::get('/', function (){
   $lang = app()->getLocale();
   return redirect("/".$lang);
})->name('home');




Route::middleware('auth')->group(function (){
    Route::prefix('/api/select')->group(function (){
        Route::get('/users', [Api::class, 'selectUsers'])->name('select.users');
        Route::get('/fb/users', [Api::class, 'selectFbUsers'])->name('select.fb_users');
        Route::get('/fb/pages', [Api::class, 'selectFbPages'])->name('select.fb_pages');
        Route::get('/campaigns', [Api::class, 'selectCampaigns'])->name('select.campaigns');
        Route::get('/sites', [Api::class, 'selectSites'])->name('select.sites');
        Route::get('/agencies', [Api::class, 'selectAgencies'])->name('select.agencies');
        Route::get('/finance/cost', [Api::class, 'selectFinanceCost'])->name('select.finance_cost');

    });
});


Route::prefix('/{lang}')->middleware('language')->group(function() {
    Route::middleware('auth')->group(function (){
        Route::get('/', function ($lang){
           if (user_login_type('advertiser'))
               return redirect("/$lang/advertiser");
           else
               return redirect("/$lang/publisher");
        })->name('dashboard');

        Route::get('/publisher', [Home::class, 'index']);
        Route::get('/advertiser', [Home::class, 'index']);

        Route::get('/change/{type}', [Home::class, 'userLoginType'])->name('user_login_type');
        Route::get('/translate', [Translate::class, 'index'])->name('admin.translations');
        Route::get('/translate/update/cron', [Translate::class, 'updateCron'])->name('translation_update_cron');
        Route::post('/translate', [Translate::class, 'update']);
        Route::post('/translate/create', [Translate::class, 'create_files'])->name('translate_create');
        Route::get('/campaign', [Campaign::class, 'index'])->name('campaign.index');
        Route::get('/site', [Site::class, 'index'])->name('site.index');
        Route::match(['get','post'],'/site/edit/{id}', [Site::class, 'edit'])->name('site.edit');
        Route::post('/site/status', [Site::class, 'status'])->name('site.status');
        Route::get('/zone', [Zone::class, 'index'])->name('zone.index');
        Route::match(['get','post'],'/zone/edit/{id}', [Zone::class, 'edit'])->name('zone.edit');
        Route::match(['get','post'],'/zone/create', [Zone::class, 'create'])->name('zone.create');
        Route::get('/zone/status/{id}/{status_id}', [Zone::class, 'status'])->name('zone.status');


        Route::middleware('bank.permission')->group(function () {
            Route::get('/users', [Users::class, 'index'])->name('users.index');
            Route::get('/users/view-mode/{id}', [Users::class, 'viewUser'])->name('users.view_mode');
            Route::get('/users/azerforum/revenue/daily/{id}', [Users::class, 'azerforumRevenueDaily'])->name('users.azerforum_revenue_daily');
            Route::get('/users/stats/{id}', [Users::class, 'stats'])->name('users.stats');
            Route::match(['get','post'], '/users/edit-payment/{id}', [Users::class, 'editPayment'])->name('users.edit_payment');
        });

        Route::middleware('bank.permission')->group(function () {
            Route::get('/bank/accounting', [Bank::class, 'accountingIndex'])->name('bank.accounting.index');
            Route::match(['get','post'],'/bank/accounting/debit/transaction/edit/{id}', [Bank::class, 'accountingTransactionDebitEdit'])->name('bank.accounting.transaction.debit.edit');
            Route::post('/bank/debitors/get/finance', [Bank::class, 'getDebitorFinance'])->name('bank.get_debitor_finance');

            Route::match(['get','post'],'/bank/accounting/credit/transaction/edit/{id}', [Bank::class, 'accountingTransactionCreditEdit'])->name('bank.accounting.transaction.credit.edit');
            Route::get('/bank/impression/stats/monthly', [Bank::class, 'impressionStatsMonthly'])->name('bank.impression.stats.monthly');
            Route::get('/bank/costs', [Bank::class, 'costIndex'])->name('bank.cost.index');
            Route::get('/bank/pub/wallet', [Bank::class, 'pubWalletIndex'])->name('bank.pub_wallet.index');
            Route::get('/bank/ref/wallet', [Bank::class, 'refWalletIndex'])->name('bank.ref_wallet.index');
            Route::get('/bank/actions', [Bank::class, 'bankActionsIndex'])->name('bank.actions.index');
            Route::get('/bank/pub/wallet/transactions/{user_id}', [Bank::class, 'pubWalletTransactions'])->name('bank.pub_wallet.transactions');
            Route::get('/bank/accounts', [Bank::class, 'accountsIndex'])->name('bank.accounts.index');
            Route::get('/bank/accounts/status/{id}/{status_id}', [Bank::class, 'accountsStatusUpdate'])->name('bank.accounts.status');
            Route::get('/bank/accounting/monthly', [Bank::class, 'accountingMonthly'])->name('bank.accounting.monthly');
            Route::get('/bank/finance/campaigns', [Bank::class, 'financeCampaignIndex'])->name('bank.finance.campaign.index');
            Route::match(['get','post'],'/bank/accounting/create/{type}', [Bank::class, 'accountingCreate'])->name('bank.accounting.create');
            Route::match(['get','post'],'/bank/accounts/create', [Bank::class, 'accountNumberCreate'])->name('bank.account_number.create');
            Route::match(['get','post'],'/bank/costs/create', [Bank::class, 'costCreate'])->name('bank.cost.create');
            Route::match(['get','post'],'/bank/accounts/edit/{id}', [Bank::class, 'accountNumberEdit'])->name('bank.account_number.edit');
            Route::match(['get','post'],'/bank/test', [Bank::class, 'test'])->name('bank.test');

            Route::match(['get', 'post'], '/debitor/finance/{campaign_id}/{agency_id}', [Debitor::class, 'financeCreate'])->name('debitor.financeCreate');
            Route::get('/debitor/campaigns', [Debitor::class, 'campaigns'])->name('debitor.campaigns');


            Route::post('/debitor/get/finance/agencies', [Debitor::class, 'getAgencyDebitors'])->name('debitor.get_agency_debitors');
        });

        Route::middleware('agency.permission')->group(function () {
            Route::get('/agency', [Agency::class, 'index'])->name('agency.index');
            Route::match(['get','post'],'/agency/edit/{id}', [Agency::class, 'edit'])->name('agency.edit');
            Route::match(['get','post'],'/agency/create', [Agency::class, 'create'])->name('agency.create');
        });

        Route::get('/campaign/statistic/{id}', [Campaign::class, 'statistics'])->name('campaign.statistics');
        Route::get('/campaign/status/{campaign_id}/{status_id}', [Campaign::class, 'statusUpdate'])->name('campaign.status');
        Route::get('/adset/status/{adset_id}/{status_id}', [Adset::class, 'statusUpdate'])->name('adset.status');
        Route::get('/advert/status/{advert_id}/{status_id}', [Advert::class, 'statusUpdate'])->name('advert.status');
        Route::match(['get','post'],'/campaign/edit/{id}', [Campaign::class, 'edit'])->name('campaign.edit');

        Route::match(['get','post'],'/campaign/create', [Campaign::class, 'create'])->name('campaign.create');
        Route::match(['get','post'],'/adset/create', [Adset::class, 'create'])->name('adset.create');
        Route::match(['get','post'],'/adset/edit/{id}', [Adset::class, 'edit'])->name('adset.edit');
        Route::match(['get','post'],'/advert/edit/{id}', [Advert::class, 'edit'])->name('advert.edit');
        Route::match(['get','post'],'/advert/create', [Advert::class, 'create'])->name('advert.create');

        Route::get('/adset', [Adset::class, 'index'])->name('adset.index');
        Route::get('/advert/statistic/{id}/{type}', [Advert::class, 'statistic'])->name('advert.statistic');
        Route::post('/advert/files/upload', [Advert::class, 'fileUpload'])->name('advert.upload');
        Route::delete('/advert/files/delete', [Advert::class, 'fileDelete'])->name('advert.delete');
        Route::get('/advert', [Advert::class, 'index'])->name('advert.index');
        Route::get('/logout', [Profile::class, 'logout'])->name('logout');
        Route::get('/exit/view-mode', [Profile::class, 'viewModeExit'])->name('view_mode_exit');
        Route::match(['get','post'],'/profile/settings', [Profile::class, 'settings'])->name('profile_settings');
        Route::match(['get','post'],'/wallet/increase', [Wallet::class, 'increase'])->name('wallet_increase');
        Route::match(['get','post'],'/wallet/history', [Wallet::class, 'history'])->name('wallet_history');

    });

    Route::get('/login', [User::class, 'login'])->name('login');
    Route::match(['get', 'post'], '/advertiser/login', [User::class, 'advertiserLogin'])->name('advertiser_login');
    Route::match(['get', 'post'], '/advertiser/register', [User::class, 'advertiserRegister'])->name('advertiser_register');
    Route::match(['get', 'post'], '/advertiser/password', [User::class, 'advertiserPassword'])->name('advertiser_password');
    Route::match(['get', 'post'], '/publisher/login', [User::class, 'publisherLogin'])->name('publisher_login');
    Route::match(['get', 'post'], '/publisher/register', [User::class, 'publisherRegister'])->name('publisher_register');
    Route::match(['get', 'post'], '/publisher/password', [User::class, 'publisherPassword'])->name('publisher_password');
    Route::get('/publisher/user/forgot/password/{hash_code}', [User::class, 'publisherPasswordVerify'])->name('publisher_password_verify');
    Route::get('/advertiser/user/forgot/password/{hash_code}', [User::class, 'advertiserPasswordVerify'])->name('advertiser_password_verify');


    Route::get('/fb/users', [FbUser::class, 'index'])->name('fb_user.index');
    Route::match(['get', 'post'], '/fb/user/create', [FbUser::class, 'create'])->name('fb_user.create');



    Route::get('/fb/pages', [FbPage::class, 'index'])->name('fb_page.index');
    Route::match(['get', 'post'],'/fb/users/create', [FbPage::class, 'create'])->name('fb_page.create');
    Route::match(['get', 'post'],'/fb/users/edit/{id}', [FbPage::class, 'edit'])->name('fb_page.edit');

    Route::match(['get','post'],'/profile/settings', [Profile::class, 'settings'])->name('profile_settings');


});


