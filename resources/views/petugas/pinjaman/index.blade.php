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
   <div class="col-lg-3">
         <div class="form-group">
            <label class="col-form-label">Tanggal Awal</label>
            <br>
            <input type="date" class="form-control" name="tgl_awal" value="{{old('tgl_awal')}}">
         </div>
   </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label class="col-form-label">Tanggal Akhir</label>
            <br>
            <input type="date" class="form-control" name="tgl_akhir" value="{{old('tgl_akhir')}}">

        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label class="col-form-label">Kata Kunci</label>
            <br>
            {{-- input with button --}}
            <div class="input-group">
                <input type="text" class="form-control" name="keyword" value="{{old('keyword')}}" placeholder="Cari berdasarkan kata kunci">
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
                        <table class="table table-hover progress-table">
                            <thead class="text-uppercase">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nomor</th>
                                    <th scope="col">Anggota</th>
                                    <th scope="col">Nominal</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($pinjaman as $p)
                                <tr>
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$p->id_pinjaman}}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name={{$p->anggota->nama}}" alt="" class="img-fluid rounded-circle" width="30">
                                            <div>
                                                <p class="d-inline-block ml-2 mb-0">{{$p->anggota->nama}}</p> 
                                            </div>
                                        </div>
                                        <span>Tergabung sejak {{$p->anggota->created_at->format('d M Y')}}</span>
                                    </td>
                                    <td>Rp. {{number_format($p->pokok)}}</td>
                                    <td>
                                        @if ($p->status == "Lunas")
                                            <span class="badge badge-success">Lunas</span>
                                        @else 
                                            <span class="badge badge-warning">{{$p->status}}</span>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
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

 @endsection
