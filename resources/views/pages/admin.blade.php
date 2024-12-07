<!-- resources/views/admin.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Add your CSS links here -->
</head>
<body>
    <h1>Welcome to the Admin Dashboard</h1>
    <!-- Add your admin-specific content here -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

</body>
</html>
