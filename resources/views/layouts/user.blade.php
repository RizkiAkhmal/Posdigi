<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Panel')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            line-height: 1.6;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar h1 {
            font-size: 1.5rem;
            font-weight: 600;
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
        
        .sidebar li {
            margin: 0.5rem 0;
        }
        
        .sidebar a {
            display: block;
            padding: 0.75rem 2rem;
            color: #333;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .sidebar a:hover,
        .sidebar a.active {
            background: #667eea;
            color: white;
            border-right: 4px solid #764ba2;
        }
        
        .main-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .welcome-section {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .welcome-section h1 {
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .stat-icon {
            font-size: 2rem;
        }
        
        .stat-info h3 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 0.25rem;
        }
        
        .stat-info p {
            color: #666;
            font-size: 0.9rem;
        }
        
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }
        
        .btn:hover {
            background: #5a6fd8;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: #6c757d;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-content h4 {
            margin-bottom: 0.25rem;
            color: #333;
        }
        
        .status {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status.pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status.approved {
            background: #d4edda;
            color: #155724;
        }
        
        .status.rejected {
            background: #f8d7da;
            color: #721c24;
        }
        
        .status.returned {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .no-activity {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 2rem;
        }
        
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                order: 2;
            }
            
            .main-content {
                order: 1;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>📚 Perpustakaan Digital</h1>
        <div class="user-info">
            <span>{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-secondary">Logout</button>
            </form>
        </div>
    </nav>
    
    <div class="container">
        <aside class="sidebar">
            <ul>
                <li><a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">🏠 Dashboard</a></li>
                <li><a href="{{ route('user.buku.index') }}" class="{{ request()->routeIs('user.buku.*') ? 'active' : '' }}">📚 Cari Buku</a></li>
                <li><a href="{{ route('user.peminjaman.index') }}" class="{{ request()->routeIs('user.peminjaman.*') ? 'active' : '' }}">📋 Peminjaman Saya</a></li>
                <li><a href="{{ route('user.profile') }}" class="{{ request()->routeIs('user.profile') ? 'active' : '' }}">👤 Profil</a></li>
            </ul>
        </aside>
        
        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            
            @yield('content')
        </main>
    </div>
</body>
</html>