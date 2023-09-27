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
        <div class="col-lg-12">
            <div class="card">
                 <div class="card-body">
                     <table class="table table-hover progress-table text-center bg-white table-striped table-bordered">
                         <tr>
                             <th colspan="2">Data Pinjaman</th>
                         </tr>
                         <tr>
                             <td>Nomor Pinjaman</td>
                             <td>{{$pinjaman->id_pinjaman}}</td>
                         </tr>
                         <tr>
                             <td>Nominal</td>
                             <td>{{Helper::numericToRupiah($pinjaman->nominal)}}</td>
                         </tr>
                         <tr>
                             <td>Lama Angsuran</td>
                             <td>{{$pinjaman->lama_angsuran}} Bulan</td>
                         </tr>
                         <tr>
                             <td>Sisa Pokok</td>
                             <td>{{Helper::numericToRupiah($pinjaman->sisa_pokok)}}</td>
                         </tr>

                         <tr>
                             <td>Sisa Jasa</td>
                             <td>{{Helper::numericToRupiah($pinjaman->sisa_jasa)}}</td>
                         </tr>
                         <tr>
                             <td>Angsuran Pokok</td>
                             <td>{{Helper::numericToRupiah($pinjaman->nominal / $pinjaman->lama_angsuran)}}  / Bulan</td>
                         </tr>
                         <tr>
                             <td>Tanggal Pinjaman</td>
                             <td>{{Helper::dateIndo($pinjaman->tgl_pinjaman)}}</td>
                         </tr>

                         <tr>
                             <td>Status</td>
                             <td>{{$pinjaman->status}}</td>
                         </tr>
                      </table>
                 </div>
            </div>
         </div>
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
                                    <th rowspan="2" scope="col">No</th>
                                    <th rowspan="2" scope="col">Tgl Bayar</th>
                                    <th colspan="2">Tagihan</th>
                                    <th colspan="2">Pembayaran</th>
                                    <th colspan="2" scope="col">Sisa</th>
                                    <th rowspan="2" scope="col">Keterangan</th>
                                    <th rowspan="2" scope="col">Petugas</th>
                                    <th rowspan="2" scope="col">Aksi</th>
                                </tr>
                                <tr>
                                    <th scope="col">Pokok</th>
                                    <th scope="col">Jasa</th>
                                    <th scope="col">Pokok</th>
                                    <th scope="col">Jasa</th>
                                    <th scope="col">Pokok</th>
                                    <th scope="col">Jasa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tbody>
                                    @php

                                    $total_bayar_pokok = 0;
                                    $total_bayar_jasa = 0;

                                    @endphp
                                @foreach($angsuran as $item)

                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->tgl_bayar}}</td>
                                        <td>Rp {{number_format($item->sebelum_pokok <= $item->pinjaman->nominal ? $item->sebelum_pokok : $item->pinjaman->nominal / $item->pinjaman->lama_angsuran)}}</td>
                                        <td>Rp {{number_format($item->sebelum_jasa)}}</td>
                                        <td>Rp {{number_format($item->bayar_pokok)}}</td>
                                        <td>Rp {{number_format($item->bayar_jasa)}}</td>
                                        <td>Rp {{number_format($item->setelah_pokok)}}</td>
                                        <td>Rp {{number_format($item->setelah_jasa)}}</td>
                                        <td><textarea class="form-control" readonly>{{$item->keterangan}}</textarea></td>
                                        <td>{{$item->petugas->nama}}</td>
                                        <td>
                                            @if ($loop->iteration != 1)
                                            <p> Tidak ada aksi </p>
                                            @else
                                                <form action="{{route('admin.pinjaman.destroy-angsuran', [$item->pinjaman->id_pinjaman, $item->tgl_bayar, $item->bayar_pokok, $item->bayar_jasa, $item->setelah_pokok, $item->setelah_jasa])}}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-inverse-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
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

 @endsection
