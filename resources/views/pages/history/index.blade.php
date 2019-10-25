@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Transaction History</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Transactions</a></li>
                <li class="breadcrumb-item active" aria-current="page">History</li>
            </ol>
            <button type="button" class="btn btn-outline-primary"><i class="fa fa-pencil mr-2"></i>Edit Page</button>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Today</h3>
                    </div>
                    <div class="card-body">
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                <img class="media-object" src="assets/images/media/media2.jpg" alt="topmedia">
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="justify-content-between d-flex">
                                    <h4 class="media-heading">Sold - Repellat5fAHl</h4>
                                    <small>{{ now()->toFormattedDateString() }}</small>
                                </div>
                                <small>Qty x 1 </small>
                            </div>
                        </div>
                        <hr>
                        <div class="media m-0">
                            <div class="media-left">
                                <a href="#">
                                <img class="media-object" src="assets/images/media/media2.jpg" alt="topmedia">
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="justify-content-between d-flex">
                                    <h4 class="media-heading">Sold - Repellat5fAHl</h4>
                                    <small>{{ now()->toFormattedDateString() }}</small>
                                </div>
                                <small>Qty x 1 </small>
                            </div>
                        </div>
                        <hr>
                        <div class="media m-0">
                            <div class="media-left">
                                <a href="#">
                                <img class="media-object" src="assets/images/media/media2.jpg" alt="topmedia">
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="justify-content-between d-flex">
                                    <h4 class="media-heading">Sold - Repellat5fAHl</h4>
                                    <small>{{ now()->toFormattedDateString() }}</small>
                                </div>
                                <small>Qty x 1 </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection