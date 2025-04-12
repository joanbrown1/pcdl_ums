@extends('layouts.admin')

@section('content')



    <!-- Row -->
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card">
                <div class="card-body pb-0">
                    <form action="{{ route('search.user') }}" method="POST">
                        @csrf
                        <div class="input-group mb-2">
                            <input type="text" name="email" class="form-control" placeholder="Search user's email..." required>
                            <button type="submit" class="input-group-text btn btn-primary">Search</button>
                        </div>
                    </form>

                </div>
                <div class="card-body p-5">
                    <p class="text-muted mb-0 ps-3">About 12,546,90000 results (0.56 Seconds)</p>
                </div>
            </div>

        </div>
    </div>
    <!-- End Row -->
@endsection
