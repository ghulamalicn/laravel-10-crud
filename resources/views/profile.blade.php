@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1>Profile</h1>
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
                <form action="{{ url('profile-update', auth()->user()->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <dl class="row mt-4">
                        <dt class="col-sm-3">User Name</dt>
                        <dd class="col-sm-9">
                            <input type="text" name="user_name" class="form-control @error('user_name') is-invalid @enderror" value="{{ old('user_name', auth()->user()->user_name) }}">
                            @error('user_name')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </dd>

                        <dt class="col-sm-3">First Name</dt>
                        <dd class="col-sm-9">
                            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', auth()->user()->first_name) }}">
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </dd>
                        <dt class="col-sm-3">Last Name</dt>
                        <dd class="col-sm-9">
                            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', auth()->user()->last_name) }}">
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </dd>
                        <dt class="col-sm-3">Email</dt>
                        <dd class="col-sm-9">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </dd>
                        <dt class="col-sm-3">Phone</dt>
                        <dd class="col-sm-9">
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', auth()->user()->phone) }}">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </dd>
                        <dt class="col-sm-3">DOB</dt>
                        <dd class="col-sm-9 mb-4">
                            <input type="text" name="dob" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob', auth()->user()->dob) }}">
                            @error('dob')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </dd>
                        <span>(Password is optional)</span>
                        <dt class="col-sm-3">New Password</dt>
                        <dd class="col-sm-9">
                            <input type="text" name="new_password" class="form-control @error('new_password') is-invalid @enderror" value="{{ old('new_password') }}">
                            @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </dd>
                        <dt class="col-sm-3">Confirm Password</dt>
                        <dd class="col-sm-9">
                            <input type="text" name="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" value="{{ old('confirm_password') }}">
                            @error('confirm_password')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </dd>



                    </dl>

                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
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
