<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rincian Pinjaman</title>
</head>
<body>
   @foreach($pinjaman as $p)
   <table border="1">
        <thead>
            <tr>
                <th colspan="2">Rincian Pinjaman</th>
            </tr>
        </thead>
        <tr>
            <td>Nomor Pinjaman</td>
            <td>{{$p->id_pinjaman}}</td>
        </tr>
        <tr>
            <td>Nama Anggota</td>
            <td>{{$p->anggota->nama}}</td>
        </tr>
        <tr>
            <td>Nominal Pinjaman</td>
            <td>{{$p->nominal}}</td>
        </tr>
        <tr>
            <td>Sisa Pokok</td>
            <td>{{$p->sisa_pokok}}</td>
        </tr>
        <tr>
            <td>Sisa Jasa</td>
            <td>{{$p->sisa_jasa}}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>{{$p->status}}</td>
        </tr>
        <tr>
            <td>Lama Angsuran</td>
            <td>{{$p->lama_angsuran}}</td>
        </tr>
        <tr>
            <td>Tanggal Pinjaman</td>
            <td>{{$p->tgl_pinjam}}</td>
        </tr>
    </table>
    <br>
    <h1>Angsuran</h1>
    <table border="1">
        <thead>
            <tr>
                <th rowspan="2" scope="col">No</th>
                <th rowspan="2" scope="col">Tgl Bayar</th>
                <th colspan="2">Tagihan</th>
                <th colspan="2">Pembayaran</th>
                <th colspan="2" scope="col">Sisa</th>
                <th rowspan="2" scope="col">Petugas</th>
            </tr>
            <tr>
                <th scope="col">Pokok</th>
                <th scope="col">Jasa</th>
                <th scope="col">Pokok</th>
                <th scope="col">Jasa</th>
                <th scope="col">Pokok</th>
                <th scope="col">Jasa</th>
            </tr>
        </thead>
        @php
            $total_bayar_pokok = 0;
            $total_bayar_jasa = 0;
        @endphp
        <tbody>
            @foreach($p->angsuran()->orderBy('tgl_bayar', 'asc')->get() as $key => $c)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$c->tgl_bayar}}</td>
                <td>{{$c->sebelum_pokok <= $c->pinjaman->nominal ? $c->sebelum_pokok : $c->pinjaman->nominal / $c->pinjaman->lama_angsuran}}</td>
                <td>{{$c->sebelum_jasa}}</td>
                <td>{{$c->bayar_pokok}}</td>
                <td>{{$c->bayar_jasa}}</td>
                <td>{{$c->setelah_pokok}}</td>
                <td>{{$c->setelah_jasa}}</td>
                <td>{{$c->petugas->nama}}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4">Total</td>
                <td>{{$total_bayar_pokok}}</td>
                <td>{{$total_bayar_jasa}}</td>
                <td colspan="3"></td>
            </tr>
        </tbody>
    </table>
   @endforeach
</body>
</html>
