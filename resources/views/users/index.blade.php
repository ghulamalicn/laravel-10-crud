<!-- resources/views/users/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Users</h1>

        <table class="table">
            <thead>
                <tr>
                    <th><a href="{{ route('users.index', ['sort' => 'name']) }}">Name</a></th>
                    <th><a href="{{ route('users.index', ['sort' => 'email']) }}">Email</a></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
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
