<head>
    <base href="">
    <title>Rainstreamweb - [ Admin ]</title>
    <meta charset="utf-8" />
    <meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 94,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue &amp; Laravel versions. Grab your copy now and get life-time updates for free." />
    <meta name="keywords" content="Metronic, bootstrap, bootstrap 5, Angular, VueJs, React, Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    @if(app()->getLocale() == 'ar')
        @if(session('theme', 'light') === 'dark')
            <link href="{{ asset('css/style.dark.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
        @else
            <link href="{{ asset('css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
        @endif
    @else
        @if(session('theme', 'light') === 'dark')
            <link href="{{ asset('css/style.dark.bundle.css') }}" rel="stylesheet" type="text/css" />
        @else
            <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        @endif
    @endif
    <style>
    .symbol.symbol-30px {
        width: 30px;
        height: 30px;
        border-radius: 20%;
    }
    .symbol.symbol-50px {
        width: 50px;
        height: 50px;
        border-radius: 20%;
    }

    @media (min-width: 768px) {
        .symbol.symbol-md-40px {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }
    }
    </style>
</head>
