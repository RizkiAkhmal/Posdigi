<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        
        .navbar {
            background: #343a40;
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navbar h1 {
            font-size: 1.5rem;
        }
        
        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .container {
            display: flex;
            min-height: calc(100vh - 70px);
        }
        
        .sidebar {
            width: 250px;
            background: white;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            padding: 2rem 0;
        }
        
        .sidebar ul {
            list-style: none;
        }
        
        .sidebar ul li {
            margin-bottom: 0.5rem;
        }
        
        .sidebar ul li a {
            display: block;
            padding: 0.75rem 2rem;
            color: #333;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .sidebar ul li a:hover {
            background: #f8f9fa;
        }
        
        .sidebar ul li a.active {
            background: #007bff;
            color: white;
        }
        
        .main-content {
            flex: 1;
            padding: 2rem;
        }
        
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .btn {
            padding: 8px 15px;
            margin: 5px;
            text-decoration: none;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            display: inline-block;
        }
        
        .btn-primary { background: #007bff; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-warning { background: #ffc107; color: #212529; }
        .btn-info { background: #17a2b8; color: white; }
        
        .alert {
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        .status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .status.tersedia {
            background: #d4edda;
            color: #155724;
        }
        
        .status.habis {
            background: #f8d7da;
            color: #721c24;
        }
        
        .status.rusak {
            background: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>Admin Panel</h1>
        <div class="user-info">
            <span>Welcome, Admin</span>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-secondary">Logout</button>
            </form>
        </div>
    </nav>
    
    <div class="container">
        <aside class="sidebar">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('admin.kategori.index') }}" class="{{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">Kategori</a></li>
                <li><a href="{{ route('admin.subkategori.index') }}" class="{{ request()->routeIs('admin.subkategori.*') ? 'active' : '' }}">Sub Kategori</a></li>
                <li><a href="{{ route('admin.buku.index') }}" class="{{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">Buku</a></li>
                <li><a href="{{ route('admin.stock.index') }}" class="{{ request()->routeIs('admin.stock.*') ? 'active' : '' }}">Stock</a></li>
                <li><a href="#" class="">Anggota</a></li>
                <li><a href="#" class="">Peminjaman</a></li>
            </ul>
        </aside>
        
        <main class="main-content">
            @yield('content')
        </main>
    </div>
</body>
</html>





