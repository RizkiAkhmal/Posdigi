<!DOCTYPE html>
<html>
<head>
    <title>Tambah Kategori</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"] { width: 300px; padding: 8px; border: 1px solid #ddd; }
        .btn { padding: 8px 15px; margin: 5px; text-decoration: none; border: none; border-radius: 3px; cursor: pointer; }
        .btn-primary { background: #007bff; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .error { color: red; font-size: 14px; }
    </style>
</head>
<body>
    <h1>Tambah Kategori</h1>
    
    <form method="POST" action="{{ route('admin.kategori.store') }}">
        @csrf
        <div class="form-group">
            <label for="nama_kategori">Nama Kategori:</label>
            <input type="text" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}">
            @error('nama_kategori')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>