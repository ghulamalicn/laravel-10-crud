<!-- resources/views/users/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Users</h1>
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <!-- Add a search form at the top of your table -->
        <form method="GET" action="{{ route('users.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control @error('search') is-invalid @enderror" placeholder="Search..." value="{{ old('search', $search) }}">
                @error('search')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-outline-secondary mt-2">Search</button>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>id</th>
                    <th><a href="{{ route('users.index', ['sort' => 'user_name', 'sortOrder' => ($sortField == 'user_name' && $sortOrder == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">User Name</a></th>
                    <th><a href="{{ route('users.index', ['sort' => 'first_name', 'sortOrder' => ($sortField == 'first_name' && $sortOrder == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">First Name</a></th>
                    <th><a href="{{ route('users.index', ['sort' => 'last_name', 'sortOrder' => ($sortField == 'last_name' && $sortOrder == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">Last Name</a></th>
                    <th><a href="{{ route('users.index', ['sort' => 'email', 'sortOrder' => ($sortField == 'email' && $sortOrder == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">Email</a></th>
                    <th><a href="{{ route('users.index', ['sort' => 'phone', 'sortOrder' => ($sortField == 'phone' && $sortOrder == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">Phone</a></th>
                    <th><a href="{{ route('users.index', ['sort' => 'dob', 'sortOrder' => ($sortField == 'dob' && $sortOrder == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">Date Of Birth</a></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($users) > 0)
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->user_name }}</td>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
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
                @else
                    <tr class="text-center">
                        <td colspan="7" class="text-danger">No records found.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
@endsection
@push('scripts')
    <script>
        // Remove alert messages after 5 seconds
        $(document).ready(function(){
            setTimeout(function(){
                $('.alert').fadeOut();
            }, 5000);
        });
    </script>
@endpush
