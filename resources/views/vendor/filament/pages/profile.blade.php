@extends('filament::page')

@section('content')
    <div class="space-y-6">
        <!-- Include the default profile content -->
        @include('filament::pages.profile')

        <!-- Include the logout other browser sessions form -->
        @include('profile.logout-other-browser-sessions-form')
    </div>
@endsection
