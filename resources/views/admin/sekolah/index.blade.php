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
<div class="row">
    <!-- Progress Table start -->

    <div class="col-12">
        <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#modalTambahSekolah">
            <i class="fa fa-plus"></i> Tambah Sekolah
        </button>
        
        <div class="modal fade" id="modalTambahSekolah">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form class="modal-content tambah" action="{{route('admin.sekolah.store')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Sekolah</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <label for="nama">Nama Sekolah</label>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama Sekolah" required>
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
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card_title">
                    Data Sekolah
                </h4>
                <form action="{{route('admin.sekolah.index')}}" method="get">
                    <div class="input-group mb-3">
                        <input type="text" name="cari" id="nama" class="form-control" placeholder="Cari Sekolah">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                    </div>
                </form>
                
                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table table-hover progress-table text-center">
                            <thead class="text-uppercase">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Sekolah</th>
                                <th scope="col">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($sekolah as $item)
                                <tr>
                                    <th scope="row">{{$item->id_sekolah}}</th>
                                    <td>{{$item->nama}}</td>
                                    <td>
                                        <ul class="d-flex justify-content-center">
                                            <li class="mr-3"><a button type="button" class="btn btn-inverse-primary" data-toggle="modal" data-target="#modalEditSekolah{{$item->id_sekolah}}"><i class="fa fa-edit"></i></a></li>
                                            <li>
                                                {{-- <button type="button" class="btn btn-inverse-danger"><i class="fa fa-trash"></i></button> --}}
                                                <form  action="{{route('admin.sekolah.destroy', $item->id_sekolah)}}" method="post" class="hapus">
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
<div class="modal fade" id="modalTambahSekolah">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content tambah" action="{{route('admin.sekolah.store')}}" method="post" autocomplete="off">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Sekolah</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label for="nama">Nama Sekolah</label>
                        <input type="text" class="form-control" autocomplete="off" id="nama" name="nama" placeholder="Masukkan Nama Sekolah" value="{{old('nama')}}">
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
    @foreach($sekolah as $item)
    <div class="modal fade" id="modalEditSekolah{{$item->id_sekolah}}">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form class="modal-content ubah" action="{{route('admin.sekolah.update', $item->id_sekolah)}}" method="post">
                @method('PUT')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Sekolah</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="nama">Nama Sekolah</label>
                            <input type="text" class="form-control" autocomplete="off" id="nama" name="nama" placeholder="Masukkan Nama Sekolah" value="{{$item->nama}}">
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
