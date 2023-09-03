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
<div class="row">
    <div class="col-12 mb-3">
        <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#modalTambahPenarikanSimpanan" style="float: right">
            <i class="fa fa-plus"></i> Tambah
        </button>
     </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                {{-- image lingkaran--}}
                <div class="text-center">
                    <h4  class="card_title mb-0">Sisa Saldo Dana Khusus</h4>
                    <h3 class="text-primary">Rp {{number_format($saldo_sekarang, 0, ',', '.')}}</h3>
                    <p class="text-muted">{{date('d M Y')}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
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
                                    <th rowspan="2" scope="col">No</th>
                                    <th rowspan="2" scope="col">Nominal</th>
                                    <th rowspan="2" >Keterangan</th>
                                    <th rowspan="2" >Tanggal Penarikan</th>
                                    <th rowspan="2" >Petugas</th>
                                    <td colspan="2" class="text-center">Saldo</td>
                                </tr>
                                <tr class="text-center">
                                    <th>Sebelum</th>
                                    <th>Sesudah</th>
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
                                        <td class="text-center">Rp {{number_format($p->saldo_sebelum, 0, ',', '.')}}</td>
                                        <td class="text-center">Rp {{number_format($p->saldo_sesudah, 0, ',', '.')}}</td>
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
                            <input type="number" class="form-control" autocomplete="off" id="jumlah" name="jumlah" placeholder="Jumlah Penarikan" value="{{old('jumlah')}}">
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

 @endsection
