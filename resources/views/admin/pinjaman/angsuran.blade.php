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
                             <td>Rp {{number_format($pinjaman->nominal)}}</td>
                         </tr>
                         <tr>
                             <td>Lama Angsuran</td>
                             <td>{{$pinjaman->lama_angsuran}} Bulan</td>
                         </tr>
                         <tr>
                             <td>Sisa Pokok</td>
                             <td>Rp {{number_format($pinjaman->sisa_pokok)}}</td>
                         </tr>
         
                         <tr>
                             <td>Sisa Jasa</td>
                             <td>Rp {{number_format($pinjaman->sisa_jasa)}}</td>
                         </tr>
                         <tr>
                             <td>Angsuran Pokok</td>
                             <td>Rp {{number_format($pinjaman->nominal / $pinjaman->lama_angsuran)}}  / Bulan</td>
                         </tr>
                         <tr>
                             <td>Tanggal Pinjaman</td>
                             <td>{{$pinjaman->tgl_pinjam}}</td>
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
                                            {{-- <a href="#" class="btn btn-inverse-primary edit-button" data-toggle="modal" data-target="#modalEdit{{$loop->iteration}}">
                                                <i class="fa fa-edit"></i> 
                                                </a> --}}
                                                <form action="{{route('admin.pinjaman.destroy-angsuran', [$item->pinjaman->id_pinjaman, $item->tgl_bayar, $item->bayar_pokok, $item->bayar_jasa, $item->setelah_pokok, $item->setelah_jasa])}}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-inverse-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                                {{-- <div class="modal fade" id="modalEdit{{$loop->iteration}}">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <form class="modal-content edit" action="{{route('admin.pinjaman.update-angsuran', [$item->pinjaman->id_pinjaman, $item->tgl_bayar, $item->sisa_pokok, $item->sisa_jasa])}}" method="POST">
                                                            @method('PUT')
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Ubah Angsuran</h5>
                                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <label for="edit_nomor_pinjaman">Nomor Pinjaman</label>
                                                                        <input type="text" value="{{$item->pinjaman->id_pinjaman}}" class="form-control" autocomplete="off" id="edit_nomor_pinjaman" name="nomor_pinjaman" placeholder="Nomor Pinjaman" readonly>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label for="edit_tgl_bayar">Tanggal Bayar</label>
                                                                        <input type="date" value="{{$item->tgl_bayar}}" class="form-control" autocomplete="off" id="edit_tgl_bayar" name="tgl_bayar" placeholder="Tanggal Bayar" required>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label for="edit_bayar_pokok">Bayar Pokok</label>
                                                                        <input type="number" value="{{$item->bayar_pokok}}" class="form-control" autocomplete="off" id="edit_bayar_pokok" name="bayar_pokok" placeholder="Bayar Pokok" required>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label for="edit_bayar_jasa">Bayar Jasa</label>
                                                                        <input type="number" value="{{$item->bayar_jasa}}" class="form-control" autocomplete="off" id="edit_bayar_jasa" name="bayar_jasa" placeholder="Bayar Jasa" required>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="edit_keterangan">Keterangan</label>
                                                                        <textarea class="form-control" autocomplete="off" id="edit_keterangan" name="keterangan" placeholder="Keterangan" required>{{$item->keterangan}}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div> --}}
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
