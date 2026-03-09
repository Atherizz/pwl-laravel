<!DOCTYPE html>
<html>
    <head>
        <title>Ubah User</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }
            .form-group {
                margin-bottom: 15px;
            }
            label {
                display: inline-block;
                width: 150px;
                font-weight: bold;
            }
            input[type="text"],
            input[type="password"],
            input[type="number"] {
                width: 300px;
                padding: 5px;
            }
            .btn {
                padding: 8px 15px;
                margin: 5px;
                text-decoration: none;
                display: inline-block;
                cursor: pointer;
            }
            .btn-ubah {
                background-color: #2196F3;
                color: white;
                border: none;
            }
            .btn-kembali {
                background-color: #808080;
                color: white;
            }
        </style>
    </head>
    <body>
        <h1>Ubah Data User</h1>
        <form action="{{ url('/user/ubah_simpan/' . $data->user_id) }}" method="post">
            @csrf
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" value="{{ $data->username }}" required>
            </div>
            <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="nama" value="{{ $data->nama }}" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Level ID:</label>
                <input type="number" name="level_id" value="{{ $data->level_id }}" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-ubah">Ubah</button>
                <a href="{{ url('/user') }}" class="btn btn-kembali">Kembali</a>
            </div>
        </form>
    </body>
</html>
