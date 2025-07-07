<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Access Denied</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .error-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        }
        .error-code {
            font-size: 100px;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="error-box">
        <div class="error-code">403</div>
        <h2>Access Denied</h2>
        <p>You are not authorized to view this portfolio.</p>
        <a href="{{ url()->previous() }}" class="btn btn-danger mt-3">Go Back</a>
    </div>
</body>
</html>
