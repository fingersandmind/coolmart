@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Forms</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Form Elements</li>
            </ol>
            <button type="button" class="btn btn-outline-primary"><i class="fa fa-pencil mr-2"></i>Edit Page</button>
        </div>
        <div class="row">
            <div class="col-12">
                <form  method="post" class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form elements</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Enter Name</label>
                                    <input type="text" class="form-control" name="example-text-input" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Text</label>
                                    <input type="text" class="form-control" name="example-text-input" placeholder="Text..">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Select Variety</label>
                                    <select name="user[month]" class="form-control custom-select">
                                        <option value="">Month</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option selected="selected" value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header justify-content-between">
                                        <h2 class="card-title"><strong>Details</strong></h2>
                                        <div class="d-flex">
                                            <button id="add" type="button" class="btn btn-primary">More <i class="fa fa-plus fa-spin ml-2"></i></button>
                                            <button id="remove" type="button" class="btn btn-danger">Delete <i class="fa fa-trash fa-spin ml-2"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6 col-md-6">
                                                <h3>Name</h3>
                                                <div class="form-group"  id="details">
                                                    <div id="name_input"></div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6">
                                                <h3>Description</h3>
                                                <div class="form-group">
                                                    <div id="desc_input"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class=" justify-content-between">
                            <div class="flex">
                                <button type="submit" class="btn btn-warning ml-auto">Cancel</button>
                                <button type="submit" class="btn btn-primary ml-auto">Send data</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('additionalJS')
<script>
    $('#add').on('click', add);
    $('#remove').on('click', remove);

    var index = 0;
    var limit = 10;

    function add() {
        if(index <= limit)
        {
            index ++;
            var name_input = '<input type="text" id="name_'+index+'" class="form-control" name="name[]" placeholder="Name">';
            var name_label = '<label id="lname_'+index+'" class="form-label">Name</label>';
            var desc_input = '<input id="desc_'+index+'" type="text" class="form-control" name="description[]" placeholder="Description">';
            var desc_label = '<label id="ldesc_'+index+'" class="form-label">Description</label>';
            
            $('#name_input').append(name_label);
            $('#name_input').append(name_input);
            $('#desc_input').append(desc_label);
            $('#desc_input').append(desc_input);
        }
    }

    function remove() {
        var last_index = index;

        if(last_index > 0) {
            $('#name_' + last_index).remove();
            $('#lname_' + last_index).remove();
            $('#desc_' + last_index).remove();
            $('#ldesc_' + last_index).remove();
            index --;
        }
    }
</script>
@endpush