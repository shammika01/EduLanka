@extends('layouts.admin.app')

@section('title', 'Dashboard')
@section('content_title', 'Assignment')
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
                <a class="nav-link" href="{{ route('teacher.class.index') }}"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Courses
                </a>
                <a class="nav-link" href="{{ route('teacher.module.index') }}"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Modules
                </a>
                <a class="nav-link active" href="{{ route('teacher.assignment.index') }}"
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
    @php
        $authenticatedUserId = auth()->user()->id;
    @endphp
    <div class="container">
        <form method="post" action="{{ route('teacher.assignment.add') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Class Name</label>
                <select class="form-control" name="class_id" id="class_id" required>
                    <option value="">Select Class</option>
                    @foreach ($getClass as $class)
                        @if ($class->teacher_id == $authenticatedUserId)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endif
                    @endforeach
                </select>

            </div>

            <div class="form-group">
                <label>Module Name</label>
                <select class="form-control" name="module_id" id="module_id" required>
                    <option value="">Select Module</option>
                </select>

            </div>

            <div class="form-group">
                <label>Issued date</label>
                <input type="date" class="form-control" name="issue_date" required>
            </div>
            <div class="form-group">
                <label>Issued date</label>
                <input type="date" class="form-control" name="submission_date" required>
            </div>
            <div class="form-group">
                <label>Document</label>
                <input type="file" class="form-control" name="document_file" required>
            </div>

            <br>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const classSelect = document.getElementById('class_id');
            const moduleSelect = document.getElementById('module_id');

            classSelect.addEventListener('change', function() {
                const selectedClassId = this.value;

                // Clear existing options in the module dropdown
                while (moduleSelect.options.length > 1) {
                    moduleSelect.remove(1);
                }

                // If no class is selected, exit early
                if (!selectedClassId) {
                    return;
                }

                // Loop through the modules and add options that match the selected class's id
                @foreach ($getModule as $module)
                    if ({{ $module->course_id }} === parseInt(selectedClassId)) {
                        const option = document.createElement('option');
                        option.value = {{ $module->id }};
                        option.text = '{{ $module->name }}';
                        moduleSelect.appendChild(option);
                    }
                @endforeach
            });
        });
    </script>

@endsection
