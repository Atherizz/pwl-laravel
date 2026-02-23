@extends('layout')

@section('title', 'Products - ' . $category)

@section('content')
<style>
    .page-header {
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .page-header h1 {
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
    .breadcrumb a:hover {
        text-decoration: underline;
    }
    .search-filter-bar {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: #F9FAFB;
        border-radius: 10px;
    }
    .search-box {
        flex: 1;
        position: relative;
    }
    .search-box input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.75rem;
        border: 1px solid #E5E7EB;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.2s;
    }
    .search-box input:focus {
        outline: none;
        border-color: #FF6B35;
        box-shadow: 0 0 0 3px rgba(255,107,53,0.1);
    }
    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9CA3AF;
    }
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.25rem;
    }
    .product-card {
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        padding: 1.25rem;
        transition: all 0.2s;
        cursor: pointer;
    }
    .product-card:hover {
        border-color: #FF6B35;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .product-image {
        width: 100%;
        height: 140px;
        background: linear-gradient(135deg, #FFF5F2 0%, #FFE8DF 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    .product-name {
        font-size: 1rem;
        color: #1F2937;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .product-id {
        font-size: 0.75rem;
        color: #9CA3AF;
        margin-bottom: 0.75rem;
    }
    .product-price {
        font-size: 1.125rem;
        color: #FF6B35;
        font-weight: 700;
    }
    .add-btn {
        width: 100%;
        padding: 0.625rem;
        background: #FF6B35;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        margin-top: 0.75rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .add-btn:hover {
        background: #E55A2B;
        transform: translateY(-1px);
    }
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #9CA3AF;
    }
    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }
</style>

<div class="page-header">
    <div>
        <h1>{{ $category }}</h1>
        <div class="breadcrumb">
            <a href="/">Dashboard</a> / <a href="#">Products</a> / <span>{{ $category }}</span>
        </div>
    </div>
</div>

<div class="search-filter-bar">
    <div class="search-box">
        <span class="search-icon">🔍</span>
        <input type="text" placeholder="Search products...">
    </div>
</div>

@if(count($products) > 0)
    <div class="product-grid">
        @foreach($products as $product)
            <div class="product-card">
                <div class="product-image">🍱</div>
                <div class="product-id">#{{ str_pad($product['id'], 4, '0', STR_PAD_LEFT) }}</div>
                <div class="product-name">{{ $product['name'] }}</div>
                <div class="product-price">Rp {{ number_format($product['price'], 0, ',', '.') }}</div>
                <button class="add-btn">Add to Cart</button>
            </div>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <div class="empty-state-icon">📦</div>
        <h3>No products found</h3>
        <p>There are no products in this category</p>
    </div>
@endif
@endsection
