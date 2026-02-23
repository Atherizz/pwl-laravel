@extends('layout')

@section('title', 'Dashboard')

@section('content')
<style>
    .dashboard-header {
        margin-bottom: 2rem;
    }
    .dashboard-header h1 {
        font-size: 1.875rem;
        color: #1F2937;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .dashboard-header p {
        color: #6B7280;
        font-size: 0.95rem;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        border: 1px solid #E5E7EB;
        transition: all 0.2s;
    }
    .stat-card:hover {
        border-color: #FF6B35;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255,107,53,0.1);
    }
    .stat-card .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    .stat-card.orange .stat-icon {
        background: rgba(255,107,53,0.1);
    }
    .stat-card.blue .stat-icon {
        background: rgba(59,130,246,0.1);
    }
    .stat-card.green .stat-icon {
        background: rgba(34,197,94,0.1);
    }
    .stat-card.purple .stat-icon {
        background: rgba(168,85,247,0.1);
    }
    .stat-card h3 {
        font-size: 0.875rem;
        color: #6B7280;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .stat-card .stat-value {
        font-size: 1.875rem;
        color: #1F2937;
        font-weight: 700;
    }
    .quick-actions {
        margin-top: 2rem;
    }
    .quick-actions h2 {
        font-size: 1.25rem;
        color: #1F2937;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }
    .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    .action-card {
        background: linear-gradient(135deg, #FF6B35 0%, #FF8C61 100%);
        padding: 2rem;
        border-radius: 12px;
        color: white;
        text-decoration: none;
        display: block;
        transition: all 0.2s;
    }
    .action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(255,107,53,0.3);
    }
    .action-card.secondary {
        background: linear-gradient(135deg, #3B82F6 0%, #60A5FA 100%);
    }
    .action-card.secondary:hover {
        box-shadow: 0 8px 20px rgba(59,130,246,0.3);
    }
    .action-card h3 {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    .action-card p {
        opacity: 0.9;
        font-size: 0.9rem;
    }
</style>

<div class="dashboard-header">
    <h1>Dashboard</h1>
    <p>Welcome back! Here's what's happening with your store today.</p>
</div>

<div class="stats-grid">
    <div class="stat-card orange">
        <div class="stat-icon">📦</div>
        <h3>Total Products</h3>
        <div class="stat-value">128</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon">💰</div>
        <h3>Sales Today</h3>
        <div class="stat-value">45</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon">💵</div>
        <h3>Revenue</h3>
        <div class="stat-value">Rp 2.5M</div>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon">👥</div>
        <h3>Customers</h3>
        <div class="stat-value">234</div>
    </div>
</div>

<div class="quick-actions">
    <h2>Quick Actions</h2>
    <div class="action-grid">
        <a href="/sales" class="action-card">
            <h3>💰 New Transaction</h3>
            <p>Start a new sales transaction</p>
        </a>
        <a href="/category/food-beverage" class="action-card secondary">
            <h3>🛍️ Browse Products</h3>
            <p>View all available products</p>
        </a>
    </div>
</div>
@endsection
