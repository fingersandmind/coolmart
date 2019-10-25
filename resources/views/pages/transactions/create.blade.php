@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Transaction</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Transactions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Form</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">For transaction Example</div>
                    </div>
                    <div class="card-body p-6">
                        <div class="wizard-container">
                            <div class="wizard-card m-0" data-color="red" id="wizardProfile">
                                <form action="{{ route('transactions.store') }}" method="POST">
                                    @csrf
                                    <div class="wizard-navigation">
                                        <ul>
                                            <li><a href="#about" data-toggle="tab">Customer's Info</a></li>
                                            <li><a href="#units" data-toggle="tab">Units</a></li>
                                            <li><a href="#address" data-toggle="tab">Address</a></li>
                                        </ul>
                                    </div>

                                    <div class="tab-content">
                                        <div class="tab-pane" id="about">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">First Name <small>(required)</small></label>
                                                            <input name="firstname" type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Last Name <small>(required)</small></label>
                                                            <input name="lastname" type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Contact Number<small>(required)</small></label>
                                                            <input type="number" class="form-control" name="contact"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="units">
                                            <h4 class="info-text">What Airconditioning Brand</h4>
                                            <div class="row">

                                                @if(!empty($brands))
                                                    @foreach ($brands as $brand)
                                                        <div class="col-sm-2">
                                                            <div class="choice" data-toggle="wizard-radio">
                                                                <label>
                                                                    <input type="radio" id="brand_name" name="brand" value="{{ $brand->name }}" required>
                                                                    <span class="avatar avatar-xxl" style="background-image: url(/{{ $brand->logo }})"></span>
                                                                        {{-- <img src="/assets/images/no_image-100x100.jpg" alt="img" class="img-fluid"> --}}
                                                                </label>
                                                                <h6>{{ ucfirst($brand->name) }}</h6>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif

                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12 pb-4 pt-4">
                                                    <h3 id="display_brand_name"></h3>
                                                </div>
                                                @if(!empty($brands))
                                                    @foreach ($brands as $brand)
                                                        <div class="card units {{ $brand->name }}">
                                                            @if(!empty($brand->models))
                                                                @foreach ($brand->models as $model)
                                                                    <div class="card-body justify-content-between">
                                                                        <div class="row">
                                                                            <div class="col-3">
                                                                                <div class="custom-control custom-checkbox custom-control-inline">
                                                                                    <label>
                                                                                        <input type="checkbox" name="model[{{ $brand->id }}][]" id="service" value="{{ $model->id }}" required>
                                                                                        @if($model->image)
                                                                                            <span class="avatar avatar-xxl" style="background-image: url(/{{ $model->image->image }})"></span>
                                                                                        @else
                                                                                            <span class="avatar avatar-xxl" style="background-image: url( /assets/images/no_image-100x100.jpg }})"></span>
                                                                                        @endif
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <h1>{{ ucfirst($model->name) }}</h1>
                                                                                <p>{{ ucfirst($model->description) }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>

                                        </div>



                                        <div class="tab-pane" id="address">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4 class="info-text"> Are you living in a nice area? </h4>
                                                </div>
                                                <div class="col-sm-8 ">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Street Name</label>
                                                        <input name="stresst_name" type="text" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Street Number</label>
                                                        <input name="street_number" type="text" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 ">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">City</label>
                                                        <input name="city" type="text" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Country</label>
                                                        <select name="country" class="form-control" required>
                                                            <option disabled="" value="..." selected="">select</option>
                                                            <option value="Afghanistan"> Afghanistan </option>
                                                            <option value="Albania"> Albania </option>
                                                            <option value="Algeria"> Algeria </option>
                                                            <option value="American Samoa"> American Samoa </option>
                                                            <option value="Andorra"> Andorra </option>
                                                            <option value="Angola"> Angola </option>
                                                            <option value="Anguilla"> Anguilla </option>
                                                            <option value="Antarctica"> Antarctica </option>
                                                            <option value="...">...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-footer">
                                        <div class="pull-right">
                                            <input type='button' class='btn btn-next btn-fill btn-primary btn-wd m-0' name='next' value='Next' />
                                            <input type='submit' class='btn btn-finish btn-fill btn-success btn-wd m-0' name='finish' value='Finish' />
                                        </div>

                                        <div class="pull-left">
                                            <input type='button' class='btn btn-previous btn-fill btn-default btn-wd m-0' name='previous' value='Previous' />
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- wizard container -->
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection
@push('additionalCSS')
    <link href="{{ asset('assets/plugins/forn-wizard/css/material-bootstrap-wizard.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/forn-wizard/css/demo.css') }}" rel="stylesheet" />
    <style>
        [type=radio] { 
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
    
        /* IMAGE STYLES */
        [type=radio] + span {
            cursor: pointer;
        }
    
        /* CHECKED STYLES */
        [type=radio]:checked + span {
            outline: 2px solid #f00;
        }
    </style>
    <style>
        [type=checkbox] { 
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
    
        /* IMAGE STYLES */
        [type=checkbox] + span {
            cursor: pointer;
        }
    
        /* CHECKED STYLES */
        [type=checkbox]:checked + span {
            outline: 2px solid #f00;
        }
    </style>
@endpush
@push('additionalJS')
    <script src="{{ asset('assets/plugins/forn-wizard/js/material-bootstrap-wizard.js') }}"></script>
    <script src="{{ asset('assets/plugins/forn-wizard/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/forn-wizard/js/jquery.bootstrap.js') }}"></script>
    <script>
        $('.units').hide();
        // find elements
        var choiceObj = $(".choice");
        // handle click and add class
        choiceObj.on("click", function(){
            radioBtnValue = $(this).find("input[id='brand_name']").val();
            $("#display_brand_name").html(radioBtnValue);
            var targetDiv = $('.'+radioBtnValue);
            $(".units").not(targetDiv).hide();
            $(targetDiv).show();
        })
    </script>
@endpush