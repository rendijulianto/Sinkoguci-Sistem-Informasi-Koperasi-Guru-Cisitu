@extends('layouts.app')
@section('content')
<div class="row mb-4">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                <h5 class="mr-4 mb-0 font-weight-bold">{{$title}} </h5>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Tambah Anggota Button -->
    <div class="col-12">
        <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#modalTambahAnggota">
            <i class="fa fa-plus"></i> Tambah Anggota
        </button>
    </div>
    <!-- Daftar Anggota Table -->
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card_title">
                    {{$title}}
                </h4>
                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table table-hover progress-table text-center">
                            <thead class="text-uppercase">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Tanggal Lahir</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Sekolah</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($anggota as $item)
                                <tr>
                                    <th scope="row">{{$item->id_anggota}}</th>
                                    <td>{{$item->nama}}</td>
                                    <td>{{$item->tgl_lahir}}</td>
                                    <td>{{$item->alamat}}</td>
                                    <td>{{$item->sekolah->nama}}</td>
                                    <td>
                                        <ul class="d-flex justify-content-center">
                                            <li class="mr-3">
                                            <button type="button" class="btn btn-inverse-primary edit-button" data-toggle="modal" data-target="#modalEditAnggota{{$item->id_anggota}}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            </li>
                                            <li>
                                                <form  action="{{ route('petugas.anggota.destroy', $item->id_anggota) }}" method="post" class="hapus">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-inverse-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
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
<!-- Modal Tambah Anggota -->
<div class="modal fade" id="modalTambahAnggota">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content tambah" action="{{route('petugas.anggota.store')}}" method="post" autocomplete="off">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Anggota</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" autocomplete="off" id="nama" name="nama" placeholder="Nama" value="{{old('nama')}}">
                    </div>
                    <div class="col-6">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" autocomplete="off" id="tgl_lahir" name="tgl_lahir" value="{{old('tgl_lahir')}}">
                    </div>
                    <div class="col-12">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" autocomplete="off" id="alamat" name="alamat" placeholder="Alamat" value="{{old('alamat')}}">
                    </div>
                    <div class="col-6">
                        <label for="id_sekolah">Sekolah</label>
                        <select class="form-control" autocomplete="off" id="id_sekolah" name="id_sekolah">
                            <option value="" selected disabled>-- Pilih Sekolah --</option>
                            @foreach ($sekolahs as $item)
                            <option value="{{$item->id_sekolah}}" {{ old('id_sekolah') == $item->id_sekolah ? 'selected' : '' }}>
                                {{$item->nama}}
                            </option>
                            @endforeach
                        </select>
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
@foreach($anggota as $item)
<div class="modal fade" id="modalEditAnggota{{$item->id_anggota}}">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content edit" action="{{route('petugas.anggota.update', $item->id_anggota)}}" method="post" autocomplete="off">
            @method('PUT')
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Edit Anggota</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label for="edit_nama">Nama</label>
                        <input type="text" class="form-control" autocomplete="off" id="edit_nama" name="nama" placeholder="Nama" value="{{$item->nama}}">
                    </div>
                    <div class="col-6">
                        <label for="edit_tgl_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" autocomplete="off" id="edit_tgl_lahir" name="tgl_lahir" value="{{$item->tgl_lahir}}">
                    </div>
                    <div class="col-12">
                        <label for="edit_alamat">Alamat</label>
                        <input type="text" class="form-control" autocomplete="off" id="edit_alamat" name="alamat" placeholder="Alamat" value="{{$item->alamat}}">
                    </div>
                    <div class="col-6">
                        <label for="edit_id_sekolah">Sekolah</label>
                        <select class="form-control" autocomplete="off" id="edit_id_sekolah" name="id_sekolah">
                            <option value="" selected disabled>-- Pilih Sekolah --</option>
                            @foreach ($sekolahs as $item)
                            <option value="{{$item->id_sekolah}}">{{$item->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection
