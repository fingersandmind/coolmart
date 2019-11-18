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
            <div class="text-right justify-content-between">
                <form action="{{ route('items.update',$item->slug) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button class="btn {{ $item->is_featured ? 'btn-info' : 'btn-outline-info' }}" name="action" value="feature"><i class="fa fa-plane"></i>{{ $item->is_featured ? 'Featured' : 'Feature me' }}</button>
                </form>
                <a href="#discount" data-toggle="modal" class="btn btn-outline-warning"><i class="fa fa-tags mr-2"></i>{{ $item->discount ? 'Update New Discount' : 'Apply Discount' }}</a>
                <a href="{{ route('items.edit',$item->slug) }}" class="btn btn-outline-primary"><i class="fa fa-pencil mr-2"></i>Update Item</a>
            </div>
        </div>

        {{-- Modal for discount --}}
        @include('pages.items.item-partials.discount-modal')
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
                                ₱
                        </div>
                        <h5>Suggested Retail Price <small>{{ $item->discount ? '('.$item->discount->name . ')' : '' }}</small></h5>
                        <div class="justify-content-between">
                            @if($item->discount)
                            <h6 class="counter" style="text-decoration:line-through;">{{ number_format($item->srp,2) }}</h6>
                            <h2 class="counter">{{ number_format($item->accuratePrice(),2) }}</h2>
                            @else
                            <h2 class="counter">{{ number_format($item->accuratePrice(),2) }}</h2>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 features">
                <div class="card feature">
                    <div class="card-body text-center">
                        <div class="fa-stack fa-lg fa-1x border bg-primary mb-3">
                                ₱
                        </div>
                        <h5>Cost</h5>
                        <h2 class="counter"> {{ number_format($item->cost,2) }}</h2>
                    </div>
                </div>
            </div>
        </div>
        @if($item->discount)
            <div class="text-right">
                <form action="{{ route('discount.destroy', $item->slug) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this?');" class="btn btn-outline-danger"><i class="fa fa-tags mr-2"></i>Remove Discount</button>
                </form>
            </div>
        @endif
        <div class="">
            <div class="card">
                <div class="row">
                    <div class="col-md-12 col-lg-6 pr-0 d-none d-lg-block">
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
                            <small><strong>Type: </strong></small><span class="tag tag-cyan">{{ $item->type->name }}</span><br><br>
                            <small><strong>Category: </strong></small><span class="tag tag-teal">{{ $item->category->name }}</span>
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
    <script>
        function cash_off()
        {
            var $label = '<label id="modal-label" for="name" class="form-control-label @error("name") is-invalid @enderror">Cash Off</label>'
            var $input = '<input id="modal-input" type="number" name="amount" class="form-control" value="{{ old("name") }}" id="cash_off" required>'
            
            $("#input-label").append($label);
            $("#input-type").append($input);
        }

        function percentage()
        {
            var $label = '<label id="modal-label" for="name" class="form-control-label @error("name") is-invalid @enderror">Percentage</label>'
            var $input = '<input id="modal-input" type="number" name="percent_off" class="form-control" value="{{ old("name") }}" id="percentage" required>'
            
            $("#input-label").append($label);
            $("#input-type").append($input);
        }

        $(document).ready(function(){
            $("#type").on('change', function(){
                var val = $("#type").val();
                $("#modal-label").remove();
                $("#modal-input").remove();
                if(val == 'cash_off')
                {
                    cash_off();
                }else if(val == 'percentage')
                {
                    percentage();
                }
            });
        });
    </script>
    @error('*')
        <script>
            $(function() {
                $( "#discount" ).modal('show');
            });
        </script>
    @enderror
@endpush