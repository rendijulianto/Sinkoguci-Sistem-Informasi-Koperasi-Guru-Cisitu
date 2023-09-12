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
<form class="row mb-4">
    <div class="col-lg-3">
          <div class="form-group">
             <label class="col-form-label">Tanggal Awal</label>
             <br>
             <input type="date" class="form-control" name="tanggal_awal" value="{{$tanggal_awal}}">
          </div>
    </div>
     <div class="col-lg-3">
         <div class="form-group">
             <label class="col-form-label">Tanggal Akhir</label>
             <br>
             <input type="date" class="form-control" name="tanggal_akhir" value="{{$tanggal_akhir}}">

         </div>
     </div>
     <div class="col-lg-6">
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
        <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#modalTambahPenarikanSimpanan" style="float: right">
            <i class="fa fa-plus"></i> Tambah
        </button>
     </div>
 </form>
<div class="row">
    <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card_title">
                        Data Penarikan Simpanan
                    </h4>
                    <div class="single-table">
                        <div class="table-responsive">
                            <table class="table table-hover progress-table">
                                <thead class="text-uppercase bg-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nominal</th>
                                    <th >Keterangan</th>
                                    <th >Tanggal Penarikan</th>
                                    <th >Petugas</th>

                                </tr>

                                </thead>
                                <tbody>
                                    @forelse($penarikan as $p)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>Rp {{number_format($p->jumlah, 0, ',', '.')}}</td>
                                        <td>{{$p->keterangan}}</td>
                                        <td>{{$p->tgl_penarikan}}</td>
                                        <td>{{$p->petugas->nama}}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="modal fade" id="modalTambahPenarikanSimpanan">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form class="modal-content tambah" action="{{route('petugas.penarikan.store-dana-sosial')}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Penarikan Simpanan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-6">
                            <label for="jumlah">Jumlah Penarikan</label>
                            <input type="text" class="form-control autonumeric-currency" autocomplete="off" id="jumlah" name="jumlah" placeholder="Jumlah Penarikan" value="{{old('jumlah')}}">
                        </div>
                        <div class="col-6">
                            <label for="tgl_penarikan">Tanggal Penarikan</label>
                            <input type="date" class="form-control" autocomplete="off" name="tgl_penarikan" id="tgl_penarikan" value="{{old('tgl_penarikan') ?? date('Y-m-d')}}">
                        </div>
                        <div class="col-12">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan" autocomplete="off" id="keterangan" cols="30" rows="5" placeholder="Keterangan">{{old('keterangan')}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-light">Bersihkan</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
 @endsection
 @section('js')
 <script>

    $(".autonumeric-currency").autoNumeric("init", { mDec: "0", aSep: ".", aDec: ",", aSign: "Rp " });
    </script>
 @endsection
