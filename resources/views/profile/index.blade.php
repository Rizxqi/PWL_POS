@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <h5><i class="icon fas fa-check"></i> Berhasil</h5>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan</h5>
                    {{ session('error') }}
                </div>
            @endif

            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{ asset($user->photo ?? 'dist/img/default-user.png') }}" alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ $user->nama ?? 'Nama User' }}</h3>
                    <p class="text-muted text-center">{{ $user->role ?? 'Role User' }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        {{-- <li class="list-group-item">
                            <b>Email</b> <a class="float-right">{{ $user->email ?? '-' }}</a>
                        </li> --}}
                        <li class="list-group-item">
                            <b>Username</b> <a class="float-right">{{ $user->username ?? '-' }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Registered</b>
                            <a class="float-right">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</a>
                        </li>
                    </ul>

                    {{-- <a href="{{ route('profile.edit', $user->id ?? '#') }}" class="btn btn-primary btn-block"><b>Edit
                            Profile</b></a> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
