@extends('layouts.app')

@section('content')
<div class="main-content">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <h1>Dashboard</h1>
        <button class="btn btn-primary">Add Data</button>
    </div>

    <!-- Cards Section -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Customers</h5>
                    <p class="card-text">567,899</p>
                    <p class="text-success">+2.5%</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Revenue</h5>
                    <p class="card-text">$3,465 M</p>
                    <p class="text-success">+1.5%</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <p class="card-text">1,136,000</p>
                    <p class="text-danger">-0.2%</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Returns</h5>
                    <p class="card-text">1,789</p>
                    <p class="text-success">+0.1%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body chart-container">
                    <h5 class="card-title">Product Sales</h5>
                    <canvas id="productSalesChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body chart-container">
                    <h5 class="card-title">Sales by Category</h5>
                    <canvas id="salesByCategory"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
