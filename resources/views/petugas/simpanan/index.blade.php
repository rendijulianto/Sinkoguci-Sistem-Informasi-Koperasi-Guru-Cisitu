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
<div class="row mb-4">
    <div class="col-12">
        <div class="form-group">
            <label class="col-form-label">Pilih Anggota</label>
            <br>
            <select class="custom-select select2" fdprocessedid="bq1eom">
                <option selected="selected">-- Pilih Anggota -- </option>
                @foreach ($anggota as $ak)
                <option value="{{$ak->id}}">{{$ak->nama}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 mb-4">
        <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#modalTambahSimpanan">
            <i class="fa fa-plus"></i> Tambah
        </button>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">

            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-body">
                <h4 class="card_title">
                    Data Simpanan
                </h4>
                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table table-hover progress-table text-center">
                            <thead class="text-uppercase">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Bulan</th>
                                @foreach($kategoriSimpanan as $s)
                                    <th scope="col">{{$s->nama}}</th>
                                @endforeach
                                <th scope="col">Aksi</th>

                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Agustus 2023</td>
                                    @foreach($kategoriSimpanan as $s)
                                        <th scope="col">Rp {{number_format(rand(1,100000))}}</th>
                                    @endforeach
                                    <td>hapus</td>
                                </tr>

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
 <div class="modal fade" id="modalTambahSimpanan">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content tambah" action="{{route('petugas.simpanan.store')}}" method="post" autocomplete="off">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Simpanan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_anggota" value="1">
                <div class="row">
                    <div class="col-6">
                        <label for="simpanan_pokok">Simpanan Pokok</label>
                        <input type="number" class="form-control" autocomplete="off" id="simpanan_pokok" name="simpanan_pokok" placeholder="Simpanan Pokok" value="{{old('simpanan_pokok')}}">
                    </div>
                    <div class="col-6">
                        <label for="simpanan_wajib">Simpanan Wajib</label>
                        <input type="number" class="form-control" autocomplete="off" id="simpanan_wajib" name="simpanan_wajib" placeholder="Simpanan Wajib" value="{{old('simpanan_wajib')}}">
                    </div>
                    <div class="col-6">
                        <label for="simpanan_khusus">Simpanan Khusus</label>
                        <input type="number" class="form-control" autocomplete="off" id="simpanan_khusus" name="simpanan_khusus" placeholder="Simpanan Khusus" value="{{old('simpanan_khusus')}}">
                    </div>
                    <div class="col-6">
                        <label for="simpanan_hari_raya">Simpanan Hari Raya</label>
                        <input type="number" class="form-control" autocomplete="off" id="simpanan_hari_raya" name="simpanan_hari_raya" placeholder="Simpanan Hari Raya" value="{{old('simpanan_hari_raya')}}">
                    </div>
                    <div class="col-6">
                        <label for="dana_khusus">Dana Khusus</label>
                        <input type="number" class="form-control" autocomplete="off" id="dana_khusus" name="dana_khusus" placeholder="Dana Khusus" value="{{old('dana_khusus')}}">
                    </div>
                    <div class="col-6">
                        <label for="simpanan_suka_rela">Simpanan Suka Rela</label>
                        <input type="number" class="form-control" autocomplete="off" id="simpanan_suka_rela" name="simpanan_suka_rela" placeholder="Simpanan Suka Rela" value="{{old('simpanan_suka_rela')}}">
                    </div>
                    <div class="col-12">
                        <label for="simpanan_suka_rela">Total Bayar</label>
                        <input type="number" class="form-control" autocomplete="off" id="total_bayar">
                    </div>
                    <div class="col-6">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" name="keterangan" autocomplete="off"></textarea>
                    </div>
                    <div class="col-6">
                        <label for="tgl_bayar">Tanggal Bayar</label>
                        <input type="date" class="form-control" autocomplete="off" name="tgl_bayar" id="tgl_bayar">
                    </div>
                      {{-- Simpanan Pokok, Simpanan Wajib, Simpanan Khusus, Simpanan Hari Raya,
                         Dana Khusus, Simpanan Suka Rela, Total Bayar, Keterangan, Tanggal Bayar --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-light">Bersihkan</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
 <script>
 $(document).ready(function() {
     $('.select2').select2();
 });
 </script>
 @endsection
