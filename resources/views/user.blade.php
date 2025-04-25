@extends('layouts.admin')

@section('content')

    @if(isset($userData))
        <!-- ROW-1 OPEN -->
        <div class="row" id="user-profile">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="wideget-user mb-2">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="row">
                                        <div class="panel profile-cover">
                                            <div class="profile-cover__action bg-img"></div>
                                            <div class="profile-cover__img">
                                                <div class="profile-img-1">
                                                    <img src="{{ $userData['avatar_url'] ?? asset('assets/images/users/21.jpg') }}" alt="img" style="width: 300px;">
                                                </div>
                                                <div class="profile-img-content text-dark text-start">
                                                    <div class="text-dark">
                                                        <h3 class="h3 mb-2">{{ $userData['title'] }} {{ $userData['first_name'] }} {{ $userData['last_name'] }}</h3>
                                                        <h5 class="text-muted">{{ $userData['email'] }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="px-0 px-sm-4">
                                            <div class="social social-profile-buttons mt-5 float-end">
                                                <div class="mt-3"><br/></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ROW-2 OPEN -->
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card panel-theme">
                            <div class="card-header">
                                <div class="float-start">
                                    <h3 class="card-title">User Details</h3>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="card-body no-padding">
                                <ul class="list-group no-margin">
                                    <li class="list-group-item d-flex ps-3">
                                        <div class="social me-2">
                                            <span class="text-primary">Email:</span>
                                        </div>
                                        <span class="my-auto">{{ $userData['email'] }}</span>
                                    </li>
                                    <li class="list-group-item d-flex ps-3">
                                        <div class="social me-2">
                                            <span class="text-primary">Country:</span>
                                        </div>
                                        <span class="my-auto">{{ $userData['country'] ?? 'N/A' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex ps-3">
                                        <div class="social me-2">
                                            <span class="text-primary">Church:</span>
                                        </div>
                                        <span class="my-auto">{{ $userData['church'] ?? 'N/A' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex ps-3">
                                        <div class="social me-2">
                                            <span class="text-primary">Zone:</span>
                                        </div>
                                        <span class="my-auto">{{ $userData['zone'] ?? 'N/A' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex ps-3">
                                        <div class="social me-2">
                                            <span class="text-primary">Christ Embassy Member:</span>
                                        </div>
                                        <span class="my-auto">{{ $userData['christ_embassy_member'] ? 'True' : 'False' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex ps-3">
                                        <div class="social me-2">
                                            <span class="text-primary">Wallet Balance:</span>
                                        </div>
                                        <span class="my-auto">{{ number_format($userData['wallet_balance'] ?? 0, 4) }}</span>
                                    </li>
                                    <li class="list-group-item d-flex ps-3">
                                        <div class="social me-2">
                                            <span class="text-primary">Subscription Name:</span>
                                        </div>
                                        <span class="my-auto">{{ $userData->subscription['name'] ?? 'None' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex ps-3">
                                        <div class="social me-2">
                                            <span class="text-primary">Subscription Expiring:</span>
                                        </div>
                                        <span class="my-auto">
                                    {{ $userData['subscription_expiration'] ? \Carbon\Carbon::parse($userData['subscription_expiration'])->format('jS F, Y') : 'N/A' }}
                                </span>
                                    </li>
                                </ul><br/>
                                <a href="{{ route('history',$userData['email']) }}" class="btn btn-success">See Transaction History</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <div class="row card-body">
                            <h3 class="p-3 mb-5">Library</h3>

                            @if($userData['library'])
                                @foreach($userData['library'] as $item)
                                    <div class="col-md-6 col-xl-4">
                                        <div class="card">
                                            <div class="product-grid6">
                                                <div class="product-image6 p-5">
                                                    <a href="{{ $item['link'] ?? '#' }}" class="bg-light">
                                                        <img class="img-fluid br-7 w-100" src="{{$item['cover_url'] ?? asset('assets/images/products/3.jpg') }}" alt="img">
                                                    </a>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="product-content text-center">
                                                        <h1 class="title fw-bold fs-20">
                                                            <a href="{{ $item['link'] ?? '#' }}">{{ $item['title'] }}</a>
                                                        </h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12 text-center text-muted">
                                    <p>No library items available.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- ROW-2 CLOSED -->
            </div>
        </div>
        <!-- ROW-1 CLOSED -->
    @else
        <p class="text-center">No User Found.</p>
    @endif

@endsection
