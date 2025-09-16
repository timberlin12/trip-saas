<div id="kt_header" style="" class="header align-items-stretch">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Aside mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show aside menu">
            <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_aside_mobile_toggle">
                <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" />
                        <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
        </div>
        <!--end::Aside mobile toggle-->
        <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="../../demo1/dist/index.html" class="d-lg-none">
                <img alt="Logo" src="{{ asset('media/logos/logo-2.svg') }}" class="h-30px" />
            </a>
        </div>
        <!--end::Mobile logo-->
        <!--begin::Wrapper-->
        <div class="d-flex align-items-stretch flex-lg-grow-1">
            <!--begin::Toolbar wrapper-->
            <div class="d-flex align-items-stretch flex-shrink-0 ms-auto">
                <!--begin::Theme mode-->
                <div class="d-flex align-items-center ms-1 ms-lg-3">
                    @php
                        $currentTheme = session('theme', 'light');
                    @endphp

                    @if($currentTheme === 'light')
                        <a class="btn btn-icon btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px"
                        href="{{ route('set-theme', 'dark') }}">
                            <i class="fonticon-sun fs-2"></i>
                        </a>
                    @else
                        <a class="btn btn-icon btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px"
                        href="{{ route('set-theme', 'light') }}">
                            <i class="fonticon-moon fs-2"></i>
                        </a>
                    @endif
                </div>
                <!--end::Theme mode-->
                <!--begin::User menu-->
                <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                    <!--begin::Menu wrapper-->
                    <div class="cursor-pointer symbol symbol-30px symbol-md-40px d-flex align-items-center justify-content-center bg-light text-dark fw-bold" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" style="font-size: 16px;">
                        @php
                            $words = explode(' ', Auth::user()->name);
                            $initials = strtoupper($words[0][0]);
                            if(count($words) > 1) $initials .= strtoupper($words[1][0]);
                        @endphp
                        {{ $initials }}
                    </div>
                    <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5 d-flex align-items-center justify-content-center fw-bold text-dark" style="background: linear-gradient(135deg, #fdfbfb, #ebedee); font-size: 22 $user = Auth::user()px;">
                                    {{ $initials }}
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="fw-bolder d-flex align-items-center fs-5">{{ Auth::user()->name }}
                                    </div>
                                    <a href="#" class="fw-bold text-muted text-hover-primary fs-7">{{ Auth::user()->email }}</a>
                                    <div class="fw-bolder d-flex align-items-center fs-5">
                                        <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 mt-1" style="width: auto;">
                                            {{ Auth::user()->getRoleNames()->first() ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="../../demo1/dist/account/overview.html" class="menu-link px-5">{{ __('messages.my_profile') }}</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start">
                            <a href="#" class="menu-link px-5">
                                <span class="menu-title">My Subscription</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <!--begin::Menu sub-->
                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="../../demo1/dist/account/billing.html" class="menu-link px-5">Billing</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="../../demo1/dist/account/statements.html" class="menu-link px-5">Payments</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu sub-->
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="{{ app()->getLocale() == 'ar' ? 'right-start' : 'left-start' }}">
                            <a href="#" class="menu-link px-5">
                                <span class="menu-title position-relative">
                                    {{ __('Language') }}
                                    <span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">
                                        {{ app()->getLocale() == 'ar' ? 'Arabic' : 'English' }}
                                        <img class="w-15px h-15px rounded-1 ms-2"
                                            src="{{ asset(app()->getLocale() == 'ar' ? 'media/flags/saudi-arabia.svg' : 'media/flags/united-states.svg') }}"
                                            alt="" />
                                    </span>
                                </span>
                            </a>
                            <!--begin::Menu sub-->
                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                <!-- English -->
                                <div class="menu-item px-3">
                                    <a href="{{ url('lang/en') }}"
                                    class="menu-link d-flex px-5 {{ app()->getLocale() == 'en' ? 'active' : '' }}">
                                        <span class="symbol symbol-20px me-4">
                                            <img class="rounded-1" src="{{ asset('media/flags/united-states.svg') }}" alt="" />
                                        </span>
                                        English
                                    </a>
                                </div>
                                <!-- Arabic -->
                                <div class="menu-item px-3">
                                    <a href="{{ url('lang/ar') }}"
                                    class="menu-link d-flex px-5 {{ app()->getLocale() == 'ar' ? 'active' : '' }}">
                                        <span class="symbol symbol-20px me-4">
                                            <img class="rounded-1" src="{{ asset('media/flags/saudi-arabia.svg') }}" alt="" />
                                        </span>
                                        Arabic
                                    </a>
                                </div>
                            </div>
                            <!--end::Menu sub-->
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5 my-1">
                            <a href="../../demo1/dist/account/settings.html" class="menu-link px-5">Account Settings</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <a href="#" id="logoutButton" class="menu-link px-5" data-url="{{ route('logout') }}" data-login-url="{{ route('login') }}">Sign Out</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::User account menu-->
                    <!--end::Menu wrapper-->
                </div>
                <!--end::User menu-->
                <!--begin::Header menu toggle-->
                <div class="d-flex align-items-center d-lg-none ms-2 me-n3" title="Show header menu">
                    <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle">
                        <!--begin::Svg Icon | path: icons/duotune/text/txt001.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M13 11H3C2.4 11 2 10.6 2 10V9C2 8.4 2.4 8 3 8H13C13.6 8 14 8.4 14 9V10C14 10.6 13.6 11 13 11ZM22 5V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4V5C2 5.6 2.4 6 3 6H21C21.6 6 22 5.6 22 5Z" fill="currentColor" />
                                <path opacity="0.3" d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                </div>
                <!--end::Header menu toggle-->
            </div>
            <!--end::Toolbar wrapper-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Container-->
</div>
