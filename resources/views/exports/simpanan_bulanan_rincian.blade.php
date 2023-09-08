<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data rincian Simpanan {{$bulan}} {{$tahun}}</title>
</head>
<body>
    <div class="row mb-4">
        @if($bulan != null && $tahun != null)
            @foreach($sekolah as $s)
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card_title">
                            Data Simpanan
                        </h4>
                        <table class="table table-bordered">
                            <tr>
                                <td>Nama Sekolah</td>
                                <td>{{$s->nama}}</td>
                            </tr>
                            <tr>
                                <td>Bulan: {{date('F', mktime(0, 0, 0, $bulan, 1))}} </td>
                                <td>Tahun: {{$tahun}}</td>
                            </tr>
                        </table>

                        @foreach ($s->anggota as $a)
                        <h3>Detail Simpanan</h3>
                        <table class="table table-bordered">
                            <tr>
                                <td>Nama Anggota</td>
                                <td>{{$a->nama}}</td>
                            </tr>
                            <tr>
                                <td>ID Anggota</td>
                                <td>{{$a->id_anggota}}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Lahir</td>
                                <td>{{$a->tgl_lahir}}</td>
                            </tr>
                        </table>
                        <table border="1">
                            <tr>
                                <td>Tanggal </td>
                                <td>Keterangan</td>
                                <td>Jenis Simpanan</td>
                                <td>Jumlah</td>
                                <td>Paraf Petugas</td>
                            </tr>

                             @foreach ($a->simpanan()->whereYear('tgl_bayar',$tahun)->whereMonth('tgl_bayar',$bulan)
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
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</body>
</html>
