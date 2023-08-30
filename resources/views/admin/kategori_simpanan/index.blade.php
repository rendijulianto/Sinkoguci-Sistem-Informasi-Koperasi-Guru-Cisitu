@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                <h5 class="mr-4 mb-0 font-weight-bold">{{ $title }}</h5>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Progress Table start -->
    <div class="col-12">
        <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#modalTambahKategoriSimpanan">
            <i class="fa fa-plus"></i> Tambah Kategori Simpanan
        </button>
    </div>
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card_title">
                    {{ $title }}
                </h4>
                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table table-hover progress-table text-center">
                            <thead class="text-uppercase">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nama Kategori</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kategoriSimpanan as $item)
                                <tr>
                                    <th scope="row">{{ $item->id_kategori }}</th>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>
                                        <ul class="d-flex justify-content-center">
                                            <li class="mr-3">
                                                <button type="button" class="btn btn-inverse-primary" data-toggle="modal" data-target="#modalEditKategoriSimpanan{{ $item->id_kategori }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.kategori-simpanan.destroy', $item->id_kategori) }}" method="post" class="hapus">
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
    <!-- Progress Table end -->
</div>


<div class="modal fade" id="modalTambahKategoriSimpanan">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content tambah" action="{{route('admin.kategori-simpanan.store')}}" method="post" autocomplete="off">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Ubah Kategori Simpanan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label for="nama">Nama Kategori</label>
                        <input type="text" class="form-control" autocomplete="off" id="nama" name="nama" placeholder="Nama Kategori" value="{{ $item->nama }}">
                    </div>
                    <div class="col-6">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" class="form-control" autocomplete="off" id="jumlah" name="jumlah" placeholder="Jumlah" value="{{ $item->jumlah }}">
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

@foreach($kategoriSimpanan as $item)
<div class="modal fade" id="modalEditKategoriSimpanan{{ $item->id_kategori }}">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content ubah" action="{{ route('admin.kategori-simpanan.update', $item->id_kategori) }}" method="post">
            @method('PUT')
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Ubah Kategori Simpanan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label for="nama">Nama Kategori</label>
                        <input type="text" class="form-control" autocomplete="off" id="nama" name="nama" placeholder="Nama Kategori" value="{{ $item->nama }}">
                    </div>
                    <div class="col-6">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" class="form-control" autocomplete="off" id="jumlah" name="jumlah" placeholder="Jumlah" value="{{ $item->jumlah }}">
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
