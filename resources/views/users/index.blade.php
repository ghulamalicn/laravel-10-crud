@extends('layouts.default')
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
        <div id="app">
            <user-list :users='@json($users)' :sort-field='@json($sortField)' :sort-order='@json($sortOrder)' :search='@json($search)'></user-list>
        </div>
        {{ $users->links() }}
    </div>
@endsection


