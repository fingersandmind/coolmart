@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Terms</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('terms.index') }}">Terms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Terms and Services</h3>
                    </div>
                    <form action="{{ route('terms.update', $term->id) }}" method="POST">
                        <div class="card-body">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" 
                                placeholder="Name here.." value="{{ old('name') ?? $term->name }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Content</label>
                                <textarea class="form-control @error('content') is-invalid @enderror"" name="content" rows="6" placeholder="Content here..">{{ old('content') ?? $term->content }}</textarea>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <div class="flex">
                                <a href="{{ route('terms.index') }}" class="btn btn-danger">Cancel</a>
                                <button type="submit" name="action" value="continue" class="btn btn-info ml-auto">Submit and new</button>
                                <button type="submit" name="action" value="submit" class="btn btn-primary ml-auto">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection