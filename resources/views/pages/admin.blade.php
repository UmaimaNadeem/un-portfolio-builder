@extends('layouts.app')

@section('content')
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mt-4">
        <h1>Dashboard</h1>
        <button class="btn btn-primary">Add Data</button>
    </div>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Projects</h5>
                    <p class="card-text">25</p>
                    <p class="text-success">+10%</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Skills</h5>
                    <p class="card-text">15</p>
                    <p class="text-success">+5%</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Testimonials</h5>
                    <p class="card-text">30</p>
                    <p class="text-success">+2%</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Contact Requests</h5>
                    <p class="card-text">12</p>
                    <p class="text-danger">-1%</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body chart-container">
                    <h5 class="card-title">Project Activity</h5>
                    <canvas id="projectActivityChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body chart-container">
                    <h5 class="card-title">Skills Distribution</h5>
                    <canvas id="skillsDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Projects</h5>
                    <ul class="list-group">
                        <li class="list-group-item">Project 1</li>
                        <li class="list-group-item">Project 2</li>
                        <li class="list-group-item">Project 3</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Testimonials</h5>
                    <ul class="list-group">
                        <li class="list-group-item">Testimonial 1</li>
                        <li class="list-group-item">Testimonial 2</li>
                        <li class="list-group-item">Testimonial 3</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
