<!-- resources/views/users/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>User Details</h1>

        <dl class="row">
            <dt class="col-sm-3">Name</dt>
            <dd class="col-sm-9">{{ $user->name }}</dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">{{ $user->email }}</dd>
        </dl>

        <a href="{{ route('users.index') }}" class="btn btn-primary">Back to Users</a>
    </div>
@endsection
