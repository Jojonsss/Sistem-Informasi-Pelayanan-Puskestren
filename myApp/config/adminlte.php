<?php

use ColorlibHQ\AdminLte\Menu\Filters\ActiveFilter;
use ColorlibHQ\AdminLte\Menu\Filters\GateFilter;
use ColorlibHQ\AdminLte\Menu\Filters\HrefFilter;
use ColorlibHQ\AdminLte\Menu\Filters\SearchFilter;

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    */

    'title' => 'Puskestren',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    */

    'logo' => '<b>PUSKESTREN</b>',
    'logo_img' => 'vendor/adminlte/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image opacity-75 shadow',
    'logo_img_alt' => 'Puskestren',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    */

    'auth_logo' => [
        'enabled' => false,

        'img' => [
            'path' => 'vendor/adminlte/img/AdminLTELogo.png',
            'alt' => 'Puskestren',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'text-bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,
    'layout_rtl' => false,

    /*
    |--------------------------------------------------------------------------
    | Footer
    |--------------------------------------------------------------------------
    */

    'footer_left' =>
        'Copyright &copy; ' . date('Y') . ' Puskestren. All rights reserved.',

    'footer_right' =>
        'Sistem Informasi Pelayanan Puskestren',

    /*
    |--------------------------------------------------------------------------
    | Sidebar / Control Sidebar
    |--------------------------------------------------------------------------
    */

    'preloader' => false,

    'control_sidebar' => false,

    'control_sidebar_theme' => 'dark',

    /*
    |--------------------------------------------------------------------------
    | Documentation
    |--------------------------------------------------------------------------
    */

    'sidebar_docs_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Demo / Documentation
    |--------------------------------------------------------------------------
    */

    'demo' => false,

    'demo_middleware' => [
        'web',
        'auth',
    ],

    'docs' => false,

    'docs_middleware' => [
        'web',
    ],

    /*
    |--------------------------------------------------------------------------
    | Activity Log
    |--------------------------------------------------------------------------
    */

    'activity_log' => [
        'redact' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    */

    'sidebar_breakpoint' => 'lg',

    'sidebar_mini' => true,

    'sidebar_collapse' => false,

    'sidebar_collapse_auto_size' => false,

    'sidebar_scrollbar_theme' => 'os-theme-light',

    'sidebar_scrollbar_auto_hide' => 'leave',

    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    */

    'sidebar_theme' => 'dark',

    'primary_color' => '#0d6efd',

    'sidebar_color' => null,

    'navbar_color' => null,

    'footer_color' => null,

    /*
    |--------------------------------------------------------------------------
    | Custom Classes
    |--------------------------------------------------------------------------
    */

    'classes_body' => '',

    'classes_brand' => '',

    'classes_brand_text' => 'fw-light',

    'classes_content_wrapper' => '',

    'classes_content_header' => '',

    'classes_content' => '',

    'classes_sidebar' => 'bg-dark shadow',

    'classes_sidebar_nav' => '',

    'classes_topnav' => 'navbar-expand bg-body',

    'classes_topnav_nav' => 'navbar',

    'classes_topnav_container' => 'container-fluid',

    /*
    |--------------------------------------------------------------------------
    | Color Mode
    |--------------------------------------------------------------------------
    */

    'color_mode_toggle' => true,

    /*
    |--------------------------------------------------------------------------
    | MENU PUSKESTREN
    |--------------------------------------------------------------------------
    */

    'menu' => [

        /*
        |--------------------------------------------------------------------------
        | MENU UTAMA
        |--------------------------------------------------------------------------
        */

        [
            'header' => 'MENU UTAMA',
        ],

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        [
            'text' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon' => 'bi bi-speedometer2',
            'can' => 'access-admin',
        ],

        [
            'header' => 'ADMINISTRASI',
            'can' => 'access-admin',
        ],

        [
            'text' => 'Management Pengguna',
            'route' => 'admin.users.index',
            'icon' => 'bi bi-people-fill',
            'can' => 'access-admin',
        ],

        [
            'text' => 'Data Pasien',
            'url' => '#',
            'icon' => 'bi bi-person-vcard-fill',
            'can' => 'access-admin',
        ],

        [
            'text' => 'Data Dokter',
            'url' => '#',
            'icon' => 'bi bi-person-badge-fill',
            'can' => 'access-admin',
        ],

        [
            'text' => 'Data Poli',
            'url' => '#',
            'icon' => 'bi bi-hospital-fill',
            'can' => 'access-admin',
        ],

        [
            'text' => 'Kunjungan',
            'url' => '#',
            'icon' => 'bi bi-clipboard2-pulse-fill',
            'can' => 'access-admin',
        ],

        [
            'text' => 'Antrean',
            'url' => '#',
            'icon' => 'bi bi-list-ol',
            'can' => 'access-admin',
        ],

        [
            'text' => 'Laporan',
            'url' => '#',
            'icon' => 'bi bi-file-earmark-bar-graph-fill',
            'can' => 'access-admin',
        ],

        /*
        |--------------------------------------------------------------------------
        | DOKTER
        |--------------------------------------------------------------------------
        */

        [
            'header' => 'PELAYANAN DOKTER',
            'can' => 'access-dokter',
        ],

        [
            'text' => 'Dashboard',
            'route' => 'dokter.dashboard',
            'icon' => 'bi bi-speedometer2',
            'can' => 'access-dokter',
        ],

        [
            'text' => 'Data Pasien',
            'url' => '#',
            'icon' => 'bi bi-people-fill',
            'can' => 'access-dokter',
        ],

        [
            'text' => 'Pemeriksaan',
            'url' => '#',
            'icon' => 'bi bi-clipboard2-check-fill',
            'can' => 'access-dokter',
        ],

        [
            'text' => 'Diagnosis',
            'url' => '#',
            'icon' => 'bi bi-file-medical-fill',
            'can' => 'access-dokter',
        ],

        [
            'text' => 'Riwayat Pasien',
            'url' => '#',
            'icon' => 'bi bi-clock-history',
            'can' => 'access-dokter',
        ],

        /*
        |--------------------------------------------------------------------------
        | PASIEN
        |--------------------------------------------------------------------------
        */

        [
            'header' => 'LAYANAN PASIEN',
            'can' => 'access-pasien',
        ],

        [
            'text' => 'Dashboard',
            'route' => 'pasien.dashboard',
            'icon' => 'bi bi-house-door-fill',
            'can' => 'access-pasien',
        ],

        [
            'text' => 'Profil',
            'url' => '#',
            'icon' => 'bi bi-person-circle',
            'can' => 'access-pasien',
        ],

        [
            'text' => 'Pendaftaran Pelayanan',
            'url' => '#',
            'icon' => 'bi bi-calendar-plus-fill',
            'can' => 'access-pasien',
        ],

        [
            'text' => 'Antrean',
            'url' => '#',
            'icon' => 'bi bi-list-ol',
            'can' => 'access-pasien',
        ],

        [
            'text' => 'Riwayat Pelayanan',
            'url' => '#',
            'icon' => 'bi bi-clock-history',
            'can' => 'access-pasien',
        ],

        [
            'text' => 'Profil Dokter',
            'url' => '#',
            'icon' => 'bi bi-person-badge-fill',
            'can' => 'access-pasien',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    */

    'filters' => [
        GateFilter::class,
        HrefFilter::class,
        ActiveFilter::class,
        SearchFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins
    |--------------------------------------------------------------------------
    */

    'plugins' => [

        'flatpickr' => [
            'enabled' => false,
            'css' => 'vendor/flatpickr/flatpickr.min.css',
            'js' => 'vendor/flatpickr/flatpickr.min.js',
        ],

        'tom_select' => [
            'enabled' => false,
            'css' => 'vendor/tom-select/tom-select.bootstrap5.min.css',
            'js' => 'vendor/tom-select/tom-select.complete.min.js',
        ],

        'tabulator' => [
            'enabled' => false,
            'css' => 'vendor/tabulator-tables/tabulator.min.css',
            'js' => 'vendor/tabulator-tables/tabulator.min.js',
        ],

        'quill' => [
            'enabled' => false,
            'css' => 'vendor/quill/quill.snow.css',
            'js' => 'vendor/quill/quill.min.js',
        ],

        'chartjs' => [
            'enabled' => false,

            'js' => [
                'vendor/chartjs/chart.umd.min.js',
                'vendor/adminlte/js/charts.js',
            ],
        ],

        'jsvectormap' => [
            'enabled' => false,

            'css' => 'vendor/jsvectormap/jsvectormap.min.css',

            'js' => [
                'vendor/jsvectormap/jsvectormap.min.js',
                'vendor/jsvectormap/maps/world.js',
            ],
        ],

        'fullcalendar' => [
            'enabled' => false,
            'css' => 'vendor/fullcalendar/index.global.min.css',
            'js' => 'vendor/fullcalendar/index.global.min.js',
        ],

        'sortablejs' => [
            'enabled' => false,
            'js' => 'vendor/sortablejs/sortablejs.min.js',
        ],
    ],
];