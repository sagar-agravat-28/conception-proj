@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Your Profile</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- success message -->
        <div class="col-10 col-sm-3 col-xxl-2" style="position: fixed; top: 60px; right: 10px; z-index: 1050; width: 100%;">
            <div class="alert alert-success alert-dismissible fade" style="margin: 0; padding: 10px;">
                {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
                <p class="alert-success-msg">

                </p>
            </div>
        </div>
        <!-- /success message -->

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf


            <div class="mb-3">
                <label class="form-label">Profile Image</label>
                <x-image-upload :has-data="Auth::user()" name="avatar" route="profile.store.avatar" class="tile tile-xl" />

                @if ($errors->has('avatar'))
                    <small class="text-danger">{{ $errors->first('avatar') }}</small>
                @endif
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                    @if ($errors->has('name'))
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                    @if ($errors->has('email'))
                        <small class="text-danger">{{ $errors->first('email') }}</small>
                    @endif
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>

    </div>
@endsection
