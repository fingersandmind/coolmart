@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">List Table</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Lists</a></li>
            </ol>
            {{-- <a href="{{ route('items.create') }}" class="btn btn-outline-primary"><i class="fa fa-plus mr-2"></i>Add Item</a> --}}
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Suppliers List</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="wd-10p">Item Code</th>
                                    <th class="wd-10p">Brand</th>
                                    <th class="wd-10p">Model</th>
                                    <th class="wd-10p">Description</th>
                                    <th class="wd-10p">Type</th>
                                    <th class="wd-10p">Net Cost</th>
                                    <th class="wd-20p">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lists as $list)
                                    <tr>
                                        <td>{{ $list->ListItemCode }}</td>
                                        <td>{{ ucfirst($list->brand->name) }}</td>
                                        <td>{{ $list->model }}</td>
                                        <td>{{ $list->description }}</td>
                                        <td>{{ $list->type }}</td>
                                        <td>{{ number_format($list->net) }}</td>
                                        <td>
                                            <form action="{{ route('lists.destroy', $list->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you you want to delete this item?');" class="dropdown-item">Delete</button>
                                            </form>
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