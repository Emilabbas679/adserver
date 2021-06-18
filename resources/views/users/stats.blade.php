@extends('layouts.app')
@section('title', __('adnetwork.user_stats'))
@section('css')

    <style>
        .clearfix::after {
            display: block;
            content: "";
            clear:both;
        }
        .card_tabs_section {
            display: block;
            width: 100%;
            margin: 0 auto;
        }
        .card_tabs_section .card_tabs_items {
            display: block;
            width: 100%;
            -webkit-box-shadow: 0 0 1px 0 #080808;
            box-shadow: 0 0 1px 0 #080808;
            margin: 0 auto 10px auto;

            border-radius: 3px;
            overflow: hidden;
        }

        .card_tabs_section .card_items_head {
            display: block;
            width: 100%;
            padding: 10px 10px;
            transition: all 0.3s;
        }
        .card_tabs_section .card_items_head:hover {
            background-color: #345bf8;
            cursor: pointer;
        }
        .card_tabs_section .card_items_head:hover .card_items_nm {
            color: #fff;
        }
        .card_tabs_section .card_items_head_bg {
            background-color: #345bf8;
            transition: all 0.3s;
        }

        .card_tabs_section .card_items_content {
            display: none;
            width: 100%;
        }

        .card_tabs_section .card_items_head .card_items_nm {
            display: block;
            width: calc(100% - 0px);
            float: left;
            font-size: 18px;
            font-weight: normal;
            color: #000;
        }
        .card_tabs_section .card_items_head.card_items_head_bg .card_items_nm  {
            width: calc(100% - 70px);
            color: #fff;
        }


        .card_tabs_section .card_items_head .card_items_icons {
            display: block;
            float: right;
        }

        .card_tabs_section .card_items_head.card_items_head_bg .card_items_icons button {
            display: block;
            visibility: visible;
            transition: all 0.3s;
        }


        .card_tabs_section .card_items_head .card_items_icons button {
            display: none;
            visibility: hidden;
            float: left;
            width: 20px;
            height: 20px;
            border: 0;
            outline: 0;
            margin: 0 0 0 15px;
            background-color: transparent;
            background-position: center;
            background-size: 20px 20px;
            background-repeat: no-repeat;
            cursor: pointer;
            position: relative;
            z-index: 999;
            transition: all 0.3s;
        }
        .card_tabs_section .card_items_head .card_items_icons button.faq_info_dwn {
            background-image: url(https://azerforum.com/site/images/add_down.svg);
        }
        .card_tabs_section .card_items_head .card_items_icons button.faq_info_print {
            background-image: url(https://azerforum.com/site/images/add_printer.svg);
        }


        .card_items_content table.faq_table_full {
            border-collapse: collapse;
            width: 100%;
        }

        .card_items_content table.faq_table_full th, .card_items_content table.faq_table_full  td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }

        .card_items_content table.faq_table_full tfoot tr {
            border-top: 1px solid #000;
        }

        .card_tabs_items_header {
            display: none;
            width: 100%;
            margin: 0 auto 30px auto;
        }
        .card_print_logo_sect {
            display: block;
            width: 100%;
        }

        .card_print_logo_sect .card_print_logo img {
            display: block;
            width: 200px;
        }
        .card_print_logo_sect .card_print_logo {
            display: block;
            float: left;
        }

        .card_print_logo_sect .card_print_gen_date {
            display: block;
            float: right;
            font-size: 16px;
            color: #000;
            margin: 6px 0 0 10px;
        }

        .card_tabs_items_header .card_print_logo_hText {
            display: block;
            width: 100%;
            font-size: 17px;
            color: #000;
            font-weight: bold;
            text-align: center;
            padding: 10px;
            margin: 20px auto 5px auto;
        }


        @media print {


            .card_tabs_items_header {
                display: block;
            }

            .card_print_logo_sect .card_print_gen_date {
                display: block;
            }

            header.header {
                display: none !important;
            }
            .side-m {
                display: none !important;
            }
            .modal, .mobile-right  {
                display: none !important;
            }
            .card_items_head  {
                display: none !important;
            }



            /* *{display: none;}*/
            ins {display: none !important;}

            .card_items_content .show-print-section {
                display: block !important;
            }

        }


    </style>
@endsection
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('home', app()->getLocale())}}">Smartbee</a></li>
                <li><a href="{{route('users.index', app()->getLocale())}}">{{__('adnetwork.users')}}</a></li>
                <li><span>{{__('adnetwork.user_stats')}}</span></li>
            </ul>
        </div>

        @include('partials.cards')
        @include('flash-message')

        <div class="a-block">
            <div class="a-block-head">{{__('adnetwork.user_stats')}}
                {{--                <a href="{{route('agency.create', app()->getLocale())}}" class="a-button b-gr f-right with-icon add b-small">{{__('adnetwork.add_agency')}}</a>--}}
            </div>
            <div class="a-block-body">
                <div class="card_tabs_section clearfix">
                    <div class="card_tabs_items_header clearfix">
                        <div class="card_print_logo_sect clearfix">
                            <div class="card_print_logo"><img src="/storage/settings/skdgD95foq6CCd0UNIPgT0vRWDB5DXXidkLh4VqX.png"> </div>
                            <div class="card_print_gen_date">PDF Generate Date : 19.4.2021 </div>
                        </div>
                        <div class="card_print_logo_hText clearfix">
                            INVOICE
                        </div>
                    </div>


                    @foreach($items as $key=>$item)
                        <div class="card_tabs_items clearfix" id="{{date('m-Y', strtotime('01-'.$key))}}">
                            <div class="card_items_head clearfix">
                                <div class="card_items_nm">{{date('m-Y', strtotime('01-'.$key))}}</div>
                                <div class="card_items_icons">
                                    <button class="faq_info_dwn dwn_pdf" data-id="{{date('m-Y', strtotime('01-'.$key))}}"></button>
                                    <button class="faq_info_print" onclick="printSelectArea()"></button>
                                </div>
                            </div>
                            <div class="card_items_content clearfix">
                                <table class="faq_table_full">
                                    <thead>
                                    <tr>
                                        <th>{{__('adnetwork.date')}}</th>
                                        <th>{{__('adnetwork.description')}} </th>
                                        <th>{{__('adnetwork.amount')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($item as $i)
                                        <tr>
                                            <td>01-{{date('t.m.Y', strtotime($i['date']))}}</td>
                                            <td>{{$i['description']}}</td>
                                            <td>{{number_format($i['amount'],2)}} AZN</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.0.0/jspdf.umd.min.js" integrity="sha512-g77bZKU4ktH2I5nNioWzOMcbd3fN/svB0vQM73Uo5GRn/EGfcSJB0DlR1ithxnFsDaa0HmlOwHYiUFeM1P3RRw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
    <script>
        $(document).ready(function(){
            $(".card_items_head .card_items_nm").click(function(){
                $(this).parents(".card_items_head").siblings(".card_items_content").slideDown("fast");

                $(this).parents(".card_tabs_items").siblings().children('.card_items_content').slideUp("fast");

                $(this).parents(".card_items_head").addClass("card_items_head_bg");
                $(this).parents(".card_tabs_items").siblings().children('.card_items_head').removeClass("card_items_head_bg");

                $(this).parents(".card_items_head").siblings(".card_items_content").addClass("show-print-section");
                $(this).parents(".card_tabs_items").siblings().children('.card_items_content').removeClass("show-print-section");

                //$(this).parents(".card_tabs_items").siblings().children('.card_items_content').removeClass("show-print-section");

            });
            //$(".faq_info_print").click(function(){

            //$(this).parents(".card_items_head").siblings(".card_items_content").addClass("show-print-section");
            //});
        });
        function printSelectArea() {
            window.print();
        }

        var doc = new jsPDF();
        var specialElementHandlers = {
            '#editor': function (element, renderer) {
                return true;
            }
        };
        $('.dwn_pdf').click(function () {
            let id = $(this).attr('data-id');


            doc.fromHTML($('#'+id).html(), 15, 15, {
                'width': 170,
                'elementHandlers': specialElementHandlers
            });

            doc.save(id+'.pdf');
        });


    </script>


@endsection
