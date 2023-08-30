@extends('layouts.app')
@section('content')
<div class="row mb-4">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                <h5 class="mr-4 mb-0 font-weight-bold">Dashboard</h5>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Progress Table start -->
    <div class="col-12">
        <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#modalTambahAnggota">
            <i class="fa fa-plus"></i> Tambah Anggota
        </button>
        <div class="modal fade" id="modalTambahAnggota">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form class="modal-content tambah" action="{{route('petugas.anggota.store')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Anggota</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap">
                            </div>
                            <div class="col-6">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" placeholder="Tanggal Lahir">
                            </div>
                            <div class="col-6">
                                <label for="sekolah">Sekolah</label>
                                <select class="form-control" id="id_sekolah" name="id_sekolah">
                                    <option value="" selected disabled>-- Pilih Sekolah --</option>
                                    @foreach($sekolah as $item)
                                        <option value="{{$item->id_sekolah}}">{{$item->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat"></textarea>
                            </div>
                            <div class="col-6">
                                <label for="simpanan_pokok">Simpanan Pokok</label>
                                <input type="number" class="form-control" id="simpanan_pokok" name="simpanan_pokok" placeholder="Simpanan Pokok">
                            </div>
                            <div class="col-6">
                                <label for="simpanan_karyawisata">Simpanan Karyawisata</label>
                                <input type="number" class="form-control" id="simpanan_karyawisata" name="simpanan_karyawisata" placeholder="Simpanan Karyawisata">
                            </div>
                            <div class="col-6">
                                <label for="simpanan_hari_raya">Simpanan Hari Raya</label>
                                <input type="number" class="form-control" id="simpanan_hari_raya" name="simpanan_hari_raya" placeholder="Simpanan Hari Raya">
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
                    Products Table
                </h4>
                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table table-hover progress-table text-center">
                            <thead class="text-uppercase">
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Product</th>
                                <th scope="col">Date</th>
                                <th scope="col">Price</th>
                                <th scope="col">status</th>
                                <th scope="col">action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">6583</th>
                                <td>Mark Spence</td>
                                <td>Macbook Pro</td>
                                <td>09 / 07 / 2018</td>
                                <td>672.56$</td>
                                <td><span class="badge badge-primary">Progress</span></td>
                                <td>
                                    <ul class="d-flex justify-content-center">
                                        <li class="mr-3"><button type="button" class="btn btn-inverse-primary"><i class="fa fa-edit"></i></button></li>
                                        <li><button type="button" class="btn btn-inverse-danger"><i class="ti-trash"></i></button></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">4652</th>
                                <td>David Rebon</td>
                                <td>iPhone X</td>
                                <td>09 / 07 / 2018</td>
                                <td>672.56$</td>
                                <td><span class="badge badge-warning">Pending</span></td>
                                <td>
                                    <ul class="d-flex justify-content-center">
                                        <li class="mr-3"><button type="button" class="btn btn-inverse-primary"><i class="fa fa-edit"></i></button></li>
                                        <li><button type="button" class="btn btn-inverse-danger"><i class="ti-trash"></i></button></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">7292</th>
                                <td>Jhon Doe</td>
                                <td>Samsung</td>
                                <td>09 / 07 / 2018</td>
                                <td>672.56$</td>
                                <td><span class="badge badge-success">Completed</span></td>
                                <td>
                                    <ul class="d-flex justify-content-center">
                                        <li class="mr-3"><button type="button" class="btn btn-inverse-primary"><i class="fa fa-edit"></i></button></li>
                                        <li><button type="button" class="btn btn-inverse-danger"><i class="ti-trash"></i></button></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">7826</th>
                                <td>Jessica Roy</td>
                                <td>Exercise Machine</td>
                                <td>09 / 07 / 2018</td>
                                <td>672.56$</td>
                                <td><span class="badge badge-danger">Stopped</span></td>
                                <td>
                                    <ul class="d-flex justify-content-center">
                                        <li class="mr-3"><button type="button" class="btn btn-inverse-primary"><i class="fa fa-edit"></i></button></li>
                                        <li><button type="button" class="btn btn-inverse-danger"><i class="ti-trash"></i></button></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2638</th>
                                <td>Malika Jhon</td>
                                <td>Machine</td>
                                <td>09 / 07 / 2018</td>
                                <td>483.56$</td>
                                <td><span class="badge badge-primary">Progress</span></td>
                                <td>
                                    <ul class="d-flex justify-content-center">
                                        <li class="mr-3"><button type="button" class="btn btn-inverse-primary"><i class="fa fa-edit"></i></button></li>
                                        <li><button type="button" class="btn btn-inverse-danger"><i class="ti-trash"></i></button></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">9374</th>
                                <td>David Jess</td>
                                <td>Laptop</td>
                                <td>09 / 07 / 2018</td>
                                <td>473.56$</td>
                                <td><span class="badge badge-success">Completed</span></td>
                                <td>
                                    <ul class="d-flex justify-content-center">
                                        <li class="mr-3"><button type="button" class="btn btn-inverse-primary"><i class="fa fa-edit"></i></button></li>
                                        <li><button type="button" class="btn btn-inverse-danger"><i class="ti-trash"></i></button></li>
                                    </ul>
                                </td>
                            </tr>
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
