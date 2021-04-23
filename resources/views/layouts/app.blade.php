<?php

 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
    <link media="screen" href="/css/style.css?v={{time()}}" type="text/css" rel="stylesheet" />
    <link media="screen" href="/css/datatables.min.css" type="text/css" rel="stylesheet" />
    <link media="screen" href="/css/responsive.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="/js/jquery.js"></script>
    @yield('css')
</head>
<body>
<div class="x-admin">

    @include('partials.header')
    @include('partials.sidebar')
    <!-- Main content start -->
    <div class="main-content">
        @yield('content')
    </div>
    <!-- Main content end -->
</div>

<script type="text/javascript" src="/js/jquery.scrollbar.min.js"></script>
<script type="text/javascript" src="/js/datatables.min.js"></script>
<script type="text/javascript" src="/js/select2.full.min.js"></script>
<script type="text/javascript" src="/js/xate.js?v={{time()}}"></script>
@yield('js')
</body>
</html>
