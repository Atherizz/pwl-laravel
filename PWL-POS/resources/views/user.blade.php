<!DOCTYPE html>
<html>
    <head>
        <title>Data User</title>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }
            th, td {
                border: 1px solid black;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            .btn {
                padding: 5px 10px;
                text-decoration: none;
                margin: 2px;
                display: inline-block;
            }
            .btn-tambah {
                background-color: #4CAF50;
                color: white;
            }
            .btn-ubah {
                background-color: #2196F3;
                color: white;
            }
            .btn-hapus {
                background-color: #f44336;
                color: white;
            }
        </style>
    </head>
    <body>
        <h1>Data User</h1>
        <a href="{{ url('/user/tambah') }}" class="btn btn-tambah">+ Tambah User</a>
        <br><br>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Level Pengguna</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr>
                    <td>{{ $d->user_id }}</td>
                    <td>{{ $d->username }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>{{ $d->level->level_nama }}</td>
                    <td>
                        <a href="{{ url('/user/ubah/' . $d->user_id) }}" class="btn btn-ubah">Ubah</a>
                        <a href="{{ url('/user/hapus/' . $d->user_id) }}" class="btn btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
