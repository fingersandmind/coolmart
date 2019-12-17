@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Profile</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile "  style="background-image: url(/assets/images/photos/12.jpg);    background-position: center; background-size:cover;">
                    <div class="card-body text-center">
                        <img class="card-profile-img" src="{{ $profile->avatar }}" alt="img">
                        <h3 class="mb-3 text-white">{{ ucfirst($profile->user->name) }}</h3>
                        <p class="mb-4 text-white">{{ ucfirst($profile->title) }}</p>
                        <a href="{{ route('profile.edit', $profile->user->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Edit profile</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card p-5 ">
                    <div class="card-title">
                        Contact &amp; Personal Info
                    </div>
                    <div class="media-list">
                        <div class="media mt-1 pb-2">
                            <div class="mediaicon">
                                <i class="fa fa-link" aria-hidden="true"></i>
                            </div>
                            <div class="media-body ml-5 mt-1">
                                <h6 class="mediafont text-dark">Websites</h6><a class="d-block" href="#">http://Viboon.com</a> <a class="d-block" href="#">http://Viboon.net</a>
                            </div>
                            <!-- media-body -->
                        </div>
                        <!-- media -->

                        <!-- media -->
                        <div class="media mt-1 pb-2">
                            <div class="mediaicon">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                            </div>
                            <div class="media-body ml-5 mt-1">
                                <h6 class="mediafont text-dark">Email Address</h6><span class="d-block">{{ $profile->user->email }}</span>
                            </div>
                            <!-- media-body -->
                        </div>
                        <!-- media -->
                        <div class="media mt-1 pb-2">
                            <div class="mediaicon">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                            </div>
                            <div class="media-body ml-5 mt-1">
                                <h6 class="mediafont text-dark">Twitter</h6><a class="d-block" href="#">@Viboon</a>
                            </div>
                            <!-- media-body -->
                        </div>
                        <!-- media -->
                    </div>
                    <!-- media-list -->
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="card-box tilebox-one">
                            <i class="icon-layers float-right text-muted"><i class="fa fa-cubes text-primary" aria-hidden="true"></i></i>
                            <h6 class="text-drak text-uppercase mt-0">Projects</h6>
                            <h2 class="m-b-20">678</h2>
                            <span class="badge badge-primary"> +78% </span> <span class="text-muted">From previous period</span>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="card-box tilebox-one">
                            <i class="icon-layers float-right text-muted"><i class="fa fa-bar-chart text-secondary" aria-hidden="true"></i></i>
                            <h6 class="text-drak text-uppercase mt-0">Profits</h6>
                            <h2 class="m-b-20">7,908</h2>
                            <span class="badge badge-secondary"> +66% </span> <span class="text-muted">Last year</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class=" " id="profile-log-switch">
                            <div class="fade show active " >
                                <div class="table-responsive border ">
                                    <table class="table row table-borderless w-100 m-0 ">
                                        <tbody class="col-lg-6 p-0">
                                            <tr>
                                                <td><strong>Full Name :</strong>{{ ucfirst($profile->user->name) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Location :</strong> USA</td>
                                            </tr>
                                        </tbody>
                                        <tbody class="col-lg-6 p-0">
                                            <tr>
                                                <td><strong>Website :</strong> Viboon.com</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email :</strong>{{ $profile->user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Phone :</strong>{{ $profile->user->phone ?? 'Nothing to show'  }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row mt-5 profie-img">
                                    <div class="col-md-12">
                                        <div class="media-heading">
                                        <h5><strong>Biography</strong></h5>
                                    </div>
                                    <p>
                                         Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus</p>
                                    <p >because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure.</p>
                                    </div>
                                    <img class="img-fluid rounded w-25 h-25 m-2" src="assets/images/photos/8.jpg" alt="banner image">
                                    <img class="img-fluid rounded w-25 h-25 m-2" src="assets/images/photos/10.jpg" alt="banner image ">
                                    <img class="img-fluid rounded w-25 h-25 m-2" src="assets/images/photos/11.jpg" alt="banner image ">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection