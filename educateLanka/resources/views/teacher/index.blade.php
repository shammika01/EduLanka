@extends('layouts.admin.app')

@section('title', 'Teacher Dashboard')
@section('content_title', 'Assignment')
@section('breadcrumb', 'Add assignments')

@section('sidebar')
    <!-- Sidebar content specific to this page -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
            <a class="nav-link active" href="{{ route('teacher.index') }}"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Assignments
                </a>
                <a class="nav-link" href="{{ route('teacher.class.index') }}"
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
    <a href="{{ url('/admin/assignment/add') }}" class="btn btn-primary">Add</a>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Class</th>
                    <th>Module</th>
                    <th>Issued date</th>
                    <th>Submission date</th>
                    <th>Document [-download-]</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($getRecord as $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->class_name }}</td>
                        <td>{{ $value->module_name }}</td>
                        <td>{{ date('d-m-Y', strtotime($value->issue_date)) }}</td>
                        <td>{{ date('d-m-Y', strtotime($value->submission_date)) }}</td>
                        <td>

                            @if (!empty($value->getDocument()))
                                <a href="{{ $value->getDocument() }}" class="btn btn-primary"download="">Download</a>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('/admin/assignment/delete', $value->id) }}" class="btn btn-primary">Delete</a>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%">Record not Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
