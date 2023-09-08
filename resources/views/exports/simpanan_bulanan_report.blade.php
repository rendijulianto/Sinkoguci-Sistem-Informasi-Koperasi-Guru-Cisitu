<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Rekap Simpanan {{$bulan}} {{$tahun}}</title>
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
                        <div class="signle-table">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            @foreach ($daftarKategoriSimpanan as $ks)
                                                <th class="text-right">{{$ks->nama}}</th>
                                            @endforeach
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        @foreach ($s->anggota as $a)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$a->nama}}</td>
                                                @foreach ($a->terbayarSimpanan($tahun,$bulan) as $key => $value)
                                                        <td class="text-right">{{$value}}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</body>
</html>
