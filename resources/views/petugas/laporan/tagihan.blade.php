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
    <div class="col-12 col-lg-3">
        <div class="form-group">
            <label class="col-form-label">Pilih Bulan</label>
            <br>
            <div class="input-group">
               <select class="custom-select select2" fdprocessedid="bq1eom" name="bulan" id="bulan">
                    <option selected disabled> -- Pilih -- </option>
                    @php
                        $daftarBulan =  Helper::listOfMonth();
                    @endphp
                    @foreach ($daftarBulan as $key => $value)
                        <option value="{{$key}}" @if($bulan == $key) selected @endif>{{$value}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-3">
        <div class="form-group">
            <label class="col-form-label">Tahun</label>
            <br>
            <div class="input-group">
                    <select class="custom-select select2" fdprocessedid="bq1eom" name="tahun" id="tahun">
                        <option selected disabled> -- Pilih -- </option>
                        @for($i = date('Y'); $i >= 1998; $i--)
                            <option value="{{$i}}" @if($tahun == $i) selected @endif>{{$i}}</option>
                        @endfor
                    </select>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-3">
        <div class="form-group">
            <label class="col-form-label">Pilih Sekolah</label>
            <br>
            <select class="custom-select select2" fdprocessedid="bq1eom" name="id_sekolah" id="id_sekolah">
                <option selected disabled> -- Pilih -- </option>
                <option value="all" @if($id_sekolah == 'all') selected @endif>Semua Sekolah</option>
                @foreach ($daftarSekolah as $ak)
                <option value="{{$ak->id_sekolah}}" @if($id_sekolah == $ak->id_sekolah) selected @endif>{{$ak->nama}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-lg-3">
        <label class="col-form-label">‎ </label>
        <button class="btn btn-primary btn-block" id="btn-cari">Cari Data <i class="fa fa-search"></i></button>
    </div>
    @if($bulan != null && $tahun != null && $id_sekolah != null)
    <div class="col-lg-12 mt-3">
        <a href="{{route('petugas.laporan.tagihan')}}?bulan={{$bulan}}&tahun={{$tahun}}&id_sekolah={{$id_sekolah}}&aksi=download" class="btn btn-success btn-block" target="_blank">Download Excel <i class="fa fa-file-excel"></i></a>
    </div>
    @endif
</div>
<div class="row">
    @if($bulan != null && $tahun != null && $id_sekolah != null)
        @foreach($sekolah as $s)
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card_title">
                        Data Tagihan Simpanan & Pinjaman
                    </h4>
                    <table class="table table-bordered">
                        <tr>
                            <td>Nama Sekolah</td>
                            <td>{{$s->nama}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Bulan: {{Helper::monthIndo(date('Y-'.$bulan))}}</td>

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
                                        <th class="text-right">Tgh Simpanan</th>
                                        <th class="text-right">Pokok Piutang</th>
                                        <th class="text-right">Angusuran</th>
                                        <th class="text-right">Jasa Piutang</th>
                                        <th class="text-right">Total Piutang</th>
                                        <th class="text-right">Total Tagihan</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($s->anggota as $a)
                                    @php
                                        $tagihanPinjaman = $a->tagihanPinjaman();
                                        $totalTagihan = 0;
                                    @endphp
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$a->nama}}</td>

                                            @foreach ($a->getTagihanSimpanan($bulan, $tahun) as $key => $value)

                                                @if($key =='total')
                                                    @php $totalTagihan += $value @endphp
                                                    <td class="text-right text-white
                                                        @if($value > 0)
                                                            bg-warning
                                                        @else
                                                            bg-success
                                                        @endif

                                                    ">{{Helper::numericToRupiah($value,0,',','.')}}</td>
                                                @else
                                                    <td class="text-right">{{Helper::numericToRupiah($value,0,',','.')}}</td>
                                                @endif
                                            @endforeach

                                            <td class="text-right">{{Helper::numericToRupiah($tagihanPinjaman['pokok'],0,',','.')}}</td>
                                            <td class="text-right">{{Helper::numericToRupiah($tagihanPinjaman['angsuran'],0,',','.')}}</td>
                                            <td class="text-right">{{Helper::numericToRupiah($tagihanPinjaman['jasa'],0,',','.')}}</td>
                                            <td class="text-right">{{Helper::numericToRupiah($tagihanPinjaman['total'],0,',','.')}}</td>
                                            <td class="text-right
                                                @if($totalTagihan + $tagihanPinjaman['total'] > 0)
                                                    bg-danger text-white
                                                @else
                                                    bg-success text-white
                                                @endif

                                            ">{{Helper::numericToRupiah($totalTagihan + $tagihanPinjaman['total'],0,',','.')}}</td>

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
    @else
        <div class="col-12">
            <div class="alert alert-info">
                <h4 class="text-center text-white">Silahkan pilih bulan, tahun dan sekolah terlebih dahulu !</h4>
            </div>
        </div>
    @endif
</div>
 @endsection
 @section('js')
    <script>

    </script>
@endsection
