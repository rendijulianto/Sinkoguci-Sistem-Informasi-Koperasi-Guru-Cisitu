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
                                        <small>Tgl Lahir: {{$p->anggota->tgl_lahir}}</small><br>
                                        <small>Sekolah: {{$p->anggota->sekolah->nama}}</small><br>
                                        <small>Tergabung sejak {{$p->anggota->created_at->format('d M Y')}}</small> <br>
                                    </p>
                                </td>
                                <td class="text-right">Rp. {{number_format($p->nominal, 0, ',', '.')}}</td>
                                <td class="text-right">Rp. {{number_format($p->sisa_pokok, 0, ',', '.')}}</td>
                                <td class="text-right">Rp. {{number_format($p->sisa_jasa, 0, ',', '.')}}</td>

                                <td>
                                    @if ($p->sisa_pokok == 0 && $p->sisa_jasa == 0)
                                        <span class="badge badge-success">Lunas</span>
                                    @else
                                        <span class="badge badge-warning text-white">Belum Lunas</span>
                                    @endif
                                </td>
                                <td>{{$p->lama_angsuran}} Bulan</td>
                                <td>{{$p->tgl_pinjam}}</td>
                                <td>
                                    @if ($p->sisa_pokok > 0 && $p->sisa_jasa > 0)
                                    <a href="{{route('petugas.cicilan.index')}}?pinjaman={{$p->id_pinjaman}}" class="btn btn-xs btn-primary"><i class="fa fa-money-bill"></i> Bayar Cicilan</a>
                                    @endif
                                    <a href="{{route('petugas.cicilan.show', $p->id_pinjaman)}}?aksi=download" class="btn btn-xs btn-success"><i class="fa fa-file-excel"></i> Download</a>
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
