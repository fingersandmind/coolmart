@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Unit Model Types</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('types.index') }}">Types</a></li>
            </ol>
            {{-- <a href="{{ route('models.create') }}" class="btn btn-outline-primary"><i class="fa fa-plus mr-2"></i>Add Types</a> --}}
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h3 class="card-title">Unit Types</h3>
                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#addType">
                        <i class="fa fa-plus mr-2"></i>Add Type
                    </button>
                </div>
                @include('pages.types.types-partials.create')
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($types as $type)
                            <li class="list-group-item justify-content-between d-flex align-items-center">
                                <button class="btn btn-info">{{ $type->name }}</button>
                                <div class="justify-content-between">
                                    <div class="d-flex">
                                        <form action="{{ route('types.destroy', $type->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-danger btn-sm" type="submit"><i class="fa fa-trash text-white"></i></button>
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection