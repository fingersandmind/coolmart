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
                                <label class="form-label">Drop a valid image here</label>
                                <div class="col-lg-12 col-sm-12">
                                    <input type="file" name="images[]" class="dropify @error('images') is-invalid @enderror" 
                                    data-height="180" multiple/>
                                    @error('images')
                                        {{-- <span class="invalid-feedback" role="alert"> --}}
                                            <code style="color:red">{{ $message }}</code style="color:red">
                                        {{-- </span> --}}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea class="description @error('description') is-invalid @enderror" name="description" rows="6" 
                                placeholder="text here..">{{ old('description') ?? $item->description }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card item-card">
                                <div class="card-body">
                                    <div class="border p-0">
                                        <div class="row">
                                            @if($item->images)
                                                @foreach($item->images as $image)
                                                <div class="col-3">
                                                    <div class="text-center bg-gray">
                                                        <img src="/{{ $image->thumbnail }}" alt="img" class="img-fluid">
                                                    </div>
                                                </div>
                                                @endforeach
                                            @else
                                                <img src="/assets/images/no-image.jpg" alt="img" class="img-fluid">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header justify-content-between">
                                    <h2 class="card-title"><strong>Update Details and Specifications</strong></h2>
                                    <div class="d-flex">
                                        <button id="add" type="button" class="btn btn-primary">More <i class="fa fa-plus fa-spin ml-2"></i></button>
                                        <button id="remove" type="button" class="btn btn-danger">Delete <i class="fa fa-trash fa-spin ml-2"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4 col-md-4">
                                            <h4>Name</h4>
                                            <div class="form-group"  id="details">
                                                @php
                                                    $index_name = 1;
                                                    $index_desc = 1;
                                                @endphp
                                                @if($item->details)
                                                    @foreach($item->details as $detail)
                                                        {{-- <label id="lname_{{ $index_name }}" class="form-label">Name</label> --}}
                                                        <input type="text" id="name_{{ $index_name }}" value="{{ $detail->name }}" class="form-control" name="names[]" minlength="2" maxlength="50" placeholder="Name">
                                                        @php
                                                            $index_name++;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                                <div id="name_input"></div>
                                            </div>
                                        </div>
                                        <div class="col-8 col-md-8">
                                            <h4>Description</h4>
                                            <div class="form-group">
                                                @if($item->details)
                                                    @foreach($item->details as $detail)
                                                        {{-- <label id="ldesc_{{ $index_desc }}" class="form-label">Description</label> --}}
                                                        <div class="justify-content-between d-flex">
                                                            <input id="desc_{{ $index_desc }}" value="{{ $detail->description }}" type="text" class="form-control" name="descriptions[]" minlength="2" maxlength="100" placeholder="Description">
                                                            <button id="removeCol" onclick="javascript:removeColumn({{ $index_desc }});"type="button" class="btn btn-danger btn_{{ $index_desc }}"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                        @php
                                                            $index_desc++;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                                <div id="desc_input"></div>
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
    <link href="{{ asset('assets/plugins/wysiwyag/richtext.css') }}" rel="stylesheet" />
@endpush

@push('additionalJS')
    <script src="{{ asset('assets/plugins/wysiwyag/jquery.richtext.js') }}"></script>
    @include('pages.page-partials.dropify')
    <script>
        $(function(e) {
            $('.description').richText();
        });
    </script>
    @include('pages.items.item-partials.editDetailsScripts')
@endpush