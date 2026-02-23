<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'POS Application')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #F5F7FA;
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            width: 240px;
            background: #1F2937;
            min-height: 100vh;
            padding: 1.5rem 0;
            position: fixed;
            left: 0;
            top: 0;
        }
        .sidebar-brand {
            padding: 0 1.5rem 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1rem;
        }
        .sidebar-brand h2 {
            color: white;
            font-size: 1.25rem;
            font-weight: 600;
        }
        .sidebar-menu {
            list-style: none;
        }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.5rem;
            color: #9CA3AF;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.95rem;
        }
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.05);
            color: #FF6B35;
            border-left: 3px solid #FF6B35;
            padding-left: calc(1.5rem - 3px);
        }
        .sidebar-menu .icon {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }
        .main-content {
            margin-left: 240px;
            flex: 1;
            padding: 2rem;
        }
        .top-bar {
            background: white;
            padding: 1.25rem 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .top-bar h1 {
            font-size: 1.5rem;
            color: #1F2937;
            font-weight: 600;
        }
        .top-bar-actions {
            display: flex;
            gap: 1rem;
        }
        .btn {
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            border: none;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background: #FF6B35;
            color: white;
        }
        .btn-primary:hover {
            background: #E55A2B;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255,107,53,0.3);
        }
        .content-area {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .dropdown-menu {
            position: relative;
        }
        .dropdown-toggle {
            cursor: pointer;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: #2C3E50;
            min-width: 200px;
            border-radius: 8px;
            margin-top: 0.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            z-index: 100;
        }
        .dropdown-menu:hover .dropdown-content {
            display: block;
        }
        .dropdown-content a {
            padding: 0.75rem 1.5rem !important;
            border-left: none !important;
            color: #9CA3AF !important;
        }
        .dropdown-content a:hover {
            background: rgba(255,255,255,0.05) !important;
            color: #FF6B35 !important;
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h2>🍊 POS System</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}"><span class="icon">📊</span> Dashboard</a></li>
            <li class="dropdown-menu">
                <a href="#" class="dropdown-toggle {{ request()->is('category/*') ? 'active' : '' }}">
                    <span class="icon">🛍️</span> Products <span style="margin-left: auto;">▾</span>
                </a>
                <div class="dropdown-content">
                    <a href="/category/food-beverage">Food & Beverage</a>
                    <a href="/category/beauty-health">Beauty & Health</a>
                    <a href="/category/home-care">Home Care</a>
                    <a href="/category/baby-kid">Baby & Kid</a>
                </div>
            </li>
            <li><a href="/sales" class="{{ request()->is('sales') ? 'active' : '' }}"><span class="icon">💰</span> Sales</a></li>
            <li><a href="/user/1/name/Admin"><span class="icon">👤</span> Profile</a></li>
        </ul>
    </aside>

    <main class="main-content">
        @yield('content')
    </main>
</body>
</html>
