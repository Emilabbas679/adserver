<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    @yield('header')
    <link media="screen" rel="stylesheet" href="/smart/css/style-l.css">
    <link media="screen" href="/smart/css/intl-tel.css?v3" type="text/css" rel="stylesheet" />
    <link media="screen" href="/css/style.css?v={{time()}}" type="text/css" rel="stylesheet" />

</head>
<body>
@yield('content')
<script src="/smart/js/intlmin.js"></script>
<script src="/smart/js/utils.js"></script>
<script type="text/javascript" src="/js/xate.js?v={{time()}}"></script>

@yield('js')
</body>
</html>
