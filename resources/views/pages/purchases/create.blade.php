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
                                        <input type="text" class="form-control @error('company') is-invalid @enderror" name="company" value="{{ old('company') ?? $data->company() }}" 
                                        placeholder="Name">
                                        @error('company')
                                            <code class="text-red">{{ $message }}</code>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Ref No</label>
                                        <input type="text" class="form-control @error('ref_no') is-invalid @enderror" name="ref_no" 
                                        placeholder="Text.." value="{{ old('ref_no') }}">
                                        @error('ref_no')
                                            <code class="text-red">{{ $message }}</code>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Supplier</label>
                                        <textarea class="form-control @error('supplier') is-invalid @enderror" name="supplier" rows="6" 
                                        placeholder="text here..">{{ old('supplier') }}</textarea>
                                        @error('supplier')
                                            <code class="text-red">{{ $message }}</code>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Term</label>
                                        <input type="text" class="form-control @error('term') is-invalid @enderror" name="term" 
                                        placeholder="Text.." value="{{ old('term') }}">
                                        @error('term')
                                            <code class="text-red">{{ $message }}</code>
                                        @enderror
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
                                        <input type="text" class="form-control @error('ship_to') is-invalid @enderror" name="ship_to" 
                                        placeholder="Text.." value="{{ old('ship_to') }}">
                                        @error('ship_to')
                                            <code class="text-red">{{ $message }}</code>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Location</label>
                                        <input type="text" class="form-control @error('location') is-invalid @enderror" name="location" 
                                        placeholder="Text.." value="{{ old('location') }}">
                                        @error('location')
                                            <code class="text-red">{{ $message }}</code>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Remarks:</label>
                                        <textarea class="form-control" name="remarks" rows="6" placeholder="text here..">{{ $data->remarks() }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Prepared By</label>
                                        <input type="text" class="form-control @error('preparedBy') is-invalid @enderror" name="preparedBy" 
                                        placeholder="Text.." value="{{ old('preparedBy') }}">
                                        @error('preparedBy')
                                            <code class="text-red">{{ $message }}</code>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Noted By</label>
                                        <input type="text" class="form-control @error('notedBy') is-invalid @enderror" name="notedBy" 
                                        placeholder="Text.." value="{{ old('notedBy') }}">
                                        @error('notedBy')
                                            <code class="text-red">{{ $message }}</code>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Approved By</label>
                                        <input type="text" class="form-control @error('approvedBy') is-invalid @enderror" name="approvedBy" 
                                        placeholder="Text.." value="{{ old('approvedBy') }}">
                                        @error('approvedBy')
                                            <code class="text-red">{{ $message }}</code>
                                        @enderror
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
