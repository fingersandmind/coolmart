@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Accordion</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Faqs</li>
            </ol>
            <a href="{{ route('faqs.create') }}" class="btn btn-outline-primary"><i class="fa fa-plus fa-spin mr-2"></i>Add new Faq</a>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Frequently Asked Questions Table</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="wd-10p">Title</th>
                                        <th class="wd-10p">Content</th>
                                        <th class="wd-20p">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($faqs as $faq)
                                    <tr>
                                        <td>{{ str_limit($faq->title, $limit=10,$end='..') }}</td>
                                        <td>{{ str_limit($faq->body, $limit=50,$end='...') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown">
                                                    <i class="fa fa-spin fa-cogs mr-2"></i>Actions
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('faqs.edit', $faq->id) }}">Edit</a>
                                                    <form action="{{ route('faqs.destroy',$faq->id) }}" method="POST">
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
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">To be displayed as.</h3>
                    </div>
                    <div class="card-body">
                        <!-- Accordion begin -->
                        <ul class="demo-accordion accordionjs m-0" data-active-index="false">
                            <!-- Section 1 -->
                            @foreach ($faqs as $faq)
                                <li>
                                    <div><h3>{{ $faq->title }}</h3></div>
                                    <div>
                                        {{ $faq->body }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('additionalJS')
    <script src="{{ asset('assets/plugins/accordion/accordion.min.js') }}"></script>
    <script>
        $(function(e) {
            $(".demo-accordion").accordionjs();
        });
    </script>
@endpush
@push('additionalCSS')
    <link href="{{ asset('assets/plugins/accordion/accordion.css') }}" rel="stylesheet" />
@endpush