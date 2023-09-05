<!DOCTYPE html>
<html>
<head>
    <title>Simpanan Report</title>
</head>
<body>
    <h3>Simpanan Anggota</h3>
    <table border="1">
       <tr>
            <td>Nama</td>
            <td>{{$anggota->nama}}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>{{$anggota->alamat}}</td>
        </tr>
        <tr>
            <td>No. Anggota</td>
            <td>{{$anggota->id_anggota}}</td>
        </tr>
        <tr>
            <td>Tanggal </td>
            <td>Keterangan</td>
            @foreach($kategoriSimpanan as $s)
                <td>{{ ucwords(str_replace('_', ' ', $s->nama)) }}</td>
            @endforeach
            <td>Jumlah</td>
        </tr>

        @foreach ($anggota->simpananHari(date('Y')) as $s)
        <tr>
            <td>{{$s['tgl_bayar']}}</td>
            @foreach($s['simpanan'] as  $key => $value)
                <td>{{$value}}</td>
            @endforeach
        </tr>
        @endforeach
    </table>
    <h3>Detail Simpanan</h3>
    <table border="1">
        <tr>
            <td>Tanggal </td>
            <td>Keterangan</td>
            <td>Jenis Simpanan</td>
            <td>Jumlah</td>
            <td>Paraf Petugas</td>
        </tr>

         @foreach ($anggota->simpanan()->whereHas('kategori', function($q){
            $q->where('nama','like','simpanan%');
        })->whereYear('tgl_bayar', date('Y'))
         ->get() as $s)
         <tr>
             <td>{{$s->tgl_bayar}}</td>
                <td>{{$s->keterangan}}</td>
                <td>{{$s->kategori->nama}}</td>
                <td>{{$s->jumlah}}</td>
                <td>{{$s->petugas->nama}}</td>
         </tr>
         @endforeach
     </table>
</body>
</html>
