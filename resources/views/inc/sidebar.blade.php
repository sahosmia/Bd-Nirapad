@php
$page  = explode("/", $_SERVER['REQUEST_URI'])[2];
@endphp
<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{route('dashboard')}}">
                <span class="brand-logo">
                    <img width="100%" src="{{url('storage')}}/{{setting('site.logo')}}">
                </span>
                {{-- <h2 class="brand-text">{{ucwords(config('app.name'))}}</h2> --}}
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item d-md-none d-block active pb-1"><a class="d-flex align-items-center"><span class="menu-title text-truncate" data-i18n="Dashboards">Credits : @if($user->role_id == 1 || $user->role_id == 2) Unlimited @else {{$user->credits}} @endif</span></a></li>
            <li class=" nav-item @if($page == "home") active @endif"><a class="d-flex align-items-center" href="{{route('dashboard')}}"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboard</span></a></li>
            @if($user->role_id != 4 && $user->level != 1 && $user->role_id != 5 && $user->role_id != 6)
                <li class=" nav-item @if($page == "users") active @endif"><a class="d-flex align-items-center" href="{{route('users',$user->ref_key)}}"><i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Users</span></a></li>
            @elseif($user->role_id == 4 && $user->level != 1)
                <li class=" nav-item @if($page == "users") active @endif"><a class="d-flex align-items-center" href="{{route('users',$user->ref_key)}}"><i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Users</span></a></li>
            @endif
            <li class=" nav-item @yield("credit-request")"><a class="d-flex align-items-center" href="{{route('credit_request')}}"><i class="fa-regular fa-dollar-sign"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Credit Logs</span></a></li>
            <li class=" nav-item @if($page == "all-reports") active @endif"><a class="d-flex align-items-center" href="{{route('all_reports',$user->ref_key)}}"><i class="fa-regular fa-rectangle-history"></i><span class="menu-title text-truncate" data-i18n="Dashboards">All Reports</span></a></li>
            <!--@if($user->role_id != 5)-->
            <!--    <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i class="fa-regular fa-rectangle-history"></i><span class="menu-title text-truncate" data-i18n="Invoice">Reports</span></a>-->
            <!--        <ul class="menu-content">-->
                        <!--<li class="nav-item @if($page == "reports") active @endif"><a class="d-flex align-items-center" href="{{route('reports',$user->ref_key)}}"><span class="menu-title text-truncate" data-i18n="Dashboards">Reports</span></a></li>-->
            <!--            <li class="nav-item @if($page == "all-reports") active @endif"><a class="d-flex align-items-center" href="{{route('all_reports',$user->ref_key)}}"><span class="menu-title text-truncate" data-i18n="Dashboards">All Reports</span></a></li>-->
            <!--        </ul>-->
            <!--    </li>-->
            <!--@endif-->
            <!--<li class=" nav-item @if($page == "plans") active @endif"><a class="d-flex align-items-center" href="{{route('plans')}}"><i class="fa-light fa-paper-plane-top"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Plan</span></a></li>-->
              @if ($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 3 || $user->role_id == 4 || $user->role_id == 6)
                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i
                            class="fa-light fa-building-columns"></i><span class="menu-title text-truncate"
                            data-i18n="Invoice">Bank</span></a>
                    <ul class="menu-content">
                        @if ($user->role_id == 1 || $user->role_id == 3 || $user->role_id == 4)
                            <li class="nav-item @if ($page == 'bank') active @endif"><a
                                    class="d-flex align-items-center" href="{{ route('bank') }}"><span
                                        class="menu-title text-truncate" data-i18n="Dashboards">New Request</span></a>
                            </li>
                        @endif
                        @if ($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 3 || $user->role_id == 4 || $user->role_id == 6)
                            <li class="nav-item @if ($page == 'requests') active @endif"><a
                                    class="d-flex align-items-center"
                                    href="{{ route('requests', $user->ref_key) }}"><span
                                        class="menu-title text-truncate" data-i18n="Dashboards">Requests List</span></a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @php
                use App\Models\User;
                $total_assin_member = User::where('partner_id', auth()->id())->count();
            @endphp

            @if ($user->role_id != 5 || $user->role_id == 5  || ($user->role_id == 6 && $total_assin_member > 0) )
                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i
                            class="fa-regular fa-laptop-mobile"></i><span class="menu-title text-truncate"
                            data-i18n="Invoice">Mobile Banking</span></a>
                    <ul class="menu-content">
                        @if ($user->role_id == 1 || $user->role_id == 3 || $user->role_id == 4)
                            <li class="nav-item @if ($page == 'mobile-banking') active @endif"><a
                                    class="d-flex align-items-center" href="{{ route('mobile_banking') }}"><span
                                        class="menu-title text-truncate" data-i18n="Dashboards">New Request</span></a>
                            </li>
                        @endif
                        @if ($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 3 || $user->role_id == 4 || $user->role_id == 5 || $user->role_id == 6)
                            <li class="nav-item @if ($page == 'mobile-banking-request') active @endif"><a
                                    class="d-flex align-items-center"
                                    href="{{ route('mobile_banking_request', $user->ref_key) }}"><span
                                        class="menu-title text-truncate" data-i18n="Dashboards">Request
                                        List</span></a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if ($user->role_id != 5 )
                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i
                            class="fa-light fa-battery-bolt"></i><span class="menu-title text-truncate"
                            data-i18n="Invoice">Mobile Recharge</span></a>
                    <ul class="menu-content">
                        @if ($user->role_id == 1 || $user->role_id != 5  )
                            @if ($user->role_id != 2 && $user->role_id != 6 )


                            <li class="nav-item @if ($page == 'mobile-recharge') active @endif"><a
                                class="d-flex align-items-center" href="{{ route('mobile_recharge') }}"><span
                                class="menu-title text-truncate" data-i18n="Dashboards">New
                                Request</span></a></li>

                            @endif
                        @endif

                        @if ($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 3 || $user->role_id == 4 || $user->role_id == 6)
                            <li class="nav-item @if ($page == 'mobile-recharge-request') active @endif"><a
                                    class="d-flex align-items-center"
                                    href="{{ route('mobile_recharge_request', $user->ref_key) }}"><span
                                        class="menu-title text-truncate" data-i18n="Dashboards">Request
                                        List</span></a></li>
                        @endif
                    </ul>
                </li>
            @endif
            {{-- <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Apps &amp; Pages</span><i data-feather="more-horizontal"></i>
            </li> --}}
        </ul>
    </div>
</div>
<!-- END: Main Menu-->