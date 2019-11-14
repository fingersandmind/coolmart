@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3 class="card-title">Purchase Order #{{ $purchase->PurchaseCode }}</h3>
                <button type="button" class="btn btn-warning" onClick="javascript:window.print();"><i class="fa fa-print"></i> Print Invoice</button>
            </div>

            <div class="card-body">
                <div class="row ">
                    <div class="col-12">
                        <div class="text-center">
                            <h1>
                                <span class="avatar avatar-lg brround" style="background-image: url({{ asset('assets/allcoollogo.jpg') }})"></span>
                                <strong>{{ $purchase->company() }}</strong>
                            </h1>
                            <small><strong>Air-Conditioning Services</strong></small><br>
                            <span><small>{{ $purchase->address() }}</small></span><br>
                            <span><small>{{ $purchase->info() }}</small></span><br><br>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="text-center">
                            <h4><strong>PURCHASE ORDER</strong></h4>
                        </div>
                    </div>
                    <div class="col-sm-6 ">
                        <strong>PO No: </strong>{{ $purchase->PurchaseCode }}
                        <address>
                            <strong>Dated:</strong> {{ $purchase->created_at->toFormattedDateString() }} <br>
                            <strong>Supplier:</strong> {{ $purchase->supplier }}<br>
                            <strong>Ship to:</strong> {{ $purchase->ship_to }}<br>
                            <strong>Location:</strong> {{ $purchase->location }}<br>
                        </address>
                    </div>
                    <div class="col-sm-6 text-right">
                        <address>
                            <strong>Delivery Date:</strong> {{ $purchase->deliveryDate()->toFormattedDateString() }} <br>
                            <strong>PO Valid Until:</strong><strong> {{ $purchase->poValidDate()->toFormattedDateString() }}</strong><br>
                            <strong>PO Amount: </strong>₱{{ number_format($purchase->totalPOAmount(),2) }}
                        </address>
                    </div>
                </div>
                <div class="table-responsive push">
                    <table class="table table-bordered table-hover">
                        <tr class=" ">
                            <th class="text-center" style="width: 10%">Item Code</th>
                            <th>Description</th>
                            <th class="text-center" style="width: 1%">Qty</th>
                            <th class="text-right" style="width: 1%">Cost</th>
                            <th class="text-right" style="width: 1%">Amount</th>
                        </tr>
                        @if($purchase->orders)
                            @foreach($purchase->orders as $order)
                                <tr>
                                    <td class="text-center">{{ $order->item->ListItemCode }}</td>
                                    <td>
                                       <strong> <p class="font-w600 mb-1">{{ $order->item->model }} - {{ $order->item->brand->name }}</p></strong>
                                        <div>{{ $order->item->description }}</div>
                                    </td>
                                    <td class="text-center">{{ $order->qty }}</td>
                                    <td class="text-right">₱{{ number_format($order->item->net,2) }}</td>
                                    <td class="text-right">₱{{ number_format($order->totalAmount(),2) }}</td>
                                </tr>
                            @endforeach
                        @endif
                        <tr>
                            <td colspan="2" class="font-w600 text-right"><strong>Total Items :</strong></td>
                            <td class="text-right"><strong>{{ $purchase->orders()->sum('qty') }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="font-w600 text-right">Subtotal</td>
                            <td class="text-right">₱{{ number_format($purchase->totalNetAmount(),2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="font-w600 text-right">Vat Rate</td>
                            <td class="text-right">12%</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="font-w600 text-right">Vat Due</td>
                            <td class="text-right">₱{{ number_format($purchase->vatTotalDue(),2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="font-weight-bold text-uppercase text-right">Total Due</td>
                            <td class="font-weight-bold text-right">₱{{ number_format($purchase->totalPOAmount(),2) }}</td>
                        </tr>
                    </table>
                </div>
                <div class=" text-dark">
                    <strong>Remarks: </strong><small>{{ $purchase->remarks }}</small>
                </div>
            </div>
            <br>
            <br>
            <br>
            <br>
            <div class="card-footer">
                <div class="row">
                    <div class="col-4 text-center signature"><br><br>
                        <div class="h5">{{ $purchase->preparedBy }}</div> <br>
                        <small>Prepared By:</small>
                    </div>
                    <div class="col-4 text-center signature"><br><br>
                        <div class="h5">{{ $purchase->approvedBy }}</div> <br>
                        <small>Approved By:</small>
                    </div>
                    <div class="col-4 text-center signature"><br><br>
                        <div class="h5">{{ $purchase->notedBy }}</div> <br>
                        <small>Noted By:</small>
                    </div>
                </div>
                <br>
                <br>
                <p class="text-center">Thank you very much for doing business with us. We look forward to working with you again!</p>
            </div>
        </div>
    </div>
</div>
@endsection
@push('additionalCSS')
    <style>
        div.signature{
            width: 33%;
            padding: 10px;
            border: 1px solid black;
            margin: 0;
        }
    </style>
@endpush