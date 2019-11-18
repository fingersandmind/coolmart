<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="msapplication-TileColor" content="#0061da">
    <meta name="theme-color" content="#1643a3">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    {{-- <link rel="icon" href="favicon.ico" type="image/x-icon"/> --}}
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/favicon/favicon-16x16.png') }}" />

    <!-- Title -->
    <title>Cool Mart</title>
    <link rel="stylesheet" href="{{ asset('assets/fonts/fonts/font-awesome.min.css') }}">

    <!-- Font Family-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">

    <!-- Dashboard Css -->

    <link href="{{ asset('assets/css/dashboard.css')}}" rel="stylesheet" />


    <!-- Morris.js Charts Plugin -->
    <link href="{{ asset('assets/plugins/morris/morris.css')}}" rel="stylesheet" />

    <!-- Custom scroll bar css-->
    <link href="{{ asset('assets/plugins/scroll-bar/jquery.mCustomScrollbar.css')}}" rel="stylesheet" />

    <!---Font icons-->
    <link href="{{ asset('assets/plugins/iconfonts/plugin.css')}}" rel="stylesheet" />
    
    @stack('additionalCSS')
</head>