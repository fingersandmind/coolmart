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
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="media mt-0">
                            <figure class="rounded-circle align-self-start mb-0">
                                <img src="assets/images/faces/male/18.jpg" alt="Generic placeholder image" class="avatar brround avatar-md mr-3">
                            </figure>
                            <div class="media-body">
                                <h5 class="time-title p-0 mb-0 font-weight-semibold leading-normal">{{ auth()->user()->name }}</h5>
                                Spain, UN
                            </div>
                            <button class="btn btn-primary d-none d-sm-block mr-2"><i class="fa fa-comments"></i> </button>
                            <button class="btn btn-info d-none d-sm-block"><i class="fa fa-phone"></i> </button>
                        </div>
                    </div>
                    <div class="card-footer border-top">
                        Email: <span class="text-primary">{{ auth()->user()->email }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mg-t-20">
            <div class="col-6 grid-margin">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="card-title ">Purchase Orders</h3>
                    </div>
                    <div class="">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-po" class="table table-striped table-bordered" style="width:100%">
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
            <div class="col-6 grid-margin">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <h3 class="card-title ">Supplier's List</h3>
                        <a href="{{ route('download.all') }}" class="btn btn-sm btn-info" onclick="return confirm('This process might take a few seconds. Proceed?');">
                            <i class="fa fa-upload"></i> Update Lists</a>
                    </div>
                    <div class="">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-lists" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="wd-10p">Item Code</th>
                                            <th class="wd-10p">Brand</th>
                                            <th class="wd-10p">Model</th>
                                            <th class="wd-10p">Description</th>
                                            <th class="wd-10p">Net</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lists as $list)
                                            <tr>
                                                <td>{{ $list->ListItemCode }}</td>
                                                <td>{{ ucfirst($list->brand->name) }}</td>
                                                <td>{{ $list->model }}</td>
                                                <td>{{ $list->description }}</td>
                                                <td>{{ $list->net }}</td>
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