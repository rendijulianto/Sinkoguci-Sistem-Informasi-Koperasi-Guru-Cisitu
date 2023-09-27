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
   <div class="col-lg-2">
         <div class="form-group">
            <label class="col-form-label">Tanggal Awal</label>
            <br>
            <input type="date" class="form-control" name="tanggal_awal" value="{{$tanggal_awal}}">
         </div>
   </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label class="col-form-label">Tanggal Akhir</label>
            <br>
            <input type="date" class="form-control" name="tanggal_akhir" value="{{$tanggal_akhir}}">

        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label class="col-form-label">Kategori</label>
            <br>
            <select class="custom-select select2" fdprocessedid="bq1eom" name="kategori_id" id="kategori_id">
                <option value="" @if($kategori_id == 'all') selected @endif>Semua</option>
                @foreach ($kategori as $k)
                    <option value="{{$k->id_kategori}}" @if($kategori_id == $k->id_kategori) selected @endif>{{$k->nama}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label class="col-form-label">Anggota</label>
            <br>
            <select class="custom-select select2" fdprocessedid="bq1eom" name="anggota_id" id="anggota_id">
                <option value="" @if($anggota_id == 'all') selected @endif>Semua</option>
                @foreach ($anggota as $a)
                    <option value="{{$a->id_anggota}}" @if($anggota_id == $a->id_anggota) selected @endif>{{$a->nama}} - {{$a->sekolah->nama}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-4">
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
                        <table class="table table-hover progress-table table-striped table-bordered">
                            <thead class="text-uppercase bg-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Jenis Simpanan</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Petugas</th>
                                    <th scope="col">Aksi</th>
                                </tr>

                            </thead>
                            <tbody>
                            @forelse ($simpanan as $p)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$p->anggota->nama}}</td>
                                    <td>{{$p->kategori->nama}}</td>
                                    <td>{{Helper::dateIndo($p->tgl_bayar)}}</td>
                                    <td>{{Helper::numericToRupiah($p->jumlah)}}</td>
                                    <td>{{$p->petugas->nama}}</td>
                                    <td>
                                        <a href="#" class="btn btn-inverse-primary edit-button" data-toggle="modal" data-target="#modalEditSimpanan{{$p->id_simpanan}}">

                                        <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{route('admin.simpanan.destroy', $p->id_simpanan)}}" method="POST" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-inverse-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $simpanan->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@foreach($simpanan as $item)
<div class="modal fade" id="modalEditSimpanan{{$item->id_simpanan}}" tabindex="-1" role="dialog" aria-labelledby="modalEditSimpanan{{$item->id_simpanan}}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content edit" action="{{route('admin.simpanan.update', $item->id_simpanan)}}" method="POST">
            @method('PUT')
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Edit Simpanan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label for="edit_jenis_simpanan">Jenis Simpanan</label>
                        <input type="text" class="form-control" autocomplete="off" id="edit_jenis_simpanan" name="jenis_simpanan" placeholder="Jenis Simpanan" value="{{$item->kategori->nama}}" readonly>
                    </div>
                    <div class="col-6">
                        <label for="edit_tgl_bayar">Tanggal Bayar</label>
                        <input type="date" class="form-control" autocomplete="off" id="edit_tgl_bayar" name="tgl_bayar" placeholder="Tanggal Bayar" value="{{$item->tgl_bayar}}">
                    </div>
                    <div class="col-12">
                        <label for="edit_jumlah">Jumlah</label>
                        <input type="text" class="form-control autonumeric-currency" autocomplete="off" id="edit_jumlah" name="jumlah" placeholder="Jumlah" value="{{$item->jumlah}}">
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
 @section('js')
 <script>
    $(".autonumeric-currency").autoNumeric("init", { mDec: "0", aSep: ".", aDec: ",", aSign: "Rp " });
</script>
 @endsection
