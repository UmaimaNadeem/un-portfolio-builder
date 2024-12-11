<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            transition: transform 0.3s ease-in-out;
            z-index: 1000;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            padding: 15px;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 18px;
        }
        .sidebar a:hover {
            background-color: #495057;
            border-radius: 4px;
        }
        .sidebar .fa {
            margin-right: 15px;
        }
        .main-content {
            margin-left: 250px;
            transition: margin-left 0.3s ease-in-out;
            padding: 20px;
        }
        .main-content.hidden-sidebar {
            margin-left: 0;
        }
        .navbar {
            z-index: 999;
        }
        .btn-toggle {
            padding: 10px;
            background: #343a40;
            color: white;
            border: none;
        }
        .sidebar-hidden {
            transform: translateX(-100%);
        }

        /* Cards Styling */
        .card {
            margin-bottom: 20px;
        }

        /* Chart Styles */
        .chart-container {
            padding: 20px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h5 class="text-center text-white mb-4">Flup</h5>
        <ul class="list-unstyled">
            <li><a href="#" class="active"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-box"></i> Orders</a></li>
            <li><a href="#"><i class="fa fa-users"></i> Customers</a></li>
            <li><a href="#"><i class="fa fa-bullhorn"></i> Marketing</a></li>
            <li><a href="#"><i class="fa fa-credit-card"></i> Payments</a></li>
            <li><a href="#"><i class="fa fa-cogs"></i> System</a></li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="btn btn-toggle" id="sidebarToggleBtn">
                <i class="fa fa-bars"></i>
            </button>
            <h1 class="ml-4">Dashboard</h1>

            <!-- Profile Dropdown -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user"></i> Profile
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">My Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" action="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sidebar Toggle Functionality
        document.getElementById('sidebarToggleBtn').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.querySelector('.main-content');
            sidebar.classList.toggle('sidebar-hidden');
            mainContent.classList.toggle('hidden-sidebar');
        });

        // Product Sales Chart
        const ctx = document.getElementById('productSalesChart').getContext('2d');
        const productSalesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['1 Jul', '2 Jul', '3 Jul', '4 Jul', '5 Jul', '6 Jul', '7 Jul'],
                datasets: [{
                    label: 'Gross Margin',
                    data: [30, 45, 55, 60, 50, 70, 80],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    fill: false
                }, {
                    label: 'Revenue',
                    data: [40, 50, 60, 65, 55, 75, 85],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    fill: false
                }]
            }
        });

        // Sales by Category Chart
        const ctx2 = document.getElementById('salesByCategory').getContext('2d');
        const salesByCategory = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Living room', 'Kids', 'Office', 'Bedroom', 'Kitchen', 'Bathroom', 'Dining room'],
                datasets: [{
                    data: [25, 17, 12, 10, 9, 8, 5],
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF5733', '#C70039', '#9C27B0']
                }]
            }
        });
    </script>
</body>
</html>
