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
<div class="row mb-4">
   <div class="col-12">
      <div class="card">
         <div class="card-body text-center bg-primary">
            <h5 class="card-title text-white">KGC CISITU</h5>
            <img src="{{asset('assets/images/logo.png')}}" alt="" width="100" height="100">
         </div>
         <div class="card-body text-center">
            <h5 class="card-title">SELAMAT DATANG DI  SISTEM INFORMASI KPRI KANCAWINAYA GURU CISITU (KPRI KGC)</h5>
            <b class="card-text">
             NOMOR AHU-0001852/AJ/-1/38/TAHUN 2022 <br />TANGGAL 28 SEPTEMBER 2022
             </b> <br />
            <i class="card-text">Alamat Jalan Raya Umar Wirahadikusumah / Jalan Darmaraja KM 18 Kecamatan Cisitu Kabutan Sumedang.</i>
          </div>
       </div>
   </div>
</div>
<div class="row mb-4">
   <div class="col-12">
      <div class="card">
         <div class="card-body">
            <div class="row">
               <div class="col-lg-4 mb-3" style="cursor: pointer;">
                  <a href="{{route('admin.petugas.index')}}">
                     <div class="card">
                        <div class="card-body bg-warning text-white d-flex justify-content-between align-items-center rounded">
                           <i class="fa fa-user fa-3x"></i> Kelola Petugas
                        </div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-4 mb-3" style="cursor: pointer;">
                  <a href="{{route('admin.sekolah.index')}}">
                     <div class="card">
                        <div class="card-body bg-success  text-white d-flex justify-content-between align-items-center rounded">
                           <i class="fa fa-school fa-3x"></i> Kelola Sekolah
                        </div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-4 mb-3" style="cursor: pointer;">
                  <a href="{{route('admin.kategori-simpanan.index')}}">
                     <div class="card">
                        <div class="card-body bg-primary d-flex justify-content-between align-items-center rounded">
                           <i class="fa fa-dollar-sign fa-3x"></i> Kelola Kategori Simpanan
                        </div>
                     </div>
                  </a>
               </div>
            </div>
         </div>
       </div>
   </div>
</div>
@endsection
