@if (Auth::user())
@include('home') 
@else
@include('auth.login') 
@endif