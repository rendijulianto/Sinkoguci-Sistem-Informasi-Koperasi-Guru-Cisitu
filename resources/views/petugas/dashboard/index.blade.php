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
           <b class="card-text">BADAN HUKUM No. 1059/BH/PAD/KWK-10/VII/98 <br> TANGGAL 30 JULI 1998</b> <br />
           <i class="card-text">Alamat Jln. Raya Sumedang-Wado Km 18 Cisitu-Sumedang</i>
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
                  <div class="card">
                     <div class="card-body bg-warning text-white d-flex justify-content-between align-items-center rounded">
                        <i class="fa fa-credit-card fa-3x"></i> Kelola Peminjaman
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 mb-3" style="cursor: pointer;">
                  <div class="card">
                     <div class="card-body bg-success  text-white d-flex justify-content-between align-items-center rounded">
                        <i class="fa fa-dollar-sign fa-3x"></i> Kelola Simpanan
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 mb-3" style="cursor: pointer;">
                  <div class="card">
                     <div class="card-body bg-primary d-flex justify-content-between align-items-center rounded">
                        <i class="fa fa-dollar-sign fa-3x"></i> Kelola Penarikan Simpanan
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 mb-3" style="cursor: pointer;">
                  <div class="card">
                     <div class="card-body bg-primary d-flex justify-content-between align-items-center rounded">
                        <i class="fa fa-file-invoice-dollar fa-3x"></i> Bayar Cicilan
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 mb-3" style="cursor: pointer;">
                  <div class="card">
                     <div class="card-body bg-danger d-flex justify-content-between align-items-center rounded">
                        <i class="fa fa-receipt fa-3x"></i> Laporan Tagihan
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 mb-3" style="cursor: pointer;">
                  <div class="card">
                     <div class="card-body bg-info d-flex justify-content-between align-items-center rounded">
                        <i class="fa fa-money-bill fa-3x"></i> Kelola Penarikan Dana Sosial
                     </div>
                  </div>
               </div>
            </div>
         </div>
       </div>
   </div>
</div>
@endsection
