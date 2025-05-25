<!-- resources/views/profile/edit.blade.php -->
<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="name" class="form-control" value="{{ auth()->user()->nama }}">
    </div>
    <div class="form-group">
        <label>Foto Profil</label><br>
        <input type="file" name="foto" class="form-control">
        @if (auth()->user()->foto)
            <img src="{{ asset('uploads/foto/' . auth()->user()->foto) }}" width="100" class="mt-2">
        @endif
    </div>
    <button type="submit" class="btn btn-primary">Update Profil</button>
</form>
