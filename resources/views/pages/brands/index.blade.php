@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Brands Table</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                {{-- <li class="breadcrumb-item active" aria-current="page">Data Tables</li> --}}
            </ol>
            <a href="{{ route('brands.create') }}" class="btn btn-outline-primary"><i class="fa fa-plus mr-2"></i>Add Brand</a href="{{ route('brands.create') }}">
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Tables</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="wd-15p">ID</th>
                                    <th class="wd-15p">Name</th>
                                    <th class="wd-15p">Slug</th>
                                    <th class="wd-20p">Logo</th>
                                    <th class="wd-20p">Description</th>
                                    <th class="wd-5p">Total Units</th>
                                    <th class="wd-20p">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($brands as $brand)
                                    <tr>
                                        <td>{{ $brand->id }}</td>
                                        <td>{{ ucfirst($brand->name) }}</td>
                                        <td>{{ $brand->slug }}</td>
                                        <td>
                                            <span class="avatar avatar-md" style="background-image: url({{ $brand->logo }})"></span>
                                        </td>
                                        <td>{{ $brand->description }}</td>
                                        <td>{{ $brand->items->count() }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown">
                                                    <i class="fa fa-spin fa-cogs mr-2"></i>Actions
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('brands.show', $brand->slug) }}">View</a>
                                                    <a class="dropdown-item" href="{{ route('brands.edit', $brand->slug) }}">Edit</a>
                                                    <form action="{{ route('brands.destroy', $brand->slug) }}" method="POST">
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
        </div>
    </div>
</div>
@endsection

@push('additionalCSS')
    <link href="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
@endpush

@push('additionalJS')
    @include('pages.page-partials.datatables')
@endpush