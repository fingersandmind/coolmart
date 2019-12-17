@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Purchase Orders</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            </ol>
            {{-- <a href="{{ route('items.create') }}" class="btn btn-outline-primary"><i class="fa fa-plus mr-2"></i>Add Item</a> --}}
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Unit Items</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="wd-10p">Purchase Code</th>
                                        <th class="wd-10p">Issued By</th>
                                        <th class="wd-10p">Date Issued</th>
                                        <th class="wd-10p">Total Items</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- table-wrapper -->
                </div>
            <!-- section-wrapper -->

            </div>
        </div>
    </div>
</div>
@endsection

@push('additionalCSS')
    <link href="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
@endpush

@push('additionalJS')
    @include('pages.page-partials.datatables')
@endpush