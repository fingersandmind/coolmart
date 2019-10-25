@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Categories Table</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                {{-- <li class="breadcrumb-item active" aria-current="page">Data Tables</li> --}}
            </ol>
            {{-- <a href="{{ route('categories.create') }}" class="btn btn-outline-primary"><i class="fa fa-plus mr-2"></i>Add Category</a href="{{ route('categories.create') }}"> --}}
            
        </div>
        <div class="row">
            <div class="col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Unit Categories</div>
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#createCategory">
                            <i class="fa fa-plus mr-2"></i>Add Category
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="wd-15p">ID</th>
                                        <th class="wd-15p">Name</th>
                                        <th class="wd-15p">Slug</th>
                                        <th class="wd-20p">Description</th>
                                        <th class="wd-20p">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>{{ ucfirst($category->name) }}</td>
                                            <td>{{ $category->slug }}</td>
                                            <td>{{ $category->description }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown">
                                                        <i class="fa fa-cogs mr-2"></i>Actions
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" >View</a>
                                                        <a class="dropdown-item" href="{{ route('categories.edit',$category->slug) }}"">Edit</a>
                                                        <form action="{{ route('categories.destroy', $category->slug) }}" method="POST">
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
            <!-- section-wrapper -->

            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <h3 class="card-title">Unit Types</h3>
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#addType">
                            <i class="fa fa-plus mr-2"></i>Add Type
                        </button>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($types as $type)
                                <li class="list-group-item justify-content-between d-flex align-items-center">
                                    <button class="btn btn-info">{{ $type->name }}</button>
                                    <span class="badgetext badge badge-primary badge-pill">14</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('pages.categories.modals.create');
@endsection

@push('additionalCSS')
    <link href="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
@endpush

@push('additionalJS')
    @include('pages.page-partials.datatables')
        @error('name')
            <script>
                $(function() {
                    $( "#createCategory" ).modal('show');
                });
            </script>
        @enderror
@endpush