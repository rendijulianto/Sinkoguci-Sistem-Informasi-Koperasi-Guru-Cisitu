@extends('layouts.app')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('content')
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                <h5 class="mr-4 font-weight-bold">{{$title}}</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-plus"></i> Pengajuan Pinjaman
            </div>
            <form class="card-body" action="{{route('petugas.pinjaman.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <label for="nomor_pinjaman">Nomor Pinjaman</label>
                        <input type="number" class="form-control" value="{{$id_pinjam}}" readonly>
                    </div>
                    {{-- anggota --}}
                    <div class="col-12">
                        <label for="id_anggota">Anggota</label>
                        <select name="id_anggota" id="id_anggota" class="form-control select2">
                            <option value="">-- Pilih Anggota --</option>
                            @foreach ($anggota as $item)
                                <option value="{{$item->id_anggota}}">{{$item->nama}} - {{$item->sekolah->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- nominal --}}
                    <div class="col-12">
                        <label for="nominal">Nominal</label>
                        <input type="number" class="form-control" name="nominal" id="nominal" value="{{old('nominal')}}" placeholder="Nominal">
                    </div>
                    {{-- jangk waktu --}}
                    <div class="col-12">
                        <label for="lama_angsuran">Jangka Waktu</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="lama_angsuran" id="lama_angsuran" value="{{old('lama_angsuran')}}" placeholder="Jangka Waktu">
                            <div class="input-group-append">
                                <span class="input-group-text">Bulan</span>
                            </div>
                        </div>
                    </div>
                    {{-- perangsuran --}}
                    <div class="col-12">
                        <label for="perangsuran">Perangsuran</label>
                        <input type="text" readonly  class="form-control" name="perangsuran" id="perangsuran" value="{{old('perangsuran')}}" placeholder="Perangsuran">
                    </div>
                    <div class="col-12">
                        <label for="tgl_pinjam">Tanggal Pinjam</label>
                        <input type="date" class="form-control" name="tgl_pinjam" id="tgl_pinjam" value="{{old('tgl_pinjam') ?? date('Y-m-d')}}" placeholder="Tanggal Pinjam">
                    </div>
                    {{-- button --}}
                    <div class="col-12 mt-4">
                        <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Simpan</button>
                        <a href="{{route('petugas.pinjaman.index')}}" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-4">
       <div class="card">
            <div class="card-header">
                <i class="fa fa-info-circle"></i> Informasi
            </div>
            <div class="card-body">
                <p>Untuk melakukan pengajuan pinjaman, silahkan isi form dibawah ini.</p>
            </div>
       </div>
    </div>
</div>
@endsection
@section('js')

    <script>
       
        $(document).ready(function(){
            $('.select2').select2();
            // jika nominal atau jangka waktu berubah
            $('#nominal, #lama_angsuran').on('keyup', function(){
                // ambil nilai nominal
                var nominal = $('#nominal').val();
                // ambil nilai jangka waktu
                var lama_angsuran = $('#lama_angsuran').val();
                // hitung perangsuran
                var perangsuran = nominal / lama_angsuran;
                // tampilkan perangsuran
                $('#perangsuran').val('Rp. ' + new Intl.NumberFormat(['ban', 'id']).format(perangsuran));
            });
        });
    </script>
@endsection
