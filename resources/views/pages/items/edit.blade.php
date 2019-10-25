@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Forms</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('brands.index') }}">Model</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit item</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="{{ route('items.update', $item->slug) }}" method="POST" class="card" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h3 class="card-title">Edit {{ ucfirst($item->name) }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="row">
                                    <div class="col-md-5 col-sm-5 col-5 col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Brand</label>
                                            <select name="brand" class="form-control btn btn-primary">
                                                @foreach ($brands as $key => $value)
                                                    <option value="{{ $key }}"
                                                    @if($key == $item->brand->id)
                                                    selected
                                                    @endif
                                                    >{{ ucfirst($value) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5 col-5 col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Type</label>
                                            <select name="type" class="form-control btn btn-info">
                                                @foreach ($types as $key => $value)
                                                    <option value="{{ $key }}"
                                                    @if($key == $item->type->id)
                                                    selected
                                                    @endif
                                                    >{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 col-sm-5 col-5 col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Category</label>
                                            <select name="category" class="form-control btn btn-warning">
                                                @foreach ($categories as $key => $value)
                                                    <option value="{{ $key }}"
                                                    @if($key == $item->category->id)
                                                    selected
                                                    @endif
                                                    >{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Enter Item Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" name="example-text-input" 
                                    placeholder="Name" value="{{ old('name') ?? $item->name }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Slug</label>
                                    <input type="text" name="slug" class="form-control" name="example-text-input" 
                                    placeholder="name" value="{{ $item->slug }}" readonly disabled>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="6" 
                                    placeholder="text here..">{{ old('description') ?? $item->description }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-lg-6 col-6">
                                        <div class="form-group">
                                            <label class="form-label">Retail Price &#8369;</label>
                                            <input type="number" class="form-control" min="0.00" max="100000.00" 
                                            step="0.01" name="srp" value="{{ old('srp') ?? $item->srp }}" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-lg-6 col-6">
                                        <div class="form-group">
                                            <label class="form-label">Cost &#8369;</label>
                                            <input type="number" class="form-control" min="0.00" max="100000.00" 
                                            step="0.01" name="cost" value="{{ old('cost') ?? $item->cost }}" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-lg-4 col-4">
                                        <label class="form-label">Quantity</label>
                                        <input type="number" class="form-control" min="0.00" max="100.00" 
                                        step="0.01" name="qty" value="{{ old('qty') ?? $item->qty }}" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-6">
                                <label class="form-label">Drop a valid Image here</label>
                                <div class="col-lg-12 col-sm-12">
                                    <input type="file" name="image" class="dropify @error('image') is-invalid @enderror" data-height="180"/>
                                    @error('image')
                                        {{-- <span class="invalid-feedback" role="alert"> --}}
                                            <code style="color:red">{{ $message }}</code style="color:red">
                                        {{-- </span> --}}
                                    @enderror
                                    <div class="card item-card">
                                        <div class="card-body">
                                            <div class="border p-0">
                                                <div class="row">
                                                    <div class="col-md-6 pr-0">
                                                        <div class="text-center bg-gray">
                                                            @if($item->image)
                                                                <img src="/{{ $item->image->thumbnail }}" alt="img" class="img-fluid">
                                                            @else
                                                                <img src="/assets/images/no-image.jpg" alt="img" class="img-fluid">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 pl-0">
                                                        <div class="card-body cardbody ">
                                                            <div class="cardtitle">
                                                                <a class="card-title">{{ ucfirst($item->name) }}</a>
                                                                <span>{{ $item->description }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div class="flex">
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

@push('additionalCSS')
    <link href="{{ asset('assets/plugins/fileuploads/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('additionalJS')
    @include('pages.page-partials.dropify')
@endpush