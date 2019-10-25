@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Unit Model Types</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('models.index') }}">Types</a></li>
            </ol>
            {{-- <a href="{{ route('models.create') }}" class="btn btn-outline-primary"><i class="fa fa-plus mr-2"></i>Add Types</a> --}}
        </div>
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List Group  With color badges</h3>
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
@endsection