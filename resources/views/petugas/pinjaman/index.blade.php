@extends('layouts.app')

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
<form class="row mb-4">
   <div class="col-lg-2">
         <div class="form-group">
            <label class="col-form-label">Tanggal Awal</label>
            <br>
            <input type="date" class="form-control" name="tanggal_awal" value="{{$tanggal_awal}}">
         </div>
   </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label class="col-form-label">Tanggal Akhir</label>
            <br>
            <input type="date" class="form-control" name="tanggal_akhir" value="{{$tanggal_akhir}}">

        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label class="col-form-label">Status</label>
            <br>
            <select class="custom-select select2" fdprocessedid="bq1eom" name="status" id="status">
                <option value="all" @if($status == 'all') selected @endif>Semua</option>
                <option value="lunas" @if($status == 'lunas') selected @endif>Lunas</option>
                <option value="belum_lunas" @if($status == 'belum_lunas') selected @endif>Belum Lunas</option>
            </select>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="form-group">
            <label class="col-form-label">Kata Kunci</label>
            <br>
            {{-- input with button --}}
            <div class="input-group">
                <input type="text" class="form-control" name="cari" value="{{$cari}}" placeholder="Cari berdasarkan kata kunci">
                <div class="input-group-append">
                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <a href="{{route('petugas.pinjaman.create')}}" class="btn btn-sm btn-primary"
        style="float: right;"
        ><i class="fa fa-plus"></i> Pengajuan</a>
    </div>
</form>
<div class="row">
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card_title">
                    {{$title}}
                </h4>
                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table table-hover progress-table table-striped table-bordered">
                            <thead class="text-uppercase bg-primary">
                                <tr>
                                    <th rowspan="2" scope="col">Nomor</th>
                                    <th rowspan="2" scope="col">Anggota</th>
                                    <th class="text-right" rowspan="2" scope="col">Nominal</th>
                                    <th colspan="2" scope="col" class="text-center">Sisa</th>
                                    <th rowspan="2" scope="col">Status</th>
                                    <th rowspan="2" scope="col">Lama Angsuran</th>
                                    <th rowspan="2" scope="col">Tgl Pinjaman</th>
                                    <th rowspan="2" scope="col">Petugas Penerima</th>
                                    <th rowspan="2" scope="col">Aksi</th>
                                </tr>
                                <tr class="text-center">
                                    <th class="text-right" scope="col">Pokok</th>
                                    <th class="text-right" scope="col">Jasa</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($pinjaman as $p)
                            <tr>
                                <td>{{$p->id_pinjaman}}</td>
                                <td>
                                    <p class="mt-0">
                                        {{$p->anggota->nama}} <br>
                                        <small>{{$p->anggota->alamat}}</small> <br>
                                        <small>Tgl Lahir: {{Helper::dateIndo($p->anggota->tgl_lahir)}}</small><br>
                                        <small>Sekolah: {{$p->anggota->sekolah->nama}}</small><br>
                                        <small>Tergabung sejak {{Helper::dateTimeIndo($p->anggota->created_at)}}</small>
                                    </p>
                                </td>
                                <td class="text-right">{{Helper::numericToRupiah($p->nominal, 0, ',', '.')}}</td>
                                <td class="text-right">{{Helper::numericToRupiah($p->sisa_pokok, 0, ',', '.')}}</td>
                                <td class="text-right">{{Helper::numericToRupiah($p->sisa_jasa, 0, ',', '.')}}</td>

                                <td>
                                    @if ($p->sisa_pokok == 0 && $p->sisa_jasa == 0)
                                    <span class="badge badge-success">Lunas</span>
                                    @else
                                    <span class="badge badge-warning text-white">Belum Lunas</span>
                                    @endif
                                </td>
                                <td>{{$p->lama_angsuran}} Bulan</td>
                                <td>{{Carbon\Carbon::parse($p->tgl_pinjam)->translatedFormat('d F Y')}}</td>
                                <td> {{$p->petugas->nama}}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center"
                                    style="gap: 10px">


                                    @if ($p->sisa_pokok > 0 OR $p->sisa_jasa > 0)
                                    <a href="{{route('petugas.angsuran.index')}}?pinjaman={{$p->id_pinjaman}}" class="btn btn-xs btn-primary"><i class="fa fa-money-bill"></i> Bayar Angsuran</a>
                                    @endif
                                    <a href="{{route('petugas.angsuran.show', $p->id_pinjaman)}}?aksi=download" class="btn btn-xs btn-success"><i class="fa fa-file-excel"></i> Download Angsuran</a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $pinjaman->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

 @endsection
 @section('js')

 @endsection
