@extends('layouts.master')

@section('content')

<div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">Forms</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Purchase Order</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('orders.store') }}" method="POST" class="card">
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title">Purchase Order</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Company Name</label>
                                        <input type="text" class="form-control" name="company" value="{{ $data->company() }}" placeholder="Name">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Ref No</label>
                                        <input type="text" class="form-control" name="ref_no" placeholder="Text..">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Supplier</label>
                                        <textarea class="form-control" name="supplier" rows="6" placeholder="text here.."></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Term</label>
                                        <input type="text" class="form-control" name="term" placeholder="Text..">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Delivery Date</label>
                                        <input type="text" readonly value="{{ $data->deliveryDate()->toFormattedDateString() }}" class="form-control" placeholder="Text..">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">P.O Valid Until</label>
                                        <input type="text" readonly class="form-control" value="{{ $data->poValidDate()->toFormattedDateString() }}" placeholder="Text..">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Ship To</label>
                                        <input type="text" class="form-control" name="ship_to" placeholder="Text..">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Location</label>
                                        <input type="text" class="form-control" name="location" placeholder="Text..">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Remarks:</label>
                                        <textarea class="form-control" name="remarks" rows="6" placeholder="text here..">{{ $data->remarks() }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Prepared By</label>
                                        <input type="text" class="form-control" name="preparedBy" placeholder="Text..">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Noted By</label>
                                        <input type="text" class="form-control" name="notedBy" placeholder="Text..">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Approved By</label>
                                        <input type="text" class="form-control" name="approvedBy" placeholder="Text..">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <div class="d-flex">
                                <a href="javascript:void(0)" class="btn btn-link">Cancel</a>
                                <button type="submit" class="btn btn-primary ml-auto">Send data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
