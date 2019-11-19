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
                                        <select name="type[]" class="form-control custom-select">
                                            @foreach ($types as $key => $value)
                                                    <option {{ $key == array_first(request()->input('type')) ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Category</label>
                                        <select name="category[]" class="form-control custom-select">
                                            @foreach ($categories as $key => $value)
                                                <option {{ $key == array_first(request()->input('category')) ? 'selected' : '' }} value="{{ $key }}">{{ strtolower($value) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button class="btn btn-warning btn-small" type="submit" name="action" value="cancel" >Clear All</button>
                                    <button type="submit" class="btn btn-info btn-small" style="float:right">Filter</button>
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
                    @if($items)
                        @foreach ($items as $item)
                            <div class="col-lg-4">
                                <div class="card item-card">
                                    <div class="card-body pb-0">
                                        <div class="text-center">
                                            @if($item->images->count() > 0)
                                                @foreach($item->images->take(1) as $itemImage)
                                                    <img src="/{{ $itemImage->thumbnail }}" alt="img" class="img-fluid">
                                                @endforeach
                                            @else
                                                <img src="/assets/images/no-image.jpg" alt="img" class="img-fluid">
                                            @endif
                                            <span>{{ ucfirst($item->name) }}</span>
                                        </div>
                                        <div class="card-body cardbody">
                                            <div class="cardtitle">
                                                @if($item->discount)
                                                <br>
                                                @endif
                                                <a><span>SRP:</span></a>
                                                <a><span>Cost:</span></a>
                                                <a>Quantity:</a>
                                            </div>
                                            <div class="cardprice">
                                                @if($item->discount)
                                                <span class="type--strikethrough"><small>₱{{ number_format($item->srp) }}</small></span>
                                                @endif
                                                <span>₱{{ number_format($item->accuratePrice()) }}</span>
                                                <span>₱{{ number_format($item->cost) }}</span>
                                                <span>{{ $item->qty }}</span>
                                            </div>
                                        </div>
                                        <a class="btn btn-link" href="{{ route('items.show', $item->slug) }}">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>
@endsection