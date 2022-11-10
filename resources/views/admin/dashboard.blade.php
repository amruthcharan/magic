@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title mb-30">
                        <h2>Dashboard</h2>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="icon-card mb-30">
                    <div class="icon purple">
                        <i class="lni lni-cart-full"></i>
                    </div>
                    <div class="content">
                        <h6 class="mb-10">New Orders</h6>
                        <h3 class="text-bold mb-10">34567</h3>
                        <p class="text-sm text-success">
                            <i class="lni lni-arrow-up"></i> +2.00%
                            <span class="text-gray">(30 days)</span>
                        </p>
                    </div>
                </div>
                <!-- End Icon Cart -->
            </div>
            <!-- End Col -->
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="icon-card mb-30">
                    <div class="icon success">
                        <i class="lni lni-dollar"></i>
                    </div>
                    <div class="content">
                        <h6 class="mb-10">Total Income</h6>
                        <h3 class="text-bold mb-10">$74,567</h3>
                        <p class="text-sm text-success">
                            <i class="lni lni-arrow-up"></i> +5.45%
                            <span class="text-gray">Increased</span>
                        </p>
                    </div>
                </div>
                <!-- End Icon Cart -->
            </div>
            <!-- End Col -->
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="icon-card mb-30">
                    <div class="icon primary">
                        <i class="lni lni-credit-cards"></i>
                    </div>
                    <div class="content">
                        <h6 class="mb-10">Total Expense</h6>
                        <h3 class="text-bold mb-10">$24,567</h3>
                        <p class="text-sm text-danger">
                            <i class="lni lni-arrow-down"></i> -2.00%
                            <span class="text-gray">Expense</span>
                        </p>
                    </div>
                </div>
                <!-- End Icon Cart -->
            </div>
            <!-- End Col -->
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="icon-card mb-30">
                    <div class="icon orange">
                        <i class="lni lni-user"></i>
                    </div>
                    <div class="content">
                        <h6 class="mb-10">New User</h6>
                        <h3 class="text-bold mb-10">34567</h3>
                        <p class="text-sm text-danger">
                            <i class="lni lni-arrow-down"></i> -25.00%
                            <span class="text-gray"> Earning</span>
                        </p>
                    </div>
                </div>
                <!-- End Icon Cart -->
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="title d-flex flex-wrap justify-content-between align-items-center">
                            <h6 class="text-medium mb-30">Recently Registered Shops</h6>
                    </div>
                    <!-- End Title -->
                    <div class="table-responsive">
                        <table class="table top-selling-table">
                            <thead>
                                <tr>
                                    <th>
                                        <h6 class="text-sm text-medium">Shop Name</h6>
                                    </th>
                                    <th class="min-width">
                                        <h6 class="text-sm text-medium">URL</h6>
                                    </th>
                                    <th class="min-width">
                                        <h6 class="text-sm text-medium">Installed at</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shops as $shop)
                                <tr>
                                    <td>
                                        <p class="text-sm">{{ $shop->getName() }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm">{{ $shop->shopify_url }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm">{{ $shop->created_at->diffForHumans() }}</p>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table -->
                    </div>
                </div>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
@endsection
