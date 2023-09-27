<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        th.no, td.no {
            background-color: #000;
            color: white;
        }
        th.date, td.date {
            min-width: 100px;
        }
        td.bg-gray {
            background-color: #f5f5f5;
        }
        td.total {
            font-weight: bold;
        }
        h4 {
            margin: 0;
            font-weight: bold;
        }
        .simpanan {
            min-width: 100px;
            max-width: 300px;
        }
    </style>
</head>
<body>
    <h1>Laporan Pembayaran</h1>
    <h3>Periode: {{Helper::dateIndo($tgl_awal)}} s/d {{Helper::dateIndo($tgl_akhir)}}</h3>
    <h3>Diexport oleh: {{Auth::guard('petugas')->user()->nama}}</h3>
    <h3>Tanggal Download: {{Helper::dateTimeIndo(date('Y-m-d H:i:s'))}}</h3>

    <table class="table table-bordered">
        <thead >
            <tr>
                <th class="no">No</th>
                <th class="date">Tanggal</th>
                @foreach ($daftarKategoriSimpanan as $ks)
                @php
                    $totalPerKategori['nominal_kategori_id_'.$ks->id_kategori] = 0;
                @endphp
                    <th class="simpanan">{{$ks->nama}}</th>
                @endforeach
                <th class="bg-gray">Jumlah Simpanan <i  class="fa fa-info-circle"
                    style="cursor: pointer"

                    data-toggle="tooltip" data-placement="top" title="Total Simpanan yang telah dibayar"></i></th>

                <th class="bg-gray">Pokok Piutang</th>
                <th class="bg-gray">Jasa Piutang</th>
                <th class="bg-gray">Total Piutang <i  class="fa fa-info-circle"
                    style="cursor: pointer"

                    data-toggle="tooltip" data-placement="top" title="Total Piutang yang telah dibayar"></i></th>

                <th class="bg-gray" colspan="2">Total Terbayar <i  class="fa fa-info-circle"
                    style="cursor: pointer"

                    data-toggle="tooltip" data-placement="top" title="Total Simpanan dan Piutang yang telah dibayar"></i></th>


            </tr>
        </thead>
        <tbody>
            @php
                $totalSimpanan = 0;
                $totalPokok = 0;
                $totalJasa = 0;
                $totalPiutang = 0;

            @endphp
            @forelse ($pembayaran as $trx)
            @php
                $total_simpanan = 0;
                $total_piutang = $trx->angsuran_bayar_pokok + $trx->angsuran_bayar_jasa;
                $totalPokok += $trx->angsuran_bayar_pokok;
                $totalJasa += $trx->angsuran_bayar_jasa;
                $totalPiutang += $total_piutang;

            @endphp
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$trx->tanggal}}</td>
                    @foreach ($daftarKategoriSimpanan as $k)
                        <td class="bg-gray simpanan">
                            {{-- nominal_kategori_id_ --}}
                           @php
                            $obj = 'nominal_kategori_id_'.$k->id_kategori;
                             echo  $trx->$obj;
                            $total_simpanan += $trx->$obj;
                            $totalPerKategori['nominal_kategori_id_'.$k->id_kategori] += $trx->$obj;
                            @endphp
                        </td>


                    @endforeach
                    <td class="bg-gray" style="background-color: #f5f5f5">
                        {{$total_simpanan}}
                    </td>
                    <td class="bg-gray">
                        {{$trx->angsuran_bayar_pokok}}
                    </td>
                    <td>
                        {{$trx->angsuran_bayar_jasa}}
                    </td>
                    <td class="bg-gray">
                        {{$total_piutang}}
                    </td>
                    <td class="bg-gray" colspan="2"  style="background-color: #f5f5f5">
                        {{$total_simpanan + $total_piutang}}
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="100%" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
        @if(count($pembayaran) > 0)
        <tfoot>
                <tr style="background-color: #f5f5f5" class="bg-gray">

                    <td colspan="2" class="text-center">Total</td>

                    @foreach ($daftarKategoriSimpanan as $k)
                    @php

                        $totalSimpanan += $totalPerKategori['nominal_kategori_id_'.$k->id_kategori];
                    @endphp
                        <td> {{$totalPerKategori['nominal_kategori_id_'.$k->id_kategori]}}</td>
                    @endforeach
                    <td> {{$totalSimpanan}}</td>
                    <td> {{$totalPokok}}</td>
                    <td> {{$totalJasa}}</td>
                    <td> {{$totalPiutang}}</td>
                    <td colspan="2">
                        <h4>

                            {{$totalSimpanan + $totalPiutang}}
                        </h4>
                    </td>

                </tr>
                <tr style="background-color: #f5f5f5" class="bg-gray">
                    <td colspan="3" class="text-center">Terbilang</td>
                    <td colspan="100%" class="text-center">
                        <h4>
                            {{ucwords(Helper::terbilangRupiah($totalSimpanan + $totalPiutang))}} Rupiah
                        </h4>
                    </td>
                </tr>
        </tfoot>
        @endif
    </table>
</body>
</html>
