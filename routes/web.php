<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TranslateController as Translate;
use App\Http\Controllers\HomeController as Home;
use App\Http\Controllers\UserController as User;
use App\Http\Controllers\ProfileController as Profile;
use App\Http\Controllers\CampaignController as Campaign;
use App\Http\Controllers\AdsetController as Adset;
use App\Http\Controllers\AdvertController as Advert;
use App\Http\Controllers\ApiController as Api;
use App\Http\Controllers\WalletController as Wallet;
use App\Http\Controllers\BankController as Bank;
use App\Http\Controllers\AgencyController as Agency;
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


Route::get('/test', function (){
    dd(permission_include());
    include base_path('resources/permissions/users.php');
    dd($variable);
    return 'test';
})->name('test');



Route::middleware('auth')->group(function (){
    Route::prefix('/api/select')->group(function (){
        Route::get('/users', [Api::class, 'selectUsers'])->name('select.users');
        Route::get('/campaigns', [Api::class, 'selectCampaigns'])->name('select.campaigns');
        Route::get('/sites', [Api::class, 'selectSites'])->name('select.sites');
        Route::get('/agencies', [Api::class, 'selectAgencies'])->name('select.agencies');

    });
});


Route::prefix('/{lang}')->middleware('language')->group(function() {
    Route::middleware('auth')->group(function (){
        Route::get('/', [Home::class, 'index'])->name('dashboard');
        Route::get('/translate', [Translate::class, 'index'])->name('admin.translations');
        Route::get('/translate/update/cron', [Translate::class, 'updateCron'])->name('translation_update_cron');
        Route::post('/translate', [Translate::class, 'update']);
        Route::post('/translate/create', [Translate::class, 'create_files'])->name('translate_create');
        Route::get('/campaign', [Campaign::class, 'index'])->name('campaign.index');

        Route::middleware('bank.permission')->group(function () {
            Route::get('/bank/accounting', [Bank::class, 'accountingIndex'])->name('bank.accounting.index');
            Route::get('/bank/impression/stats/monthly', [Bank::class, 'impressionStatsMonthly'])->name('bank.impression.stats.monthly');
            Route::get('/bank/costs', [Bank::class, 'costIndex'])->name('bank.cost.index');
            Route::get('/bank/pub/wallet', [Bank::class, 'pubWalletIndex'])->name('bank.pub_wallet.index');
            Route::get('/bank/pub/wallet/transactions/{user_id}', [Bank::class, 'pubWalletTransactions'])->name('bank.pub_wallet.transactions');
            Route::get('/bank/accounts', [Bank::class, 'accountsIndex'])->name('bank.accounts.index');
            Route::get('/bank/accounts/status/{id}/{status_id}', [Bank::class, 'accountsStatusUpdate'])->name('bank.accounts.status');
            Route::get('/bank/accounting/monthly', [Bank::class, 'accountingMonthly'])->name('bank.accounting.monthly');
            Route::get('/bank/finance/campaigns', [Bank::class, 'financeCampaignIndex'])->name('bank.finance.campaign.index');
            Route::match(['get','post'],'/bank/accounting/create/{type}', [Bank::class, 'accountingCreate'])->name('bank.accounting.create');
            Route::match(['get','post'],'/bank/accounts/create', [Bank::class, 'accountNumberCreate'])->name('bank.account_number.create');
            Route::match(['get','post'],'/bank/costs/create', [Bank::class, 'costCreate'])->name('bank.cost.create');
            Route::match(['get','post'],'/bank/accounts/edit/{id}', [Bank::class, 'accountNumberEdit'])->name('bank.account_number.edit');
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
});


