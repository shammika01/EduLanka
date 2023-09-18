@extends('layouts.admin.app')

@section('title', 'Dashboard')
@section('content_title', 'Your Courses')
@section('breadcrumb', '')

@section('sidebar')
    <!-- Sidebar content specific to this page -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
            <a class="nav-link" href="{{ route('teacher.index') }}"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Assignments
                </a>
                <a class="nav-link active" href="{{ route('teacher.class.index') }}"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Courses
                </a>
                <a class="nav-link" href="{{ route('teacher.module.index') }}"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Modules
                </a>
                <a class="nav-link" href="{{ route('teacher.assignment.index') }}"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Assign Assignments
                </a>
                <a class="nav-link" href="{{url('/redirects')}}"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Main page
                </a>
                <a class="nav-link" href="{{ route('teacher.submissions')}}"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Submission
                </a>
                <a class="nav-link" href="{{url('/progress')}}"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Progression
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
        @php
            $authenticatedUserId = auth()->user()->id;
        @endphp
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Teacher ID</th>
                    <th>Status</th>
                    <th>Created by</th>
                    <th>Created Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($value as $value)
                    @if ($value->teacher_id == $authenticatedUserId)
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->teacher_id }}</td>
                            <td>
                                @if ($value->status == 0)
                                    Active
                                @else
                                    Inactive
                                @endif
                            </td>
                            <td>{{ $value->created_by_name }}</td>
                            <td>{{ date('d-m-Y-H:i A', strtotime($value->created_at)) }}</td>
                            <td>
                                <a href="{{ route('teacher.module.index', ['course_id' => $value->id]) }}"
                                    class="btn btn-primary">View Modules</a>


                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
