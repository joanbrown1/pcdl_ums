@extends('layouts.admin')

@section('content')



    <!-- Row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Update Password Form</h4>
                </div>
                <div class="card-body">
                    @if($savedPassword)
                        <div class="alert alert-success " role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-hidden="true">×</button>
                            Success! User password has been updated.
                        </div>
                    @endif
                    <form action="{{ route('update.password') }}" method="POST">
                        @csrf
                        <div class="">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Email
                                    address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1"
                                       class="form-label">Password</label>
                                <input type="text" class="form-control"
                                       id="password" name="password" placeholder="Enter New Password">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 mb-0">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection
