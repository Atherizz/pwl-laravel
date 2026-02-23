@extends('layout')

@section('title', 'Sales Transaction')

@section('content')
<style>
    .page-header {
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .page-header-left h1 {
        font-size: 1.875rem;
        color: #1F2937;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    .breadcrumb {
        color: #6B7280;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    .breadcrumb a {
        color: #FF6B35;
        text-decoration: none;
    }
    .filter-bar {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: #F9FAFB;
        border-radius: 10px;
    }
    .filter-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .filter-item label {
        font-size: 0.875rem;
        color: #6B7280;
        font-weight: 500;
    }
    .filter-item select {
        padding: 0.625rem 1rem;
        border: 1px solid #E5E7EB;
        border-radius: 8px;
        font-size: 0.9rem;
        background: white;
    }
    .transaction-list {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }
    .transaction-card {
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.2s;
    }
    .transaction-card:hover {
        border-color: #FF6B35;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .transaction-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.5rem;
        background: #F9FAFB;
        border-bottom: 1px solid #E5E7EB;
    }
    .transaction-id {
        font-size: 1rem;
        font-weight: 700;
        color: #1F2937;
    }
    .transaction-badge {
        padding: 0.375rem 0.875rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .badge-completed {
        background: rgba(34,197,94,0.1);
        color: #22C55E;
    }
    .badge-pending {
        background: rgba(251,191,36,0.1);
        color: #F59E0B;
    }
    .transaction-body {
        padding: 1.5rem;
    }
    .transaction-info {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #F3F4F6;
    }
    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
    }
    .info-label {
        font-size: 0.75rem;
        color: #9CA3AF;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .info-value {
        font-size: 0.95rem;
        color: #1F2937;
        font-weight: 600;
    }
    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1rem;
    }
    .items-table thead {
        background: #F9FAFB;
    }
    .items-table th {
        padding: 0.75rem;
        text-align: left;
        font-size: 0.75rem;
        color: #6B7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .items-table td {
        padding: 0.875rem 0.75rem;
        border-top: 1px solid #F3F4F6;
        font-size: 0.875rem;
        color: #1F2937;
    }
    .transaction-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1.25rem;
        border-top: 2px solid #E5E7EB;
    }
    .total-label {
        font-size: 1rem;
        color: #6B7280;
        font-weight: 600;
    }
    .total-value {
        font-size: 1.5rem;
        color: #FF6B35;
        font-weight: 700;
    }
    .btn-new {
        padding: 0.75rem 1.5rem;
        background: #FF6B35;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }
    .btn-new:hover {
        background: #E55A2B;
        transform: translateY(-1px);
    }
</style>

<div class="page-header">
    <div class="page-header-left">
        <h1>Sales Transaction</h1>
        <div class="breadcrumb">
            <a href="/">Dashboard</a> / <span>Sales</span>
        </div>
    </div>
    <button class="btn-new">+ New Transaction</button>
</div>

<div class="filter-bar">
    <div class="filter-item">
        <label>Status</label>
        <select>
            <option>All Status</option>
            <option>Completed</option>
            <option>Pending</option>
        </select>
    </div>
    <div class="filter-item">
        <label>Date Range</label>
        <select>
            <option>Today</option>
            <option>This Week</option>
            <option>This Month</option>
        </select>
    </div>
</div>

<div class="transaction-list">
    @foreach($sales as $sale)
        <div class="transaction-card">
            <div class="transaction-header">
                <div class="transaction-id">{{ $sale['id'] }}</div>
                <div class="transaction-badge badge-{{ strtolower($sale['status']) }}">
                    {{ $sale['status'] }}
                </div>
            </div>
            
            <div class="transaction-body">
                <div class="transaction-info">
                    <div class="info-item">
                        <div class="info-label">Date</div>
                        <div class="info-value">{{ date('M d, Y', strtotime($sale['date'])) }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Customer</div>
                        <div class="info-value">{{ $sale['customer'] }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Items</div>
                        <div class="info-value">{{ count($sale['items']) }} items</div>
                    </div>
                </div>

                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th style="text-align: center;">Qty</th>
                            <th style="text-align: right;">Price</th>
                            <th style="text-align: right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale['items'] as $item)
                            <tr>
                                <td>{{ $item['product'] }}</td>
                                <td style="text-align: center;">{{ $item['qty'] }}</td>
                                <td style="text-align: right;">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td style="text-align: right; font-weight: 600;">Rp {{ number_format($item['qty'] * $item['price'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="transaction-footer">
                    <span class="total-label">Total Amount</span>
                    <span class="total-value">Rp {{ number_format($sale['total'], 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
