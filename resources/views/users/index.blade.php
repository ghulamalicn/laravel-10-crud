<!-- resources/views/users/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Users</h1>
        
        <table class="table">
            <thead>
                <tr>
                    <th><a href="{{ route('users.index', ['sort' => 'firstName', 'sortOrder' => ($sortField == 'firstName' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}">First Name</a></th>
                    <th><a href="{{ route('users.index', ['sort' => 'lastName', 'sortOrder' => ($sortField == 'lastName' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}">Last Name</a></th>
                    <th><a href="{{ route('users.index', ['sort' => 'email', 'sortOrder' => ($sortField == 'email' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}">Email</a></th>
                    <th><a href="{{ route('users.index', ['sort' => 'phone', 'sortOrder' => ($sortField == 'phone' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}">Phone</a></th>
                    <th><a href="{{ route('users.index', ['sort' => 'dob', 'sortOrder' => ($sortField == 'dob' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}">Date Of Birth</a></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->firstName }}</td>
                        <td>{{ $user->lastName }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->dob }}</td>
                        <td>
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
@endsection
