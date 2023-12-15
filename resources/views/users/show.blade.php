<!-- resources/views/users/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>User Details</h1>

        <dl class="row">
            <dt class="col-sm-3">User Name</dt>
            <dd class="col-sm-9">{{ $user->user_name }}</dd>
            <dt class="col-sm-3">First Name</dt>
            <dd class="col-sm-9">{{ $user->first_name }}</dd>
            <dt class="col-sm-3">Last Name</dt>
            <dd class="col-sm-9">{{ $user->last_name }}</dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">{{ $user->email }}</dd>
            <dt class="col-sm-3">Phone</dt>
            <dd class="col-sm-9">{{ $user->phone }}</dd>
            <dt class="col-sm-3">DOB</dt>
            <dd class="col-sm-9">{{ $user->dob }}</dd>
        </dl>

        <a href="{{ route('users.index') }}" class="btn btn-primary">Back to Users</a>
    </div>
@endsection
