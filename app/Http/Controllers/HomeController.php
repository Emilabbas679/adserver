<?php

namespace App\Http\Controllers;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Http\Request;

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
            ->addData([20, 24, 30, 23,45, 7,3, 9])
            ->setLabels(['First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth']);

        return view('home', compact('chart', 'chart_pie'));
    }
}
