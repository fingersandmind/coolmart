<div class="header py-1">
    <div class="container">
        <div class="d-flex">
            <a class="header-brand" href="{{ route('dashboard') }}">
                <img src="{{ asset('assets/images/brand/logo.png') }}" class="header-brand-img" alt="Viboon logo">
            </a>
            <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown d-none d-md-flex mt-1" >
                    <a  class="nav-link icon full-screen-link">
                        <i class="fe fe-maximize floating"  id="fullscreen-button"></i>
                    </a>
                </div>
                <div class="dropdown d-none d-md-flex mt-1">
                    <a class="nav-link icon" data-toggle="dropdown">
                        <i class="fe fe-bell floating"></i>
                        <span class="nav-unread bg-danger"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <div class="notifyimg">
                                <i class="fa fa-thumbs-o-up"></i>
                            </div>
                            <div>
                                <strong>Someone likes our posts.</strong>
                                <div class="small text-muted">3 hours ago</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <div class="notifyimg">
                                <i class="fa fa-commenting-o"></i>
                            </div>
                            <div>
                                <strong> 3 New Comments</strong>
                                <div class="small text-muted">5  hour ago</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <div class="notifyimg">
                                <i class="fa fa-cogs"></i>
                            </div>
                            <div>
                                <strong> Server Rebooted.</strong>
                                <div class="small text-muted">45 mintues ago</div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-center">View all Notification</a>
                    </div>
                </div>
                <div class="dropdown d-none d-md-flex mt-1">
                    <a class="nav-link icon" data-toggle="dropdown">
                        <i class="fe fe-grid floating"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <ul class="drop-icon-wrap p-1">
                            <li>
                                <a href="calendar2.html" class="drop-icon-item">
                                    <i class="fe fe-calendar text-dark"></i>
                                    <span class="block">Calendar</span>
                                </a>
                            </li>
                            <li>
                                <a href="maps.html" class="drop-icon-item">
                                    <i class="fe fe-map-pin text-dark"></i>
                                    <span class="block">Map</span>
                                </a>
                            </li>
                        </ul>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-center">View all</a>
                    </div>
                </div>
                @php
                    $user = auth()->user();
                @endphp
                <div class="dropdown mt-1">
                    <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                        <span class="avatar avatar-md brround" style="background-image: url(/{{ $user->profile->avatar }})"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
                        <div class="text-center">
                            <a href="#" class="dropdown-item text-center font-weight-sembold user">{{ ucfirst($user->name) }}</a>
                            <span class="text-center user-semi-title text-dark">{{ $user->profile->title }}</span>
                            <div class="dropdown-divider"></div>
                        </div>
                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                            <i class="dropdown-icon mdi mdi-account-outline "></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="dropdown-icon mdi  mdi-logout-variant"></i> Sign out
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
            <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
            <span class="header-toggler-icon"></span>
            </a>
        </div>
    </div>
</div>