@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Items Table</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Items</a></li>
            </ol>
            <a href="{{ route('items.create') }}" class="btn btn-outline-primary"><i class="fa fa-plus mr-2"></i>Add Item</a>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Unit Items</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="wd-10p">Brand</th>
                                    <th class="wd-10p">Model</th>
                                    <th class="wd-15p">Description</th>
                                    <th class="wd-10p">Category</th>
                                    <th class="wd-10p">Srp</th>
                                    <th class="wd-10p">Cost</th>
                                    <th class="wd-5p">Qty</th>
                                    <th class="wd-20p">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            <a href="{{ route('brands.show',$item->brand->slug) }}">
                                                {{ ucfirst($item->brand->name) }}
                                            </a>
                                        </td>
                                        <td>{{ ucfirst($item->name) }}</td>
                                        <td>{{ strip_tags(str_limit($item->description, $limit=30, $end='..')) }}</td>
                                        <td>{{ ucfirst($item->category->name) }}</td>
                                        <td>&#8369; {{ number_format($item->srp,2) }}</td>
                                        <td>&#8369; {{ number_format($item->cost,2) }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown">
                                                    <i class="fa fa-cogs mr-2"></i>Actions
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('items.show', $item->slug) }}">View</a>
                                                    <a class="dropdown-item" href="{{ route('items.edit', $item->slug) }}">Edit</a>
                                                    <form action="{{ route('items.destroy', $item->slug) }}" method="POST">
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