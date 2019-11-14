@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Edit Profile</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
            </ol>
            <button type="button" class="btn btn-outline-primary"><i class="fa fa-pencil mr-2"></i>Edit Page</button>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">My Profile</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-auto">
                                <span class="avatar brround avatar-xl" style="background-image: url(/{{ $profile->avatar }})"></span>
                            </div>
                            <div class="col">
                                <h3 class="mb-1 ">{{ ucfirst($profile->user->name) }}</h3>
                                <p class="mb-4 ">{{ $profile->title }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email-Address</label>
                            <h5 class="mb-1">{{ $profile->user->email }}</h5>
                        </div>
                        <div class="form-footer">
                            <button name="action" value="user" class="btn btn-primary btn-block">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <form class="card" action="{{ route('profile.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h3 class="card-title">Edit Profile</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                    placeholder="e.g CEO, COO, CFO" value="{{ old('title') ?? $profile->title }}" >
                                    @error('title')
                                        <code style="color:red">{{ $message }}</code style="color:red">
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6 col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Phone</label>
                                    <input type="number" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                    placeholder="Phone number" value="{{ old('phone') ?? $profile->phone }}" >
                                    @error('phone')
                                        <code style="color:red">{{ $message }}</code style="color:red">
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-12">
                                <label class="form-label">Click or Drag Image here</label>
                                <div class="col-lg-12 col-sm-12">
                                    <input type="file" name="image" class="dropify @error('image') is-invalid @enderror" data-height="180"/>
                                    @error('image')
                                            <code style="color:red">{{ $message }}</code style="color:red">
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group mb-0">
                                    <label class="form-label">About me</label>
                                    <textarea rows="5" class="form-control" placeholder="Enter About your description">{{ old('about') ?? $profile->about }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button name="action" value="profile" type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('additionalCSS')
    <link href="{{ asset('assets/plugins/fileuploads/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('additionalJS')
    @include('pages.page-partials.dropify')
@endpush