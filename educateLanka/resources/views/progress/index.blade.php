@extends('layouts.admin.app')

@section('title', 'Dashboard')
@section('content_title', 'Progress')
@section('breadcrumb', ' Monitor Progress')

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
                    <th>Module Name</th>
                    <th>Number Of Coursework Posted</th>
                    <th>Submitted Coursework Count</th>
                    <th>Progress</th>



                    {{-- <th>type</th>
                    <th>Issued date</th>
                    <th>Submission date</th>
                    <th>Document</th>
                    <th>Status</th>
                    <th>Actions</th> --}}


                </tr>
            </thead>
            <tbody>
                </tr>
                </thead>
            <tbody>
                @foreach ($submissions as $submission)
                    <tr>
                        <td>{{ $submission->module->name }}</td>
                        <td>
                            @foreach ($assignmentCounts as $assignmentCount)
                                @if ($assignmentCount->module_id === $submission->module_id)
                                    {{ $assignmentCount->assignment_count }}
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $submission->submission_count }}</td>
                        <td>
                            @foreach ($assignmentCounts as $assignmentCount)
                                @if ($assignmentCount->module_id === $submission->module_id)
                                    {{ round(($submission->submission_count / $assignmentCount->assignment_count) * 100, 2) }}%
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <div class="container mt-5">
        <form method="post" action="{{ route('submissions.view') }}">
            @csrf
            <label for="user_id">If Your Are Not A student Enter The User ID You Prefer to Monitor:</label>
            <input type="text" name="user_id" id="user_id" required>
            <button type="submit">Submit</button>
        </form>




    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var submitButtons = document.querySelectorAll(".submit-button");

            // Check if the submission was successful
            if (typeof submissionSuccess !== 'undefined' && submissionSuccess === true) {
                submitButtons.forEach(function(button) {
                    button.disabled = true;
                });
            }
        });
    </script>


@endsection
