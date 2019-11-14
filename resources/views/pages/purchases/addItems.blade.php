@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Purchase Order</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Purchase Order</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-md-5 col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Unit Items</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="wd-10p">Code</th>
                                        <th class="wd-10p">Brand</th>
                                        <th class="wd-10p">Model</th>
                                        <th class="wd-10p">Net</th>
                                        <th class="wd-20p"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lists as $list)
                                        <tr>
                                            <td>{{ $list->ListItemCode }}</td>
                                            <td>{{ $list->brand->name }}</td>
                                            <td>{{ $list->description }}</td>
                                            <td>{{ number_format($list->net,2) }}</td>
                                            <td>
                                                <form action="{{ route('order.item') }}" method="GET">
                                                    @csrf
                                                    <button name="action" value="{{ $list->id }}" type="submit" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-7">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Purchase Details Preview</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive border ">
                                <table class="table row table-borderless w-100 m-0 ">
                                    <tbody class="col-lg-6 p-0">
                                        <tr>
                                            <td><strong>Company :</strong> {{ $details['company'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Ref No. :</strong>{{ $details['ref_no'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Supplier :</strong>{{ $details['supplier'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Term :</strong>{{ $details['term'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Delivery Date :</strong>{{ $details['delivery_date']->toFormattedDateString() }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>PO Valid Until :</strong>{{ $details['po_valid']->toFormattedDateString() }}</td>
                                        </tr>
                                    </tbody>
                                    <tbody class="col-lg-6 p-0">
                                        <tr>
                                            <td><strong>Ship To :</strong>{{ $details['ship_to'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Location :</strong>{{ $details['location'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Prepared By :</strong>{{ $details['preparedBy'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Noted By :</strong>{{ $details['notedBy'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Items Preview</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive border ">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Model</th>
                                            <th>Net</th>
                                            <th>Qty</th>
                                            {{-- <th>Action</th> --}}
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($orders == null)
                                           <td>
                                            No data
                                           </td>
                                        @else
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>{{ $order['item_code'] }}</td>
                                                    <td>{{ $order['model'] }}</td>
                                                    <td>{{ $order['net'] }}</td>
                                                    {{-- <td></td> --}}
                                                    <td>
                                                        <form action="{{ route('order.item') }}" method="GET">
                                                            @csrf
                                                            <button name="minus" type="submit" value="{{ $order['item_code'] }}" class="btn-warning btn-sm"><i class="fa fa-minus"></i></button> 
                                                            {{ $order['qty'] }} 
                                                            <button name="plus" type="submit" value="{{ $order['item_code'] }}" class="btn-primary btn-sm"><i class="fa fa-plus"></i></button>
                                                        </form>
                                                    </td>
                                                    <td>{{ $order['total'] }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <form action="{{ route('store.item') }}" method="POST">
                            @csrf
                            <div class="card-footer text-right">
                                <div class="d-flex">
                                    <button type="submit" onclick="return confirm('Are you sure you want to cancel? Data submitted will be deleted!')" name="action" value="cancel" class="btn btn-link">Cancel</button>
                                    <button type="submit" name="action" value="submit" class="btn btn-primary ml-auto">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('additionalCSS')
    <link href="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
@endpush

@push('additionalJS')
    <script src="{{ asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(function(e) {
            $('#datatable').DataTable({
                "pageLength" : 5
            });
        } );
    </script>
@endpush