@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Accordion</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Terms</li>
            </ol>
            <a href="{{ route('terms.create') }}" class="btn btn-outline-primary"><i class="fa fa-plus fa-spin mr-2"></i>Add new Term</a>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Terms</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="wd-10p">Name</th>
                                        <th class="wd-10p">Content</th>
                                        <th class="wd-20p">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($terms as $term)
                                        <tr>
                                            <td>{{ str_limit($term->name, $limit=20, $end='..') }}</td>
                                            <td>{{ str_limit($term->content, $limit=130, $end='..') }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown">
                                                        <i class="fa fa-spin fa-cogs mr-2"></i>Actions
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('terms.edit', $term->id) }}">Edit</a>
                                                        <form action="{{ route('terms.destroy',$term->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" onclick="return confirm('Are you you want to delete this item?');" class="dropdown-item">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- table-wrapper -->
                </div>
            </div>
            <hr>
            <div>
                <h1>To be displayed as</h1>
            </div>
            <hr>
            <div class="row ">
                @foreach ($terms as $term)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4><b>{{ $term->name }}</b></h4>
                            <p>{{ $term->content }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection