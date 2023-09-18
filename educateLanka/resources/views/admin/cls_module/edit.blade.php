@extends('layouts.admin.app')

@section('title', 'Dashboard')
@section('content_title', 'Edit Class/Modules')
@section('breadcrumb', '')

@section('sidebar')
    <!-- Sidebar content specific to this page -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link" href="{{ route('admin.dashboard') }}"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Dashboard
                </a>
                <a class="nav-link collapsed" href="{{ route('admin.users.index') }}" data-bs-toggle="collapse"
                    data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    User
                </a>
                {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                    aria-expanded="false" aria-controls="collapsePages"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Pages
                </a> --}}
                <a class="nav-link collapsed" href="{{ route('admin.class.index') }}" data-bs-toggle="collapse"
                    data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Course
                </a>
                <a class="nav-link collapsed" href="{{ route('admin.module.index') }}" data-bs-toggle="collapse"
                    data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Module
                </a>
                <a class="nav-link active" href="{{ route('admin.cls_module.index') }}" data-bs-toggle="collapse"
                    data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Class Module selection
                </a>
                </a>
                <a class="nav-link collapsed" href="{{ route('admin.assignment.index') }}" data-bs-toggle="collapse"
                    data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Assignments
                </a>
                </a>
                <a class="nav-link collapsed" href="{{ route('admin.classuser.index') }}" data-bs-toggle="collapse"
                    data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Course Allocation
                </a>
                <a class="nav-link collapsed" href="{{ route('admin.submissions') }}" data-bs-toggle="collapse"
                    data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Submissions
                </a>
                <a>
                    <x-dropdown align="right" width="55">
                        <x-slot name="trigger">
                            <div style="display: flex; justify-content: center; align-items: center; padding-top: 50px;">
                                <button
                                    style="border-radius: 10px; padding: 10px 20px; background-color: #3498db; color: white; border: none;">
                                    <div>{{ Auth::user()->name }}</div>
                                </button>
                            </div>
                        </x-slot>

                        <x-slot name="content">

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                        this.closest('form').submit();"
                                    style="display: block; padding: 10px 15px; color: #3498db; text-decoration: none; text-align: center; background: transparent; border: none;">
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
        <form method="post" action="">
            @csrf
            <div class="form-group">
                <label for="name">Class Name</label>
                <select class="form-control" name="class_id" required>
                    <option value="">Select Class</option>
                    @foreach ($getClass as $class)
                        <option {{ $getRecord->class_id == $class->id ? 'selected' : '' }} value="{{ $class->id }}">
                            {{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Module Name</label>
                @foreach ($getModule as $module)
                    @php
                        $checked = '';
                    @endphp
                    @foreach ($getAssignedModuleID as $moduleAssign)
                        @if ($moduleAssign->module_id == $module->id)
                            @php
                                $checked = 'checked';
                            @endphp
                        @endforeach
                        <div>
                            <label>
                                <input {{ $checked }} type="checkbox"
                                    value="{{ $module->id }}"name="module_id[]">{{ $module->name }}
                            </label>
                        </div>
                    @endforeach
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status">
                    <option {{ $getRecord->status == 0 ? 'selected' : '' }} value="0">Active</option>
                    <option {{ $getRecord->status == 1 ? 'selected' : '' }} value="1">InActive</option>
                </select>
            </div>

            <br>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
