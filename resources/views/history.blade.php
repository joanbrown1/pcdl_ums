@extends('layouts.admin')

@section('content')



    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transaction History</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if($userHistory)
                        <table id="file-datatable"
                               class="table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">ID</th>
                                <th class="wd-15p border-bottom-0">Product</th>
                                <th class="wd-15p border-bottom-0">Amount</th>
                                <th class="wd-15p border-bottom-0">Type</th>
                                <th class="wd-15p border-bottom-0">Description</th>
                                <th class="wd-15p border-bottom-0">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($userHistory as $item )
                                <tr>
                                    <td>{{ $item['id'] }}</td>
                                    <td>{{ $item['productID'] }}</td>
                                    <td>{{ $item['amount'] }}</td>
                                    <td>{{ $item['type'] }}</td>
                                    <td>{{ $item['description'] }}</td>
                                    <td>{{ $item['datetime'] }}</td>

                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        @else
                            <div class="col-12 text-center text-muted">
                                <p>No library items available.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection
