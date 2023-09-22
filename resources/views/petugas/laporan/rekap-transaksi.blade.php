@extends('layouts.app')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('content')
<div class="row mb-4">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                <h5 class="mr-4 mb-0 font-weight-bold">{{$title}}</h5>
            </div>
        </div>
    </div>
</div>
<form class="row mb-4" method="GET" action="{{route('petugas.laporan.rekap-transaksi')}}">
    <div class="col-3">
        <div class="form-group">
            <label class="col-form-label">Pilih Tanggal Awal</label>
            <br>
            <div class="input-group">
                <input type="date" class="form-control" name="tgl_awal" id="tgl_awal" value="{{$tgl_awal}}">
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="col-form-label">Pilih Tanggal Akhir</label>
            <br>
            <div class="input-group">
                <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir" value="{{$tgl_akhir}}">
            </div>
        </div>
    </div>
    <div class="col-6">
        <label class="col-form-label">Button </label>
        <button class="btn btn-primary btn-block" id="btn-cari">Cari Data <i class="fa fa-search"></i></button>
    </div>

</div>
<div class="row mb-4">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card_title">
                    Rekap Transaksi Tanggal {{$tgl_awal}} s/d {{$tgl_akhir}}
                </h4>
                <div class="signle-table">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-primary">
                                <tr>
                                    <th>No</th>
                                    <th style="min-width: 100px">Tanggal</th>
                                    @foreach ($daftarKategoriSimpanan as $ks)
                                    @php
                                        $totalPerKategori['nominal_kategori_id_'.$ks->id_kategori] = 0;
                                    @endphp
                                        <th class="text-right">{{$ks->nama}}</th>
                                    @endforeach
                                    <th class="text-right">Jumlah Simpanan <i  class="fa fa-info-circle"
                                        style="cursor: pointer"

                                        data-toggle="tooltip" data-placement="top" title="Total Simpanan yang telah dibayar"></i></th>

                                    <th class="text-right">Pokok Piutang</th>
                                    <th class="text-right">Jasa Piutang</th>
                                    <th class="text-right">Total Piutang <i  class="fa fa-info-circle"
                                        style="cursor: pointer"

                                        data-toggle="tooltip" data-placement="top" title="Total Piutang yang telah dibayar"></i></th>

                                    <th class="text-right" colspan="2">Total Terbayar <i  class="fa fa-info-circle"
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
                                    function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}
		return $temp;
	}
                                @endphp
                                @forelse ($transaksi as $trx)
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
                                            <td class="text-right">
                                                {{-- nominal_kategori_id_ --}}
                                               @php
                                                $obj = 'nominal_kategori_id_'.$k->id_kategori;
                                                echo 'Rp '.number_format($trx->$obj, 2, ',', '.');
                                                $total_simpanan += $trx->$obj;
                                                $totalPerKategori['nominal_kategori_id_'.$k->id_kategori] += $trx->$obj;
                                                @endphp
                                            </td>


                                        @endforeach
                                        <td class="text-right" style="background-color: #f5f5f5">
                                            Rp {{number_format($total_simpanan, 2, ',', '.')}}
                                        </td>
                                        <td class="text-right">
                                            Rp {{number_format($trx->angsuran_bayar_pokok, 2, ',', '.')}}
                                        </td>
                                        <td>
                                            Rp {{number_format($trx->angsuran_bayar_jasa, 2, ',', '.')}}
                                        </td>
                                        <td class="text-right">
                                            Rp {{number_format($total_piutang, 2, ',', '.')}}
                                        </td>
                                        <td class="text-right" colspan="2"  style="background-color: #f5f5f5">
                                            Rp {{number_format($total_simpanan + $total_piutang, 2, ',', '.')}}
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if(count($transaksi) > 0)
                            <tfoot>
                                    <tr style="background-color: #f5f5f5" class="text-right">

                                        <td colspan="2" class="text-center">Total</td>

                                        @foreach ($daftarKategoriSimpanan as $k)
                                        @php

                                            $totalSimpanan += $totalPerKategori['nominal_kategori_id_'.$k->id_kategori];
                                        @endphp
                                            <td> Rp {{number_format($totalPerKategori['nominal_kategori_id_'.$k->id_kategori], 2, ',', '.')}}</td>
                                        @endforeach
                                        <td> Rp {{number_format($totalSimpanan, 2, ',', '.')}}</td>
                                        <td> Rp {{number_format($totalPokok, 2, ',', '.')}}</td>
                                        <td> Rp {{number_format($totalJasa, 2, ',', '.')}}</td>
                                        <td> Rp {{number_format($totalPiutang, 2, ',', '.')}}</td>
                                        <td colspan="2">
                                            <h4>

                                                Rp {{number_format($totalSimpanan + $totalPiutang, 2, ',', '.')}}
                                            </h4>
                                        </td>

                                    </tr>
                                    <tr style="background-color: #f5f5f5" class="text-right">
                                        <td colspan="3" class="text-center">Terbilang</td>
                                        <td colspan="100%" class="text-center">
                                            <h4>
                                                {{ucwords(penyebut($totalSimpanan + $totalPiutang))}} Rupiah
                                            </h4>
                                        </td>
                                    </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 @endsection
 @section('js')

@endsection
