@extends('layout')

@section('title', 'Profile - ' . $user['name'])

@section('content')
<style>
    .page-header {
        margin-bottom: 2rem;
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
    .profile-layout {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 2rem;
    }
    .profile-sidebar {
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        padding: 2rem;
        height: fit-content;
    }
    .profile-avatar-container {
        text-align: center;
        margin-bottom: 1.5rem;
    }
    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #FF6B35 0%, #FF8C61 100%);
        margin: 0 auto 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        font-weight: bold;
    }
    .profile-name {
        font-size: 1.25rem;
        color: #1F2937;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    .profile-role {
        color: #6B7280;
        font-size: 0.875rem;
    }
    .profile-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #E5E7EB;
    }
    .stat-item {
        text-align: center;
    }
    .stat-value {
        font-size: 1.5rem;
        color: #1F2937;
        font-weight: 700;
    }
    .stat-label {
        font-size: 0.75rem;
        color: #6B7280;
        margin-top: 0.25rem;
    }
    .profile-main {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    .info-card {
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        padding: 1.5rem;
    }
    .info-card h2 {
        font-size: 1.125rem;
        color: #1F2937;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }
    .info-row {
        display: grid;
        grid-template-columns: 140px 1fr;
        padding: 1rem 0;
        border-bottom: 1px solid #F3F4F6;
    }
    .info-row:last-child {
        border-bottom: none;
    }
    .info-label {
        font-size: 0.875rem;
        color: #6B7280;
        font-weight: 500;
    }
    .info-value {
        font-size: 0.875rem;
        color: #1F2937;
        font-weight: 500;
    }
    .btn-edit {
        width: 100%;
        padding: 0.75rem;
        background: #FF6B35;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        margin-top: 1rem;
    }
    .btn-edit:hover {
        background: #E55A2B;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .profile-layout {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <h1>User Profile</h1>
    <div class="breadcrumb">
        <a href="/">Dashboard</a> / <span>Profile</span>
    </div>
</div>

<div class="profile-layout">
    <div class="profile-sidebar">
        <div class="profile-avatar-container">
            <div class="profile-avatar">
                {{ strtoupper(substr($user['name'], 0, 1)) }}
            </div>
            <div class="profile-name">{{ $user['name'] }}</div>
            <div class="profile-role">{{ $user['role'] }}</div>
        </div>
        
        <div class="profile-stats">
            <div class="stat-item">
                <div class="stat-value">45</div>
                <div class="stat-label">Sales</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">12</div>
                <div class="stat-label">Today</div>
            </div>
        </div>
        
        <button class="btn-edit">Edit Profile</button>
    </div>

    <div class="profile-main">
        <div class="info-card">
            <h2>Personal Information</h2>
            <div class="info-row">
                <div class="info-label">User ID</div>
                <div class="info-value">#{{ str_pad($user['id'], 4, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Full Name</div>
                <div class="info-value">{{ $user['name'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email Address</div>
                <div class="info-value">{{ $user['email'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Role</div>
                <div class="info-value">
                    <span style="background: rgba(255,107,53,0.1); color: #FF6B35; padding: 0.25rem 0.75rem; border-radius: 6px; font-size: 0.8rem; font-weight: 600;">
                        {{ $user['role'] }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Joined Date</div>
                <div class="info-value">{{ date('F d, Y', strtotime($user['joined_date'])) }}</div>
            </div>
        </div>

        <div class="info-card">
            <h2>Recent Activity</h2>
            <div class="info-row">
                <div class="info-label">Last Login</div>
                <div class="info-value">{{ date('F d, Y H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Last Transaction</div>
                <div class="info-value">2 hours ago</div>
            </div>
            <div class="info-row">
                <div class="info-label">Status</div>
                <div class="info-value">
                    <span style="background: rgba(34,197,94,0.1); color: #22C55E; padding: 0.25rem 0.75rem; border-radius: 6px; font-size: 0.8rem; font-weight: 600;">
                        Active
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
