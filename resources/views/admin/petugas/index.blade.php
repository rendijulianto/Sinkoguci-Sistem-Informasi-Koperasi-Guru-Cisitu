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
    <!-- Progress Table start -->
    <div class="col-12">
        <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#modalTambahPetugas">
            <i class="fa fa-plus"></i> Tambah Petugas
        </button>
    </div>
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
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">Email</th>
                                <th scope="col">Level</th>
                                <th scope="col">Aksi</th>
                             
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($petugas as $item)
                                <tr>
                                    <th scope="row">{{$item->id_petugas}}</th>
                                    <td>{{$item->nama}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->level}}</td>
                                    <td>
                                        <ul class="d-flex justify-content-center">
                                            <li class="mr-3"><button type="button" class="btn btn-inverse-primary" data-toggle="modal" data-target="#modalEditPetugas{{$item->id_petugas}}"><i class="fa fa-edit"></i></button></li>
                                            <li>
                                                {{-- <button type="button" class="btn btn-inverse-danger"><i class="fa fa-trash"></i></button> --}}
                                                <form  action="{{route('admin.petugas.destroy', $item->id_petugas)}}" method="post" class="hapus">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-inverse-danger"><i class="fa fa-trash"></i></button>
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
    <!-- Progress Table end -->
</div>
@endsection

@section('js')
<div class="modal fade" id="modalTambahPetugas">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content tambah" action="{{route('admin.petugas.store')}}" method="post" autocomplete="off">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Petugas</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control" autocomplete="off" id="nama" name="nama" placeholder="Nama Lengkap" value="{{old('nama')}}">
                    </div>
                    <div class="col-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" autocomplete="off" id="email" name="email" placeholder="Email" value="{{old('email')}}">
                    </div>
                    <div class="col-6">
                        <label for="password">Kata Sandi</label>
                        <input type="password" class="form-control" autocomplete="off" id="password" name="password" placeholder="Kata Sandi" value="{{old('password')}}">
                    </div>
                    <div class="col-6">
                        <label for="level">Level</label>
                        <select class="form-control" autocomplete="off" id="level" name="level">
                            <option value="" selected disabled>-- Pilih Level --</option>
                            <option value="admin" {{old('level') == 'admin' ? 'selected' : ''}}>Admin</option>
                            <option value="petugas" {{old('level') == 'petugas' ? 'selected' : ''}}>Petugas</option>
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
    @foreach($petugas as $item)
    <div class="modal fade" id="modalEditPetugas{{$item->id_petugas}}">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form class="modal-content ubah" action="{{route('admin.petugas.update', $item->id_petugas)}}" method="post">
                @method('PUT')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Petugas</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" autocomplete="off" id="nama" name="nama" placeholder="Nama Lengkap" value="{{$item->nama}}">
                        </div>
                        <div class="col-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" autocomplete="off" id="email" name="email" placeholder="Email" value="{{$item->email}}">
                        </div>
                        <div class="col-6">
                            <label for="password">Kata Sandi</label>
                            <input type="password" class="form-control" autocomplete="off" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah kata sandi">
                        </div>
                        <div class="col-6">
                            <label for="level">Level</label>
                            <select class="form-control" autocomplete="off" id="level" name="level">
                                <option value="" selected disabled>-- Pilih Level --</option>
                                <option value="admin" {{$item->level == 'admin' ? 'selected' : ''}}>Admin</option>
                                <option value="petugas" {{$item->level == 'petugas' ? 'selected' : ''}}>Petugas</option>
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
    @endforeach
@endsection
