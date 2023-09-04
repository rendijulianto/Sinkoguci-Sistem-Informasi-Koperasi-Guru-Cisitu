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
<form class="row mb-4" method="GET" action="{{route('petugas.laporan.tagihan')}}">
    <div class="col-6">
        <div class="form-group">
            <label class="col-form-label">Pilih Bulan</label>
            <br>
            <div class="input-group">
                <input type="date" class="form-control" id="bulan" name="bulan" placeholder="Pilih Bulan" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="col-form-label">Pilih Sekolah</label>
            <br>
            <select class="custom-select select2" fdprocessedid="bq1eom" name="id_sekolah" id="id_sekolah">
                <option selected disabled> -- Pilih -- </option>
                @foreach ($daftarSekolah as $ak)
                <option value="{{$ak->id_sekolah}}">{{$ak->nama}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12">
        <button class="btn btn-primary btn-block" id="btn-cari">Cari Data <i class="fa fa-search"></i></button>
    </div>
</div>
<div class="row mb-4">
    <div class="col-12">
        <h4>Sekolah : {{$sekolah ? $sekolah->nama : 'Semua Sekolah'}}</h4>
        <h4>Bulan : {{$bulan ? date('F Y', strtotime($bulan)) : 'Semua Bulan'}}</h4>
    </div>
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card_title">
                    Data Tagihan Simpanan
                </h4>
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
                                    <th class="text-right">Tgh Simpanan</th>
                                    <th class="text-right">Pokok Piutang</th>
                                    <th class="text-right">Jasa Piutang</th>
                                    <th class="text-right">Total Piutang</th>
                                    <th class="text-right">Total Tagihan</th>
                                </tr>
                            </thead>
                            <tbody>
                               @if($sekolah != null)

                                @foreach ($anggota as $a)
                                @php 
                                    $tagihanPinjaman = $a->tagihanPinjaman();
                                    $totalTagihan = 0;
                                @endphp
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$a->nama}}</td>
                                        @foreach ($a->tagihanSimpanan('08') as $key => $value)
                                           
                                            @if($key =='total')
                                                @php $totalTagihan += $value @endphp
                                                <td class="text-right text-white
                                                    @if($value > 0)
                                                        bg-warning
                                                    @else
                                                        bg-success
                                                    @endif
                                                
                                                ">Rp {{number_format($value,0,',','.')}}</td>
                                            @else 
                                                <td class="text-right">Rp {{number_format($value,0,',','.')}}</td>
                                            @endif
                                        @endforeach
                                     
                                        <td class="text-right">Rp {{number_format($tagihanPinjaman['pokok'],0,',','.')}}</td>
                                        <td class="text-right">Rp {{number_format($tagihanPinjaman['jasa'],0,',','.')}}</td>
                                        <td class="text-right">Rp {{number_format($tagihanPinjaman['total'],0,',','.')}}</td>
                                        <td class="text-right
                                            @if($totalTagihan + $tagihanPinjaman['total'] > 0)
                                                bg-danger text-white
                                            @else
                                                bg-success text-white
                                            @endif
                                        
                                        ">Rp {{number_format($totalTagihan + $tagihanPinjaman['total'],0,',','.')}}</td>

                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                           
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 @endsection
 @section('js')
    <script>
       
    </script>
@endsection