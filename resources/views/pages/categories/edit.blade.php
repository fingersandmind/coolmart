@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Forms</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('brands.index') }}">Brands</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit {{ ucfirst($category->name) }}</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="{{ route('categories.update',$category->slug) }}" method="POST" class="card" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h3 class="card-title">{{ ucfirst($category->name) }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Edit Category Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" name="example-text-input" 
                                    placeholder="Name" value="{{ old('name') ?? $category->name }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Slug</label>
                                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" name="example-text-input" 
                                    placeholder="name" readonly disabled value="{{ $category->slug }}">
                                    @error('slug')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Edit Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="6" 
                                    placeholder="text here..">{{ old('description') ?? $category->description }}</textarea>
                                </div>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <div class="card card-blog-overlay">
                                    <div class="card-header z-index-10">
                                        <h3 class="card-title text-white">Airconditioning Category</h3>
                                        <div class="card-options">
                                            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up text-white"></i></a>
                                            <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x text-white"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body  text-white">
                                        Having to choose a new air conditioning system for your home 
                                        can be a stressful and confusing time. With all the different 
                                        types of air conditioners on the market, the possibilities may 
                                        seem overwhelming. Depending on your situation, you might even 
                                        be under a time constraint and have to choose a new system soon.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div class="flex">
                            <a href="{{ route('brands.index') }}" class="btn btn-link">Cancel</a>
                            <button type="submit" class="btn btn-primary ml-auto">Send data</button>
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