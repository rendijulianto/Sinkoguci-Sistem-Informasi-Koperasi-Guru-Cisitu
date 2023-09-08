<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pembayaran</title>
</head>
<body>
    <h3>LAPORAN PEMBAYARAN BULAN {{$bulan}} TAHUN {{$tahun}}</h3>
    <p>Tanggal Cetak: {{date('d-m-Y H:i:s')}}</p>
    @foreach($sekolah as $s)
    <table border="1">
        <tr>
            <th colspan="2">Sekolah</th>
            <td colspan="2">{{$s->nama}}</td>
        </tr>
    </table>

    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama</th>
            @foreach ($daftarKategoriSimpanan as $ks)
                <th>{{$ks->nama}}</th>
            @endforeach
            <th>Tgh Simpanan</th>
            <th>Pokok Piutang</th>
            <th>Jasa Piutang</th>
            <th>Total Piutang</th>
            <th>Total Tagihan</th>
        </tr>
        @foreach ($s->anggota as $a)
        @php
            $terbayarPinjaman = $a->terbayarPinjaman($tahun, $bulan);
            $totalTerbayar = 0;
        @endphp
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$a->nama}}</td>

            @foreach ($a->terbayarSimpanan($tahun, $bulan) as $key => $value)

                <td>{{$value}}</td>
            @endforeach
            <td>{{$terbayarPinjaman['pokok']}}</td>
            <td>{{$terbayarPinjaman['jasa']}}</td>
            <td>{{$terbayarPinjaman['total']}}</td>
            <td>{{$totalTerbayar + $terbayarPinjaman['total']}}</td>
        </tr>
        @endforeach
    </table>
    {{-- jarak antar table --}}
    <br>

    @endforeach

</body>
</html>
