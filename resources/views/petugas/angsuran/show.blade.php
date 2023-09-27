
<div class="col-lg-3">
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
                    <td>{{number_format($pinjaman->nominal)}}</td>
                </tr>
                <tr>
                    <td>Lama Angsuran</td>
                    <td>{{$pinjaman->lama_angsuran}} Bulan</td>
                </tr>
                <tr>
                    <td>Sisa Pokok</td>
                    <td>{{number_format($pinjaman->sisa_pokok)}}</td>
                </tr>

                <tr>
                    <td>Sisa Jasa</td>
                    <td>{{number_format($pinjaman->sisa_jasa)}}</td>
                </tr>
                <tr>
                    <td>Angsuran Pokok</td>
                    <td>{{number_format($pinjaman->nominal / $pinjaman->lama_angsuran)}}  / Bulan</td>
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
<div class="col-lg-9">
   <div class="row">
     <div class="col-12 mb-3">
        <a href="{{route('petugas.angsuran.show', $pinjaman->id_pinjaman)}}?aksi=download" class="btn btn-success" style="float: right">
            <i class="fa fa-file-excel"></i> Download
        </a>
        <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#modalTambahSimpanan" style="float: right; margin-right: 10px;">
            <i class="fa fa-plus"></i> Bayar Cicilan
        </button>
     </div>
     <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card_title">
                    Data Angsuran
                </h4>
                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table table-hover progress-table text-center table-striped table-bordered">
                            <thead class="text-uppercase bg-primary">
                            <tr>
                                <th rowspan="2" scope="col">No</th>
                                <th rowspan="2" scope="col">Tgl Bayar</th>
                                <th colspan="2">Tagihan</th>
                                <th colspan="2">Pembayaran</th>
                                <th colspan="2" scope="col">Sisa</th>
                                <th rowspan="2" scope="col">Petugas</th>
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
                                @php

                                $total_bayar_pokok = 0;
                                $total_bayar_jasa = 0;

                                @endphp
                            @foreach($angsuran as $key => $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{Helper::dateIndo($item->tgl_bayar)}}</td>
                                    <td>{{Helper::numericToRupiah($item->sebelum_pokok <= $item->pinjaman->nominal ? $item->sebelum_pokok : $item->pinjaman->nominal / $item->pinjaman->lama_angsuran)}}</td>
                                    <td>{{Helper::numericToRupiah($item->sebelum_jasa)}}</td>
                                    <td>{{Helper::numericToRupiah($item->bayar_pokok)}}</td>
                                    <td>{{Helper::numericToRupiah($item->bayar_jasa)}}</td>
                                    <td>{{Helper::numericToRupiah($item->setelah_pokok)}}</td>
                                    <td>{{Helper::numericToRupiah($item->setelah_jasa)}}</td>
                                    <td>{{$item->petugas->nama}}</td>
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
</div>
<div class="modal fade" id="modalTambahSimpanan">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content tambah" action="{{route('petugas.angsuran.store')}}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Bayar Cicilan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <ul class="m-0">
                        <li>Kosongkan simpanan / isi dengan 0 jika tidak ingin menambahkan simpanan / dana khusus.</li>
                        <li>Simpanan pokok, wajib, khusus, karya wisata, hari raya, suka rela, dan dana khusus akan dijumlahkan menjadi total bayar.</li>
                    </ul>
                </div>
                <div class="row">
                    <input type="hidden" name="sisa_pokok" id="sisa_pokok" value="{{$pinjaman->sisa_pokok}}">
                    <input type="hidden" name="sisa_jasa" id="sisa_jasa" value="{{$pinjaman->sisa_jasa}}">
                    <div class="col-12">
                        <label for="id_pinjaman">Nomor Pinjaman</label>
                        <input type="text" class="form-control" autocomplete="off" id="id_pinjaman" name="id_pinjaman" placeholder="Nomor Pinjaman" value="{{$pinjaman->id_pinjaman}}" readonly>
                    </div>
                    <div class="col-6">
                        <label for="bayar_pokok">Bayar Pokok</label>
                        <input type="text" class="form-control autonumeric-currency" autocomplete="off" id="bayar_pokok" name="bayar_pokok" placeholder="Bayar Pokok" value="{{old('bayar_pokok') ?? 0}}" >
                    </div>
                    <div class="col-6">
                        <label for="bayar_jasa">Bayar Jasa</label>
                        <input type="text" class="form-control autonumeric-currency" autocomplete="off" id="bayar_jasa" name="bayar_jasa" placeholder="Bayar Jasa" value="{{old('bayar_jasa') ?? 0}}" >
                    </div>
                    <div class="col-6">
                        <label for="tgl_bayar">Tanggal Bayar</label>
                        <input type="date" class="form-control" autocomplete="off" name="tgl_bayar" id="tgl_bayar" value="{{old('tgl_bayar') ?? date('Y-m-d')}}">
                    </div>
                    <div class="col-12">
                        <label for="simpanan_suka_rela">Total Bayar</label>
                        <input type="text" class="form-control" autocomplete="off" id="total_bayar" name="total_bayar" placeholder="Total Bayar" value="{{old('total_bayar')}}" readonly>
                    </div>
                    <div class="col-12">
                        <hr class="mt-2 mb-2">
                        <p class="text-center">Sisa Pinjaman</p>
                    </div>
                    <div class="col-6">
                        <label for="setelah_pokok">Sisa Pokok</label>
                        <input type="text" class="form-control" autocomplete="off" id="setelah_pokok" name="setelah_pokok" placeholder="Sisa Pokok" value="{{old('setelah_pokok')}}" readonly>
                    </div>
                    <div class="col-6">
                        <label for="setelah_jasa">Sisa Jasa</label>
                        <input type="text" class="form-control" autocomplete="off" id="setelah_jasa" name="setelah_jasa" placeholder="Sisa Jasa" value="{{old('setelah_jasa')}}" readonly>
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

<script>
$('.autonumeric-currency').keyup(function() {
    var pokok = convertRupiahToNumber($('input[name=bayar_pokok]').val());
    var jasa = convertRupiahToNumber($('input[name=bayar_jasa]').val());
    var total = parseInt(pokok) + parseInt(jasa);
    $('input[name=total_bayar]').val('' + new Intl.NumberFormat('id-ID').format(total));
    $('input[name=setelah_pokok]').val('' + new Intl.NumberFormat('id-ID').format(convertRupiahToNumber($('input[name=sisa_pokok]').val()) - parseInt(pokok)))
    $('input[name=setelah_jasa]').val('' + new Intl.NumberFormat('id-ID').format(convertRupiahToNumber($('input[name=sisa_jasa]').val()) - parseInt(jasa)))
});
//
$('.autonumeric-currency').trigger('keyup');

$(".autonumeric-currency").autoNumeric("init", { mDec: "0", aSep: ".", aDec: ",", aSign: "Rp " });

</script>

