@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Brand</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('brands.index') }}">Brands</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ ucfirst($brand->name) }}</li>
            </ol>
        </div>
        <div class="row row-cards">
            <div class="col-md-12">
                <div class="card"  style="background-image: url(/{{ $brand->logo }});    background-position: center; background-size:cover;">
                    <div class="card-body text-center">
                        <h1 class="mb-3 text-white heading-success"><strong>{{ ucfirst($brand->name) }}</strong></h1>
                        <p class="mb-4 text-white">Air Conditioning</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title"><img src="/{{ $brand->logo }}" alt=""></div>
                            </div>
                            <div class="card-body">
                                <small>Description:</small> <br>
                                <span>{{ $brand->description }}</span>
                                <hr>
                                <form action="{{ route('brands.show',$brand->slug) }}" method="GET">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label">Type</label>
                                        <select name="type" class="form-control custom-select">
                                            <option value="0" disabled selected>--Select--</option>
                                            @foreach ($types as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Category</label>
                                        <select name="category" class="form-control custom-select">
                                            <option value="0" disabled selected>--Select--</option>
                                            @foreach ($categories as $key => $value)
                                                <option value="{{ $key }}">{{ strtolower($value) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button class="btn btn-info" style="float:right">Filter</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="input-group mb-5">
                    <h1>Brand unit models</h1>
                </div>
                <div class="row">
                    @if($brand->items)
                        @foreach ($brand->items as $item)
                            <div class="col-lg-4">
                                <div class="card item-card">
                                    <div class="card-body pb-0">
                                        <div class="text-center">
                                            @if($item->image)
                                                <img src="/{{ $item->image->thumbnail }}" alt="img" class="img-fluid">
                                            @else
                                                <img src="/assets/images/no-image.jpg" alt="img" class="img-fluid">
                                            @endif
                                            <span>{{ ucfirst($item->name) }}</span>
                                        </div>
                                        <div class="card-body cardbody">
                                            <div class="cardtitle">
                                                <a><span>SRP:</span></a>
                                                <a><span>Cost:</span></a>
                                                <a>Quantity:</a>
                                            </div>
                                            <div class="cardprice">
                                                {{-- <span class="type--strikethrough">$999</span> --}}
                                                <span>${{ $item->srp }}</span>
                                                <span>${{ $item->cost }}</span>
                                                <span><small>{{ $item->qty }}</small></span>
                                            </div>
                                        </div>
                                        <a class="btn btn-link" href="{{ route('items.show', $item->slug) }}">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection