<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="#">
            <!-- <img alt="Logo" src="{{ asset('media/logos/logo-1-dark.svg') }}" class="h-25px logo" /> -->
            <span class="logo fw-bolder fs-5 text-white">Trip Management</span>
        </a>
        <!--end::Logo-->
        <!--begin::Aside toggler-->
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor" />
                    <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Aside toggler-->
    </div>
    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">
                @php
                    $user = Auth::user();
                    $roles = ['superadmin' => 'admin.dashboard', 'company' => 'company.dashboard', 'user' => 'user.dashboard'];
                    $userRole = $user->getRoleNames()->first();
                @endphp
                @if(isset($roles[$userRole]))
                <div class="menu-item {{ (Request::route()->getName() == $roles[$userRole]) ? 'hover show' : '' }}">
                    <a class="menu-link" href="{{ route($roles[$userRole]) }}" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor" />
                                    <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor" />
                                    <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor" />
                                    <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>
                @endif
                @if(isset($roles[$userRole]) && $userRole == 'superadmin')
                    <!-- Company -->
                    <div class="menu-item {{ (Request::route()->getName() == 'companies.index') ? 'hover show' : '' }}">
                        <a class="menu-link" href="{{ route('companies.index') }}">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path d="M20.59 13.41L13.41 20.59C13.05 20.95 12.55 21.13 12.05 21.13C11.55 21.13 11.05 20.95 10.69 20.59L3.41 13.41C3.05 13.05 2.87 12.55 2.87 12.05V5C2.87 3.9 3.77 3 4.87 3H11.92C12.42 3 12.92 3.2 13.29 3.57L20.59 10.87C21.35 11.63 21.35 12.85 20.59 13.41Z" fill="currentColor"/>
                                        <circle cx="8.5" cy="8.5" r="1.5" fill="white"/>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Companies</span>
                        </a>
                    </div>

                    <!-- Pricing plans -->
                    <div class="menu-item {{ (Request::route()->getName() == 'pricing-plans.index') ? 'hover show' : '' }}">
                        <a class="menu-link" href="{{ route('pricing-plans.index') }}">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path d="M20.59 13.41L13.41 20.59C13.05 20.95 12.55 21.13 12.05 21.13C11.55 21.13 11.05 20.95 10.69 20.59L3.41 13.41C3.05 13.05 2.87 12.55 2.87 12.05V5C2.87 3.9 3.77 3 4.87 3H11.92C12.42 3 12.92 3.2 13.29 3.57L20.59 10.87C21.35 11.63 21.35 12.85 20.59 13.41Z" fill="currentColor"/>
                                        <circle cx="8.5" cy="8.5" r="1.5" fill="white"/>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Pricing plans</span>
                        </a>
                    </div>
                @endif

            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
</div>
