<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekap Pinjaman</title>
</head>
<body>
    <h1>Rekap Pinjaman</h1>
    <table border="1">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Anggota</th>
                <th scope="col">Nomor Pinjaman</th>
                <th scope="col">Nominal Pinjaman</th>
                <th scope="col">Sisa Pokok</th>
                <th scope="col">Sisa Jasa</th>
                <th scope="col">Status</th>
                <th scope="col">Lama Angsuran</th>
                <th scope="col">Tanggal Pinjaman</th>
                <th scope="col">Petugas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pinjaman as $p)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$p->anggota->nama}}</td>
                <td>{{$p->id_pinjam}}</td>
                <td>{{$p->nominal}}</td>
                <td>{{$p->sisa_pokok}}</td>
                <td>{{$p->sisa_jasa}}</td>
                <td>{{$p->status}}</td>
                <td>{{$p->lama_angsuran}}</td>
                <td>{{$p->tgl_pinjam}}</td>
                <td>{{$p->petugas->nama}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
