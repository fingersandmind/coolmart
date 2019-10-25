@extends('layouts.master')

@section('content')
<div class="about-img">
    <div class="card-body p-8 align-items-center text-center">
        <a href="{{ route('brands.show',$item->brand->slug) }}"><h2 class="text-white display-5 font-weight-semibold">{{ ucfirst($item->brand->name) }}</h2></a>
        <p class="text-white">{{ ucfirst($item->brand->description) }}</p>
    </div>
</div>
<div class="my-3 my-md-5">

    <div class="container">
        <div class="page-header">
            <h4 class="page-title">About</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('items.index') }}">items</a></li>
                <li class="breadcrumb-item active" aria-current="page">View</li>
            </ol>
            <a href="{{ route('items.edit',$item->slug) }}" class="btn btn-outline-primary"><i class="fa fa-pencil mr-2"></i>Edit</a>
        </div>
        <div class="row ">
            <div class="col-md-4 features">
                <div class="card feature">
                    <div class="card-body text-center">
                        <div class="fa-stack fa-lg fa-1x border bg-primary mb-3">
                            <i class="fa fa-user fa-stack-1x text-white"></i>
                        </div>
                        <h5>Quantity</h5>
                        <h2 class="counter">{{ $item->qty }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 features">
                <div class="card feature">
                    <div class="card-body text-center">
                        <div class="fa-stack fa-lg fa-1x border bg-primary mb-3">
                            <i class="fa fa-usd fa-stack-1x text-white"></i>
                        </div>
                        <h5>Suggested Retail Price</h5>
                        <h2 class="counter"> {{ number_format($item->srp) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 features">
                <div class="card feature">
                    <div class="card-body text-center">
                        <div class="fa-stack fa-lg fa-1x border bg-primary mb-3">
                            <i class="fa fa-usd fa-stack-1x text-white"></i>
                        </div>
                        <h5>Cost</h5>
                        <h2 class="counter"> {{ number_format($item->cost) }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="card">
                <div class="row">
                    <div class="col-md-12 col-lg-6 pr-0 d-none d-lg-block">
                        @if($item->image)
                            <img src="/{{ $item->image->image }}" alt="img" class="br-tl-7">
                        @else
                            <img src="/assets/images/no-image.jpg" alt="img" class="br-tl-7">
                        @endif
                    </div>
                    <div class="col-md-12 col-lg-6  pl-0 ">
                        <div class="card-body p-8 about-con pabout">
                            <h2 class="mb-4 font-weight-semibold">{{ ucfirst($item->name) }}</h2>
                            <h4 class="leading-normal">majority have suffered alteration in some form, by injected humour</h4>
                            <p class="leading-normal">{{ ucfirst($item->description) }}</p>
                            <small><strong>Types: </strong></small><span class="tag tag-cyan">{{ $item->type->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h1>Other unit items of the same brand</h1>
        </div>
        <div class="row">
            @foreach($item->brand->items->take(4) as $item)
                @if($item->slug === $item->slug)
                @else
                <div class="col-md-6 cols-ms-12 col-lg-4">
                    <div class="card text-center">
                        @if($item->image)
                        <img src="/{{ $item->image->thumbnail }}" alt="img" class="br-tl-7 br-tr-7" >
                        @else
                        <img src="/assets/images/no-image.jpg" alt="img" class="br-tl-7 br-tr-7" >
                        @endif
                        <div class="card-body">
                            <h3 class="mb-3">{{ $item->name }}</h3>
                            <p>I must explain to you how all this mistaken idea of denouncing pleasure and you a complete account of the system</p>
                            <a href="{{ route('items.show',$item->slug) }}" class="btn btn-primary">View More</a>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('additionalJS')
    <script src="{{ asset('assets/plugins/counters/counterup.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/counters/waypoints.min.js') }}"></script>
    <script>
        $('.counter').countUp();
    </script>
@endpush