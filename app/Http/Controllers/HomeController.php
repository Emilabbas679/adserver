<?php

namespace App\Http\Controllers;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($lang = 'az')
    {


        $chart = (new LarapexChart)->lineChart()
//            ->setTitle('Adverts')
            ->addLine('Impression', [1660,3214,2423,1545,1922,2312])
            ->addLine('Click', [541,211,141,351,91,323])
            ->addLine('Spent', [7,2,4,6,18,5])
            ->setXAxis(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'])
            ->setColors(['#ffc63b', '#ff6384', '#c9cbcf']);



        $chart_pie = (new LarapexChart)->pieChart()
//            ->setSubtitle('Subtitle of pie')
            ->addData([20, 24, 30])
            ->setLabels(['First', 'Second', 'Third']);

        return view('home', compact('chart', 'chart_pie'));
    }

    public function userLoginType(Request $request, $lang,$type)
    {
        if ($type == 'advertiser')
            Session::put('user_login_type', 'advertiser');
        elseif($type == 'publisher')
            Session::put('user_login_type', 'publisher');
//        return redirect()->back();
        return redirect()->route('home', app()->getLocale());
    }
}
