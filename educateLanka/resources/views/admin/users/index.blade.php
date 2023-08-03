@extends('layouts.admin.app')

@section('title', 'Admin Dashboard')
@section('content_title', 'User Table')
@section('breadcrumb', 'Manage Users')

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
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Account Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->account_type }}</td>
                    <td>
                        <!-- Edit Button -->
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">Edit</a>

                        <!-- Delete Button -->
                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
