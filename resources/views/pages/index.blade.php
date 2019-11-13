@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Dashboard</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            </ol>
            <a href="{{ route('orders.create') }}" class="btn btn-outline-primary"><i class="fa fa-shopping-cart fa-spin"></i> New Purchase Order</a>
        </div>
        <div class="row row-cards">
            <div class="col-sm-12 col-lg-3">
                <div class="card bg-primary card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/circle.svg" class="card-img-absolute" alt="circle-image">
                        <h4 class="font-weight-normal  mb-3">Total Brands
                            <i class="fa fa-steam-square fs-30 float-right"></i>
                        </h4>
                        <h2 class="mb-0">{{ $brandCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-3">
                <div class="card bg-warning card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/circle.svg" class="card-img-absolute" alt="circle-image">
                        <h4 class="font-weight-normal  mb-3">Unit Models/Items
                            <i class="fa fa-cubes fs-30 float-right"></i>
                        </h4>
                        <h2 class="mb-0">{{ $itemCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-3">
                <div class="card bg-info card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/circle.svg" class="card-img-absolute" alt="circle-image">
                        <h4 class="font-weight-normal mb-3">Reviews
                            <i class="fa fa-spin fa-thumbs-o-down fs-30 float-right"></i>
                        </h4>
                        <h2 class="mb-0">0</h2>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-3">
                <div class="card bg-success card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/circle.svg" class="card-img-absolute" alt="circle-image">
                        <h4 class="font-weight-normal  mb-3">Customers
                            <i class="fa fa-group fs-30 float-right"></i>
                        </h4>
                        <h2 class="mb-0">{{ $userCount }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-deck">
            <div class="col-lg-8 col-sm-12">
                <div class="card ">
                    <div class="card-header">
                        <h3 class="card-title">Company Growth Yearly</h3>
                    </div>
                    <div class="card-body">
                        <div id="echart1" class="chartsh"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="card ">
                    <div class="card-header">
                        <div class="card-title">Monthly View</div>
                    </div>
                    <div class="card-body p-4">
                        <div class="chats-wrap">
                            <div class="chat-details mb-1 p-3">
                                <h4 class="mb-0">
                                    <span class="h5 font-weight-normal">Sales</span>
                                    <span class="float-right p-1 bg-primary btn btn-sm text-white">
                                    <b>70</b>%</span>
                                </h4>
                                <div class="progress progress-md mt-3">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 70%"></div>
                                </div>
                            </div>
                            <div class="chat-details mb-1 p-3">
                                <h4 class="mb-0">
                                    <span class="h5 font-weight-normal">Profit</span>
                                    <span class="float-right p-1 bg-secondary  btn btn-sm text-white">
                                        <b>60</b>%</span>
                                </h4>
                                <div class="progress progress-md mt-3">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" style="width: 60%"></div>
                                </div>
                            </div>
                            <div class="chat-details mb-1 p-3">
                                <h4 class="mb-0">
                                    <span class="h5 font-weight-normal">Users</span>
                                    <span class="float-right p-1 bg-cyan btn btn-sm text-white">
                                        <b>47%</b>
                                    </span>
                                </h4>
                                <div class="progress progress-md mt-3">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-cyan" style="width: 47%"></div>
                                </div>
                            </div>
                            <div class="chat-details mb-1 p-3">
                                <h4 class="mb-0">
                                    <span class="h5 font-weight-normal">Growth</span>
                                    <span class="float-right p-1 bg-info btn btn-sm text-white">
                                        <b>25%</b>
                                    </span>
                                </h4>
                                <div class="progress progress-md mt-3">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated  bg-info" style="width: 25%"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cards">
            <div class="col-md-12 col-lg-4 col-sm-12">
                <div class="card  mb-5">
                    <div class="card-body">
                        <div class="media mt-0">
                            <figure class="rounded-circle align-self-start mb-0">
                                <img src="assets/images/faces/female/1.jpg" alt="Generic placeholder image" class="avatar brround avatar-md mr-3">
                            </figure>
                            <div class="media-body">
                                <h5 class="time-title p-0 mb-0 font-weight-semibold leading-normal">Victoria</h5>
                                New york, UK
                            </div>
                            <button class="btn btn-primary d-none d-sm-block mr-2"><i class="fa fa-comments"></i> </button>
                            <button class="btn btn-info d-none d-sm-block"><i class="fa fa-phone"></i> </button>
                        </div>
                    </div>
                    <div class="card-footer border-top">
                        Email: <span class="text-primary">victoriacott@Viboon.com</span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4 col-sm-12">
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="media mt-0">
                            <figure class="rounded-circle align-self-start mb-0">
                                <img src="assets/images/faces/male/18.jpg" alt="Generic placeholder image" class="avatar brround avatar-md mr-3">
                            </figure>
                            <div class="media-body">
                                <h5 class="time-title p-0 mb-0 font-weight-semibold leading-normal">Thomas Jaim</h5>
                                Spain, UN
                            </div>
                            <button class="btn btn-primary d-none d-sm-block mr-2"><i class="fa fa-comments"></i> </button>
                            <button class="btn btn-info d-none d-sm-block"><i class="fa fa-phone"></i> </button>
                        </div>
                    </div>
                    <div class="card-footer border-top">
                        Email: <span class="text-primary">thomasjaim@Viboon.com</span>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-4 col-sm-12">
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="media mt-0">
                            <figure class="rounded-circle align-self-start mb-0">
                                <img src="assets/images/faces/female/18.jpg" alt="Generic placeholder image" class="avatar brround avatar-md mr-3">
                            </figure>
                            <div class="media-body">
                                <h5 class="time-title p-0 font-weight-semibold leading-normal mb-0">Rebbaca wisely</h5>
                                Japan, UN
                            </div>
                            <button class="btn btn-primary d-none d-sm-block mr-2"><i class="fa fa-comments"></i> </button>
                            <button class="btn btn-info d-none d-sm-block"><i class="fa fa-phone"></i> </button>
                        </div>
                    </div>
                    <div class="card-footer border-top">
                        Email: <span class="text-primary">rebbacawisely@Viboon.com</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mg-t-20">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="card-title ">Purchase Orders</h3>
                    </div>
                    <div class="">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="wd-10p">Purchase Code</th>
                                            <th class="wd-10p">Issued By</th>
                                            <th class="wd-10p">Date Issued</th>
                                            <th class="wd-10p">Total Items</th>
                                            <th class="wd-10p">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pos as $po)
                                            <tr>
                                                <td>{{ $po->PurchaseCode }}</td>
                                                <td>{{ ucfirst($po->user->name) }}</td>
                                                <td>{{ $po->created_at->toFormattedDateString() }}</td>
                                                <td>{{ $po->totalItems() }}</td>
                                                <td>
                                                    <a href="{{ route('purchase.order', $po->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cards row-deck">
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Mesages</div>
                    </div>
                    <div class="chat_container">
                        <div class="job-box">
                            <div class="job-box-filter">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                    <label class="mt-2">Show 
                                    <select name="datatable_length" class="form-control input-sm">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    </select>
                                    entries</label>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="filter-search-box text-right ">
                                            <label class="mt-2"><input type="search" class="form-control input-sm" placeholder="Search here"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="inbox-message">
                                <ul>
                                    <li>
                                        <a href="#">
                                            <div class="message-avatar">
                                                <img src="assets/images/faces/female/2.jpg" alt="">
                                            </div>
                                            <div class="message-body">
                                                <div class="message-body-heading">
                                                    <h5>Ninfa Sluder <span class="unread bg-primary">Unread</span></h5>
                                                    <span class="text-primary">1 hour ago</span>
                                                </div>
                                                <p class="mb-1">Hello, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolor....</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="message-avatar">
                                                <img src="assets/images/faces/male/20.jpg" alt="">
                                            </div>
                                            <div class="message-body">
                                                <div class="message-body-heading">
                                                    <h5>Johnson Craver <span class="unread bg-primary">Unread</span></h5>
                                                    <span  class="text-primary">3 hours ago</span>
                                                </div>
                                                <p class="mb-1">Hello, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolor....</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="message-avatar">
                                                <img src="assets/images/faces/female/20.jpg" alt="">
                                            </div>
                                            <div class="message-body">
                                                <div class="message-body-heading">
                                                    <h5>Vida Porter <span class="pending bg-warning">Pending Work</span></h5>
                                                    <span  class="text-warning">7 hours ago</span>
                                                </div>
                                                <p class="mb-1">Hello, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolor....</p>
                                            </div>
                                        </a>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center border-top-0">
                        <a href="#"><i class="fa fa-angle-down"></i> View More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <div class="card-title">Friends</div>
                    </div>
                    <div class="card-body">
                        <div class="visitor-list">
                            <div class="media m-0">
                                <div class="avatar brround avatar-md mr-3" style="background-image: url(assets/images/faces/female/18.jpg)"></div>
                                <div class="media-body">
                                    <a href="#" class="text-default font-weight-medium">Tonia Rotella</a>
                                    <p class="text-muted ">Software Designer</p>
                                </div>
                                <!-- media-body -->
                                <a href="#" class="btn btn-outline-primary btn-sm">Add Friend</a>
                            </div>
                            <!-- media -->
                            <div class="media mt-2">
                                <div class="avatar brround avatar-md mr-3" style="background-image: url(assets/images/faces/female/20.jpg)"></div>
                                <div class="media-body">
                                    <a href="#" class="text-default font-weight-medium">Justin</a>
                                    <p class="text-muted">Sales Representative</p>
                                </div>
                                <!-- media-body -->
                                <a href="#" class="btn btn-outline-primary btn-sm">Add Friend</a>
                            </div>
                            <!-- media -->
                            <div class="media mt-2">
                                <div class="avatar brround avatar-md mr-3" style="background-image: url(assets/images/faces/male/8.jpg)"></div>
                                <div class="media-body">
                                    <a href="#" class="text-default font-weight-medium">Leo Amy</a>
                                    <p class="text-muted">Architect</p>
                                </div>
                                <!-- media-body -->
                                <a href="#" class="btn btn-outline-primary btn-sm">Add Friend</a>
                            </div>
                            <!-- media -->
                            <div class="media mt-2">
                                <div class="avatar brround avatar-md mr-3" style="background-image: url(assets/images/faces/female/22.jpg)"></div>
                                <div class="media-body">
                                    <a href="#" class="text-default font-weight-medium">Dyan Cullins</a>
                                    <p class="text-muted">Accountant</p>
                                </div>
                                <!-- media-body -->
                                <a href="#" class="btn btn-outline-primary btn-sm">Add Friend</a>
                            </div>
                            <!-- media -->
                            <div class="media mt-3">
                                <div class="avatar brround avatar-md mr-3" style="background-image: url(assets/images/faces/male/18.jpg)"></div>
                                <div class="media-body">
                                    <a href="#" class="text-default font-weight-medium">Palmer Hoar</a>
                                    <p class="text-muted">Marketing Manager</p>
                                </div>
                                <!-- media-body -->
                                <a href="#" class="btn btn-outline-primary btn-sm">Add Friend</a>
                            </div>
                            
                            <div class="media mt-3">
                                <div class="avatar brround avatar-md mr-3" style="background-image: url(assets/images/faces/male/10.jpg)"></div>
                                <div class="media-body">
                                    <a href="#" class="text-default font-weight-medium">Hubert Dowless</a>
                                    <p class="text-muted m-0">General Manager</p>
                                </div>
                                <!-- media-body -->
                                <a href="#" class="btn btn-outline-primary btn-sm">Add Friend</a>
                            </div>
                        </div>
                        <!-- media-list -->
                    </div>
                    <div class="card-footer text-center">
                        <a href="#"><i class="fa fa-angle-down" ></i> View More</a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

@push('additionalCSS')
<!-- c3.js Charts Plugin -->
<link href="{{ asset('assets/plugins/charts-c3/c3-chart.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
@endpush

@push('additionalJS')
<script src="{{ asset('assets/plugins/echarts/echarts.js') }}"></script>
<script src="{{ asset('assets/js/index1.js') }}"></script>
<!--Morris.js Charts Plugin -->
<script src="{{ asset('assets/plugins/am-chart/amcharts.js') }}"></script>
<script src="{{ asset('assets/plugins/am-chart/serial.js') }}"></script>
@include('pages.page-partials.datatables')
@endpush