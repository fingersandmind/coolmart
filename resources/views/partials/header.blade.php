<div class="header py-1">
    <div class="container">
        <div class="d-flex">
            <a class="header-brand" href="{{ route('dashboard') }}">
                <img src="{{ asset('assets/images/brand/logo.png') }}" class="header-brand-img" alt="Viboon logo">
            </a>
            <div class=" ">
                <form class="input-icon mt-2 ">
                    <div class="input-icon-addon">
                        <i class="fe fe-search"></i>
                    </div>
                    <input type="search" class="form-control header-search" placeholder="Search&hellip;" tabindex="1">
                </form>
            </div>
            <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown d-none d-md-flex mt-1" >
                    <a  class="nav-link icon full-screen-link">
                        <i class="fe fe-maximize floating"  id="fullscreen-button"></i>
                    </a>
                </div>
                <div class="dropdown d-none d-md-flex mt-1 country-selector">
                    <a href="#" class="d-flex nav-link pr-0 leading-none" data-toggle="dropdown">
                        <span class="avatar avatar-sm mr-1 align-self-center" style="background-image: url({{ asset('assets/images/us_flag.jpg') }})"></span>
                        <div>
                            <strong class="text-white">English</strong>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <span class="avatar  mr-3 align-self-center" style="background-image: url({{ asset('assets/images/french_flag.jpg') }})"></span>
                            <div>
                                <strong>French</strong>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <span class="avatar  mr-3 align-self-center" style="background-image: url({{ asset('assets/images/germany_flag.jpg') }})"></span>
                            <div>
                                <strong>Germany</strong>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <span class="avatar mr-3 align-self-center" style="background-image: url({{ asset('assets/images/italy_flag.jpg') }})"></span>
                            <div>
                                <strong>Italy</strong>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <span class="avatar mr-3 align-self-center" style="background-image: url({{ asset('assets/images/russia_flag.jpg') }})"></span>
                            <div>
                                <strong>Russia</strong>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <span class="avatar  mr-3 align-self-center" style="background-image: url({{ asset('assets/images/spain_flag.jpg') }})"></span>
                            <div>
                                <strong>Spain</strong>
                            </div>
                        </a>
                    </div>
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
                        <i class="fe fe-mail floating"></i>
                        <span class=" nav-unread badge badge-warning  badge-pill">2</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <a href="#" class="dropdown-item text-center">2 New Messages</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <span class="avatar brround mr-3 align-self-center" style="background-image: url({{ asset('assets/images/faces/male/41.jpg') }})"></span>
                            <div>
                                <strong>Madeleine</strong> Hey! there I' am available....
                                <div class="small text-muted">3 hours ago</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <span class="avatar brround mr-3 align-self-center" style="background-image: url({{ asset('assets/images/faces/female/1.jpg') }})"></span>
                            <div>
                                <strong>Anthony</strong> New product Launching...
                                <div class="small text-muted">5  hour ago</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <span class="avatar brround mr-3 align-self-center" style="background-image: url({{ asset('assets/images/faces/female/18.jpg') }})"></span>
                            <div>
                                <strong>Olivia</strong> New Schedule Realease......
                                <div class="small text-muted">45 mintues ago</div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-center">See all Messages</a>
                    </div>
                </div>
                <div class="dropdown d-none d-md-flex mt-1">
                    <a class="nav-link icon" data-toggle="dropdown">
                        <i class="fe fe-grid floating"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <ul class="drop-icon-wrap p-1">
                            <li>
                                <a href="email.html" class="drop-icon-item">
                                    <i class="fe fe-mail text-dark"></i>
                                    <span class="block"> E-mail</span>
                                </a>
                            </li>
                            <li>
                                <a href="calendar2.html" class="drop-icon-item">
                                    <i class="fe fe-calendar text-dark"></i>
                                    <span class="block">calendar</span>
                                </a>
                            </li>
                            <li>
                                <a href="maps.html" class="drop-icon-item">
                                    <i class="fe fe-map-pin text-dark"></i>
                                    <span class="block">map</span>
                                </a>
                            </li>
                            <li>
                                <a href="cart.html" class="drop-icon-item">
                                    <i class="fe fe-shopping-cart text-dark"></i>
                                    <span class="block">Cart</span>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html" class="drop-icon-item">
                                    <i class="fe fe-message-square text-dark"></i>
                                    <span class="block">chat</span>
                                </a>
                            </li>
                            <li>
                                <a href="profile.html" class="drop-icon-item">
                                    <i class="fe fe-phone-outgoing text-dark"></i>
                                    <span class="block">contact</span>
                                </a>
                            </li>
                        </ul>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-center">View all</a>
                    </div>
                </div>
                <div class="dropdown mt-1">
                    <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                        <span class="avatar avatar-md brround" style="background-image: url({{ asset('assets/images/faces/female/25.jpg') }})"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
                        <div class="text-center">
                            <a href="#" class="dropdown-item text-center font-weight-sembold user">Jessica Allan</a>
                            <span class="text-center user-semi-title text-dark">web designer</span>
                            <div class="dropdown-divider"></div>
                        </div>
                        <a class="dropdown-item" href="#">
                            <i class="dropdown-icon mdi mdi-account-outline "></i> Profile
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="dropdown-icon  mdi mdi-settings"></i> Settings
                        </a>
                        <a class="dropdown-item" href="#">
                            <span class="float-right"><span class="badge badge-primary">6</span></span>
                            <i class="dropdown-icon mdi  mdi-message-outline"></i> Inbox
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="dropdown-icon mdi mdi-comment-check-outline"></i> Message
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">
                            <i class="dropdown-icon mdi mdi-compass-outline"></i> Need help?
                        </a>
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