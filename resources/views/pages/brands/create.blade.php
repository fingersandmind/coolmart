@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Forms</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('brands.index') }}">Brands</a></li>
                <li class="breadcrumb-item active" aria-current="page">New brand</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="{{ route('brands.store') }}" method="POST" class="card" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">New Brand</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Enter Brand Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" name="example-text-input" 
                                    placeholder="Name" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Slug</label>
                                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" name="example-text-input" 
                                    placeholder="name" readonly disabled>
                                    @error('slug')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="6" 
                                    placeholder="text here..">{{ old('description') }}</textarea>
                                </div>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 col-lg-6 col-6">
                                <label class="form-label">Drop a valid Logo here</label>
                                <div class="col-lg-12 col-sm-12">
                                    <input type="file" name="logo" class="dropify @error('logo') is-invalid @enderror" data-height="180"/>
                                    @error('logo')
                                        {{-- <span class="invalid-feedback" role="alert"> --}}
                                            <code style="color:red">{{ $message }}</code style="color:red">
                                        {{-- </span> --}}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div class="flex">
                            <a href="javascript:void(0)" class="btn btn-link">Cancel</a>
                            <button type="submit" name="action" value="save" class="btn btn-primary ml-auto">Submit</button>
                            <button type="submit" name="action" value="continue" class="btn btn-info ml-auto">Save & Continue</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('additionalCSS')
    <link href="{{ asset('assets/plugins/fileuploads/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('additionalJS')
    @include('pages.page-partials.dropify')
@endpush