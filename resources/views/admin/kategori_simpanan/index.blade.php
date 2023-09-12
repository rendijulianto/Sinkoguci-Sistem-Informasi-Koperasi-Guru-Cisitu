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
        <button type="button" class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#modalUbahJumlahSimpananMasal">
            <i class="fa fa-edit"></i> Ubah Masal Nominal Simpanan
        </button>
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
                <form action="{{route('admin.kategori-simpanan.index')}}" method="get">
                    <div class="input-group mb-3">
                        <input type="text" name="cari" id="cari" class="form-control" placeholder="Cari Data .." value="{{ Request::get('cari') }}">
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
                                    <th scope="col">ID</th>
                                    <th scope="col">Nama Kategori</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kategoriSimpanan as $item)
                                <tr>
                                    <th scope="row">{{ $item->id_kategori }}</th>
                                    <td>{{ $item->nama }}</td>
                                    <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
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
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $kategoriSimpanan->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
    <!-- Progress Table end -->
</div>

<div class="modal fade" id="modalUbahJumlahSimpananMasal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content tambah" action="{{route('admin.kategori-simpanan.ubah-masal-jumlah')}}" method="post" autocomplete="off">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Ubah Masal Nominal Simpanan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label for="nama">Kategori</label>
                        <select class="custom-select select2" fdprocessedid="bq1eom" name="id_kategori" id="id_kategori">
                            <option selected disabled> -- Pilih -- </option>
                            @foreach ($kategoriSimpanan as $item)
                                <option value="{{$item->id_kategori}}">{{$item->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="jumlah">Jumlah</label>
                        <input type="text" class="form-control autonumeric-currency" autocomplete="off" id="jumlah" name="jumlah" placeholder="Jumlah" value="">
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


<div class="modal fade" id="modalTambahKategoriSimpanan">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content tambah" action="{{route('admin.kategori-simpanan.store')}}" method="post" autocomplete="off">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori Simpanan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label for="nama">Nama Kategori</label>
                        <input type="text" class="form-control" autocomplete="off" id="nama" name="nama" placeholder="Nama Kategori" value="">
                    </div>
                    <div class="col-6">
                        <label for="jumlah">Jumlah</label>
                        <input type="text" class="form-control autonumeric-currency" autocomplete="off" id="jumlah" name="jumlah" placeholder="Jumlah" value="">
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
                        <input type="text" class="form-control autonumeric-currency" autocomplete="off" id="jumlah" name="jumlah" placeholder="Jumlah" value="{{ $item->jumlah }}">
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
@section('js')
<script>
    $(".autonumeric-currency").autoNumeric("init", { mDec: "0", aSep: ".", aDec: ",", aSign: "Rp " });
</script>
@endsection
