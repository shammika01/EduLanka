@extends('layouts.admin.app')

@section('title', 'Dashboard')
@section('content_title', 'Assignment')
@section('breadcrumb', 'Assign Assignments')

@section('sidebar')
    <!-- Sidebar content specific to this page -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                
                <a class="nav-link" href="{{ url('/redirects') }}"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Home
                </a>
            <a class="nav-link active" href="{{ route('student.course') }}" data-bs-toggle="collapse"
                    data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Courses
                </a>
                <!-- <a class="nav-link collapsed" href="{{ route('student.index') }}" data-bs-toggle="collapse"
                    data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Assignments
                </a> -->
                <a class="nav-link collapsed" href="{{ route('student.module.index') }}" data-bs-toggle="collapse"
                    data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Modules
                </a>
                <a class="nav-link collapsed" href="{{ url('/progress') }}" data-bs-toggle="collapse"
                    data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Progression
                </a>
                <a class="nav-link collapsed" href="{{ route('student.submissions') }}" data-bs-toggle="collapse"
                    data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages"
                    style="display: block; text-align: center; font-size: 18px; transition: font-size 0.3s ease-in-out;">
                    Submittion
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
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Class</th>
                    <th>Module</th>
                    <th>type</th>
                    <th>Issued date</th>
                    <th>Submission date</th>
                    <th>Document</th>
                    <th>Status</th>
                    <th>Actions</th>


                </tr>
            </thead>
            <tbody>
                @foreach ($assignments as $assignment)
                    <tr>
                        <td>{{ $assignment->id }}</td>
                        <td>{{ $assignment->assignmentClass->name }}</td>
                        <td>{{ $assignment->assignmentModule->name }}</td>
                        <td>{{ $assignment->type }}</td>
                        <td>{{ $assignment->issue_date }}</td>
                        <td>{{ $assignment->submission_date }}</td>
                        <td>
                            @if (!empty($assignment->document_file))
                                <a href="{{ asset($assignment->document_file) }}" class="btn btn-primary"
                                    download="{{ $assignment->document_file }}">Download</a>
                            @endif
                        </td>

                        <td>
                            @if ($assignment->status == 0)
                                Active
                            @else
                                Inactive
                            @endif
                        </td>
                        {{-- <td>{{ $assignment->created_by_name }}</td>
                        <td>{{ date('d-m-Y-H:i A', strtotime($assignment->created_at)) }}</td> --}}
                        <td>
                            <form method="post" action="{{ route('student.assignment.submit') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="module_id" value="{{ $assignment->module_id }}">
                                <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
                                <input type="file" class="form-control mb-3" name="document_file" required>
                                <button type="submit" class="btn btn-primary submit-button" id="submitBtn">Submit</button>
                            </form>


                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var submitButton = document.getElementById("submitBtn");
            var submissionSuccess = localStorage.getItem("submissionSuccess");

            if (submissionSuccess === "true") {
                // If submission was successful previously, disable the button
                submitButton.disabled = true;
            }

            submitButton.addEventListener("click", function() {
                if (submissionSuccess !== "true") {
                    // If submission was not successful previously, disable the button and set the flag
                    submitButton.disabled = true;
                    localStorage.setItem("submissionSuccess", "true");
                }
            });
        });
    </script>



@endsection
