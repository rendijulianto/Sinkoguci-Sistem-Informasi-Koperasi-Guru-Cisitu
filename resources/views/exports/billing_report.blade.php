<!DOCTYPE html>
<html>
<head>
    <title>Billing Report</title>
</head>
<body>
    <h3>TAGIHAN BULAN {{$bulan}} TAHUN {{$tahun}}</h3>
    @foreach($sekolah as $s)
    <h3>Sekolah: {{ $s->nama }}</h3>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama</th>
            @foreach ($daftarKategoriSimpanan as $ks)
                <th class="text-right">{{$ks->nama}}</th>
            @endforeach
            <th class="text-right">Tgh Simpanan</th>
            <th class="text-right">Pokok Piutang</th>
            <th class="text-right">Jasa Piutang</th>
            <th class="text-right">Total Piutang</th>
            <th class="text-right">Total Tagihan</th>
        </tr>
        @foreach ($s->anggota as $a)
        @php
            $tagihanPinjaman = $a->tagihanPinjaman();
            $totalTagihan = 0;
        @endphp
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$a->nama}}</td>

                @foreach ($a->tagihanSimpanan($bulan, $tahun) as $key => $value)

                    @if($key =='total')
                        @php $totalTagihan += $value @endphp
                        <td class="text-right text-white
                            @if($value > 0)
                                bg-warning
                            @else
                                bg-success
                            @endif

                        ">{{$value}}</td>
                    @else
                        <td class="text-right">{{$value}}</td>
                    @endif
                @endforeach

                <td class="text-right">{{$tagihanPinjaman['pokok']}}</td>
                <td class="text-right">{{$tagihanPinjaman['jasa']}}</td>
                <td class="text-right">{{$tagihanPinjaman['total']}}</td>
                <td class="text-right
                    @if($totalTagihan + $tagihanPinjaman['total'] > 0)
                        bg-danger text-white
                    @else
                        bg-success text-white
                    @endif

                ">{{$totalTagihan + $tagihanPinjaman['total']}}</td>

            </tr>
        @endforeach
    </table>
    @endforeach
</body>
</html>
