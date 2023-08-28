@extends('layouts.app')
@section('content')
<h1 class="h3 mb-3">Simpanan</h1>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Formulir Simpanan</h5>
                <h6 class="card-subtitle text-muted">
                    Formulir ini digunakan untuk menambahkan simpanan anggota.
                </h6>
            </div>
            <div class="card-body">
                <form class="row  align-items-center">
                    <div class="col-9">
                        <input type="text" class="form-control mb-2 me-sm-2" id="inlineFormInputName2" placeholder="Nomor Anggota">
                    </div>
                    <div class="col-3">   
                        <button type="submit" class="btn btn-primary mb-2">Cek <i class="align-middle" data-feather="target"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-xl-3">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Detail Anggota</h5>
            </div>
            <div class="card-body text-center">
                <img src="{{asset('assets/img/avatars/avatar-4.jpg')}}" alt="Christina Mason" class="img-fluid rounded-circle mb-2" width="128" height="128">
                <h5 class="card-title mb-0">Christina Mason</h5>
                <div class="text-muted mb-2">Lead Developer</div>
            </div>
            <hr class="my-0">
            <div class="card-body">
                <h5 class="h6 card-title">Biodata</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home feather-sm me-1"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg> Lives in <a href="#">San Francisco, SA</a>
                    </li>
                    <li class="mb-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase feather-sm me-1"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg> Works at <a href="#">Guru Blabla</a></li>
                    <li class="mb-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin feather-sm me-1"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg> From <a href="#">Boston</a></li>
                </ul>
            </div>
            <hr class="my-0">
            <div class="card-body">
                <h5 class="h6 card-title">Informasi Tambahan</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-1"><i class="align-middle me-1" data-feather="briefcase"></i>
                        Simpanan Pokok <a href="#">Rp. 1.000.000</a>
                    </li>
                    <li class="mb-1"><i class="align-middle me-1" data-feather="briefcase"></i>
                        Simpanan Wajib <a href="#">Rp. 1.000.000</a>
                    </li>
                    <li class="mb-1"><i class="align-middle me-1" data-feather="briefcase"></i>
                        Simpanan Sukarela <a href="#">Rp. 1.000.000</a>
                    </li>
                    <li class="mb-1"><i class="align-middle me-1" data-feather="briefcase"></i>
                        Pinjaman <a href="#">Rp. 1.000.000</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-xl-9">
        {{-- detail nomor simpanan
            Jenis Simpanan
            Jumlah
             --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Detail Simpanan</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nomorSimpanan" class="form-label">Nomor</label>
                            {{-- input with icon --}}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="align-middle" data-feather="hash"></i></span>
                                <input type="text" value="AAA33" class="form-control" placeholder="Nomor Simpanan" aria-label="Nomor Simpanan" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        {{-- tanggal simpanan --}}
                        <div class="col-md-6 mb-3">
                            <label for="tanggalSimpanan" class="form-label">Tanggal</label>
                            {{-- input with icon --}}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="align-middle" data-feather="calendar"></i></span>
                                <input type="date" class="form-control" readonly placeholder="Tanggal Simpanan" aria-label="Tanggal Simpanan" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        {{-- Jenis, Nominal, Deskripsi --}}
                        <div class="col-md-6 mb-3">
                            <label for="jenisSimpanan" class="form-label">Jenis</label>
                            {{-- input with icon --}}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="align-middle" data-feather="dollar-sign"></i></span>
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Pilih Jenis Simpanan</option>
                                    <option value="1">Simpanan Pokok</option>
                                    <option value="2">Simpanan Wajib</option>
                                    <option value="3">Simpanan Sukarela</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nominalSimpanan" class="form-label">Nominal</label>
                            {{-- input with icon --}}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="align-middle" data-feather="dollar-sign"></i></span>
                                <input type="text" class="form-control" placeholder="Nominal Simpanan" aria-label="Nominal Simpanan" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="deskripsiSimpanan" class="form-label">Deskripsi</label>
                            {{-- input with icon --}}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="align-middle" data-feather="file-text"></i></span>
                                <textarea class="form-control" placeholder="Deskripsi Simpanan" aria-label="Deskripsi Simpanan" aria-describedby="basic-addon1"></textarea>
                            </div>
                        </div>
                        {{-- Apakah Setuju Dengan Syarat dan Ketentuan --}}
                        <div class="col-lg-12 mb-3">
                            <span class="form-label">Apakah Setuju Dengan <a href="#">Syarat dan Ketentuan</a></span>
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <button type="submit" class="btn btn-primary">Simpan <i class="align-middle" data-feather="save"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
