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
                        {{-- @if($item->images->count() > 0)
                            @foreach($item->images->take(1) as $image)
                                <img src="/{{ $image->image }}" alt="img" class="br-tl-7">
                            @endforeach
                        @else
                            <img src="/assets/images/no-image.jpg" alt="img" class="br-tl-7">
                        @endif --}}
                        <div id="carousel-controls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @if($item->images->count() > 0)
                                    @foreach($item->images as $image)
                                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                            <img src="/{{ $image->image }}" alt="img" class="d-block w-100" data-holder-rendered="true">
                                        </div>
                                    @endforeach
                                @else   
                                    <img src="/assets/images/no-image.jpg" alt="img" class="br-tl-7">
                                @endif
                            </div>
                            <a class="carousel-control-prev" href="#carousel-controls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carousel-controls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6  pl-0 ">
                        <div class="card-body p-8 about-con pabout">
                            <h2 class="mb-4 font-weight-semibold">{{ ucfirst($item->name) }}</h2>
                            <h4 class="leading-normal">majority have suffered alteration in some form, by injected humour</h4>
                            {{-- <p class="leading-normal">{{ ucfirst($item->description) }}</p> --}}
                            <small><strong>Types: </strong></small><span class="tag tag-cyan">{{ $item->type->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Details and Specifications</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap table-primary" >
                            <thead  class="bg-primary text-white">
                                <tr >
                                    <th class="text-white">Name</th>
                                    <th class="text-white">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($item->details)
                                    @foreach($item->details as $detail)
                                        <tr>
                                            <td>{{ $detail->name }}</td>
                                            <td>{{ $detail->description }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- table-responsive -->
                </div>
            </div>
        </div>
        <div>
            <h1>Other unit items of the same brand</h1>
        </div>
        <div class="row">
            @foreach($item->brand->items->take(4) as $unit)
                @if($item->slug === $unit->slug)
                @else
                <div class="col-md-6 cols-ms-12 col-lg-4">
                    <div class="card text-center">
                        @if($unit->images->count() > 0)
                            @if($unit->images)
                                @foreach ($unit->images->take(1) as $image)
                                    <img src="/{{ $image->thumbnail }}" alt="img" class="br-tl-7 br-tr-7" >
                                @endforeach
                            @endif
                        @else
                        <img src="/assets/images/no-image.jpg" alt="img" class="br-tl-7 br-tr-7" >
                        @endif
                        <div class="card-body">
                            <h3 class="mb-3">{{ $unit->name }}</h3>
                            <p>I must explain to you how all this mistaken idea of denouncing pleasure and you a complete account of the system</p>
                            <a href="{{ route('items.show',$unit->slug) }}" class="btn btn-primary">View More</a>
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