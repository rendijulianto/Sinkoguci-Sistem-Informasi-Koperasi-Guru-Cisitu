<!DOCTYPE html>
<html>
<head>
    <title>Pinjaman cicilan</title>
</head>
<body>
    <h3>Pinjaman cicilan</h3>
    <h5>Tanggal Pinjaman : {{$pinjaman->tgl_pinjam}}</h5>
    <h5>Peminjam :</h5>
    <b>Nama : {{$pinjaman->anggota->nama}}</b><br>
    <b>Alamat : {{$pinjaman->anggota->alamat}}</b><br>
    <b>Tanggal Lahir : {{$pinjaman->anggota->tgl_lahir}}</b><br>
    <b>Sekolah : {{$pinjaman->anggota->sekolah->nama}}</b><br>
    <table border="1">
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
        @php
            $total_bayar_pokok = 0;
            $total_bayar_jasa = 0;
        @endphp
        @foreach($pinjaman->angsuran()->orderBy('tgl_bayar', 'asc')->get() as $key => $c)
            @php
                $total_bayar_pokok += $c->bayar_pokok;
                $total_bayar_jasa += $c->bayar_jasa;
            @endphp
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
    </table>
</body>
</html>
