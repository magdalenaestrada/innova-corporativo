<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => '',
    'title_prefix' => 'SISTEMA GRUPO INNOVA |',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<span style="font-size: 1rem;"><b> GRUPO INNOVA </b></span>',
    'logo_img' => 'vendor/adminlte/dist/img/innova.png',
    'logo_img_class' => 'brand-image  ',
    'logo_img_xl' => null,
    'logo_img_xl_class' => '',
    'logo_img_alt' => 'INNOVA LOGO',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => false,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/innova.jpeg',
            'alt' => 'Innova logo preloader imagw',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-info',
    'usermenu_image' => false,
    'usermenu_desc' => true,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => false,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'bg-gradient-dark card-outline card-warning',
    'classes_auth_header' => '',
    'classes_auth_body' => 'bg-dark',
    'classes_auth_footer' => 'd-none',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-success',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-info elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-dark navbar-dark',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-home',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'login',
    'password_reset_url' => 'login',
    'password_email_url' => 'login',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type' => 'navbar-search',
            'text' => 'search',
            'topnav_right' => false,
        ],

        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],


        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        [
            'text' => 'blog',
            'url' => 'admin/blog',
            'can' => 'manage-blog',

        ],

        [
            'text' => 'Dashboard',
            'route' => 'home',
            'icon' => 'fas fa-fw fa-home',
        ],

        [
            'text' => 'ALFA',
            'url' => 'https://www.mineraalfagolden.com/home',

        ],
        [
            'text' => 'KILATE',
            'url' => 'https://www.kilatecorp.com/home',

        ],

        [
            'text' => 'INNOVA',
            'url' => 'https://www.innova.innovaminingsys.com/home',

        ],



        ['header' => 'CHAT'],
        [
            'text' => 'CHAT',
            'icon_color' => 'white',
            'url' => '/chats',

        ],

        ['header' => 'COMBUSTIBLE'],
        [
                    'text' => 'Notas de pedido',
                    'url' => '/nota-pedido',
                    'can' => 'ver producto',
        ],



        ['header' => 'INVENTARIO', 'can' => 'ver producto'],
        [
            'text' => 'Inventario',
            'icon' => 'fas fa-fw fa-check-square',
            'icon_color' => 'teal',
            'can' => 'ver producto',
            'submenu' => [

                [
                    'text' => 'Productos',
                    'url' => '/productos',
                    'can' => 'ver producto',
                ],
               
                [
                    'text' => 'Ordenes de compra',
                    'url' => '/inventarioingresos',
                    'can' => 'ver producto',
                ],
                [
                    'text' => 'Ingresos rápidos',
                    'url' => '/invingresosrapidos',
                    'can' => 'ver producto',
                ],

                [
                    'text' => 'Salidas rápidas',
                    'url' => '/invsalidasrapidas',
                    'can' => 'ver producto',
                ],

                [
                    'text' => 'Requerimientos',
                    'url' => '/inventariosalidas',
                    'can' => 'ver producto',
                ],

                [
                    'text' => 'Apertura',
                    'url' => '/inventarioingresoapertura',
                    'can' => 'ver producto',
                ],

                [
                    'text' => 'Proveedores',
                    'url' => '/proveedores',
                    'can' => 'ver producto',
                ],


                [
                    'text' => 'Prestamos',
                    'submenu' => [
                        [
                            'text' => 'Ingresos como prestamo',
                            'url' => '/inventarioprestamoingreso',
                            'can' => 'ver producto',
                        ],

                        [
                            'text' => 'Salidas como prestamo',
                            'url' => '/inventarioprestamosalida',
                            'can' => 'ver producto',
                        ],

                    ],

                ],

            ],
        ],

        ['header' => 'CONFIGURACIÓN DE CUENTAS', 'can' => 'ver producto'],

        [
            'text' => 'Usuarios',
            'icon' => 'fas fa-fw fa-users',
            'can' => 'ver producto',
            'submenu' => [
                [
                    'text' => 'usuarios',
                    'url' => '/users',
                    'can' => 'ver producto'
                ],
                [
                    'text' => 'roles',
                    'url' => '/roles',
                    'can' => 'ver producto'
                ],
                [
                    'text' => 'permisos',
                    'url' => '/permissions',
                    'can' => 'ver producto'
                ],
            ],
        ],
        ['header' => 'COMEDOR', 'can' => 'ver producto'],

        [
            'text' => 'Comedor',
            'icon_color' => 'yellow',
            'url' => '/ranchos',
            'can' => 'view comedor',
        ],
        [
            'text' => 'Comedor Pagos',
            'icon_color' => 'cyan',
            'url' => '/abonados',
            'can' => 'use pagos tickets comedor',
        ],

        ['header' => 'EN DESARROLLO', 'can' => 'ver producto'],

        [
            'text' => 'Programaciones',
            'icon_color' => 'yellow',
            'url' => '/programacion',
            'can' => 'usar programaciones',

        ],
        [
            'text' => 'Registros',
            'icon_color' => 'cyan',
            'url' => '/registros',
            'can' => 'ver producto'
        ],

        ['header' => 'BALANZA', 'can' => 'ver balanza'],

        [
            'text' => 'Balanza',
            'icon_color' => 'green',
            'url' => '/pesos',
            'can' => 'ver balanza',

        ],


        ['header' => 'CLIENTES', 'can' => 'use cuenta'],
        [
            'text' => 'CLIENTES',
            'icon' => 'fas fa-fw fa-truck-monster',
            'icon_color' => 'navy',
            'can' => 'use cuenta',
            'submenu' => [

                [
                    'text' => 'Clientes',
                    'url' => '/lqclientes',
                    'can' => 'use cuenta',
                ],

                [
                    'text' => 'Sociedades',
                    'url' => '/lqsociedades',
                    'can' => 'use cuenta',
                ],





            ],
        ],

        ['header' => 'TESORERÍA', 'can' => 'use cuenta'],
        [
            'text' => 'Bancos',
            'icon_color' => 'green',
            'url' => '/tsbancos',
            'can' => 'use cuenta'
        ],

        [
            'text' => 'Motivos movimientos',
            'icon_color' => 'yellow',
            'url' => '/tsmotivos',
            'can' => 'use cuenta'
        ],

        [
            'text' => 'Tipos Comprobantes',
            'icon_color' => 'cyan',
            'url' => '/tiposcomprobantes',
            'can' => 'use cuenta'
        ],


        [



            'text' => 'CAJAS',
            'icon' => 'fas fa-fw  fa-th-large',
            'icon_color' => 'orange',
            'can' => 'use cuenta',
            'submenu' => [

                [
                    'text' => 'Cajas',
                    'url' => '/tscajas',
                    'can' => 'use cuenta',
                ],

                [
                    'text' => 'Reposiciones Cajas',
                    'url' => '/tsreposicionescajas',
                    'can' => 'use cuenta',
                ],

                [
                    'text' => 'Salidas Cajas',
                    'url' => '/tssalidascajas',
                    'can' => 'use cuenta',
                ],




            ],
        ],


        [

            'text' => 'CUENTAS',
            'icon' => 'fas fa-fw   fa-credit-card',
            'icon_color' => 'light   ',
            'can' => 'use cuenta',
            'font-size' => '10px',
            'submenu' => [

                [
                    'text' => 'Cuentas',
                    'url' => '/tscuentas',
                    'can' => 'use cuenta',
                ],


                [
                    'text' => 'Ingresos Cuentas',
                    'url' => '/tsingresoscuentas',
                    'can' => 'use cuenta',
                ],


                [
                    'text' => 'Salidas Cuentas',
                    'url' => '/tssalidascuentas',
                    'can' => 'use cuenta',
                ],


                [
                    'text' => 'Adelantos',
                    'url' => '/lqadelantos',
                    'can' => 'use cuenta',
                ],

                [
                    'text' => 'Devoluciones',
                    'url' => '/lqdevoluciones',
                    'can' => 'use cuenta',
                ],

                [
                    'text' => 'Liquidaciones',
                    'url' => '/lqliquidaciones',
                    'can' => 'use cuenta',
                ],


            ],
        ],



        ['header' => 'ESTRUCTURA ORGANIZACIONAL', 'can' => 'edit cuenta'],
        [
            'text' => 'ORGANIZACIÓN',
            'icon' => 'fas fa-fw fa-sitemap',
            'icon_color' => 'lime',
            'can' => 'edit cuenta',
            'submenu' => [

                [
                    'text' => 'Áreas',
                    'url' => '/areas',
                    'can' => 'use cuenta',
                ],

                [
                    'text' => 'Posiciones',
                    'url' => '/posiciones',
                    'can' => 'use cuenta',
                ],

                [
                    'text' => 'Empleados',
                    'url' => '/empleados',
                    'can' => 'use cuenta',
                ],




            ],
        ],




        ['header' => 'MIS CAJAS', 'can' => 'use caja',],
        [
            'text' => 'MIS CAJAS',
            'icon_color' => 'green',
            'url' => '/tsmiscajas',
            'can' => 'use caja',
        ],











        ['header' => ''],
        ['header' => ''],
        ['header' => ''],
        ['header' => ''],
        ['header' => ''],



    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
