@extends('layouts.admin.app')

@section('title', 'Admin Dashboard')
@section('content_title', 'User Table')
@section('breadcrumb', 'Edit User')

@section('sidebar')
    <!-- Sidebar content specific to this page -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link" href="{{ route('admin.dashboard')}}">
                    Dashboard
                </a>
                <a class="nav-link collapsed" href="{{ route('admin.users.index') }}" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    User
                </a>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    Pages
                </a>
                <a>
                <x-dropdown align="right" width="55">
                    <x-slot name="trigger">
                        <button>
                            <div>{{ Auth::user()->name }}</div>

                        </button>
                    </x-slot>

                    <x-slot name="content">
                      
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                </a>
            </div>
        </div>
    </nav>
@endsection

@section('content')
<div class="container">
        
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
            </div>
            <div class="form-group">
                <label for="account_type">Account Type</label>
                <select class="form-control" id="account_type" name="account_type">
                    <option value="Teacher" @if($user->account_type === 'Teacher') selected @endif>Teacher</option>
                    <option value="Student" @if($user->account_type === 'Student') selected @endif>Student</option>
                    <option value="Parent" @if($user->account_type === 'Parent') selected @endif>Parent</option>
                    <option value="Admin" @if($user->account_type === 'Admin') selected @endif>Admin</option>
                </select>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection