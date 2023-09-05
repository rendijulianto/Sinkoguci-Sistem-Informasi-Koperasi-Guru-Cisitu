
<div class="col-lg-3">
    <div class="card">
        <div class="card-body">
            {{-- image lingkaran--}}
            <div class="text-center">
                <h4  class="card_title">Detail Pinjaman</h4>
                {{-- <img src="dummy internet --}}
                <img src="https://dummyimage.com/150x150/c4c4/fff"
                alt="foto" class="rounded-circle" width="150" height="150">


            </div>
        </div>
    </div>
</div>
<div class="col-lg-9">
   <div class="row">
     <div class="col-12 mb-3">
        <a href="{{route('petugas.cicilan.show', $pinjaman->id_pinjaman)}}?aksi=download" class="btn btn-success" style="float: right">
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
                            @foreach($cicilan as $key => $c)
                                @php

                                    $total_bayar_pokok += $c->bayar_pokok;
                                    $total_bayar_jasa += $c->bayar_jasa;

                                @endphp
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$c->tgl_bayar}}</td>
                                    <td>Rp {{number_format($c->sebelum_pokok <= $c->pinjaman->nominal ? $c->sebelum_pokok : $c->pinjaman->nominal / $c->pinjaman->lama_angsuran)}}</td>
                                    <td>Rp {{number_format($c->sebelum_jasa)}}</td>
                                    <td>Rp {{number_format($c->bayar_pokok)}}</td>
                                    <td>Rp {{number_format($c->bayar_jasa)}}</td>
                                    <td>Rp {{number_format($c->setelah_pokok)}}</td>
                                    <td>Rp {{number_format($c->setelah_jasa)}}</td>
                                    <td>{{$c->petugas->nama}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tr>
                                <td colspan="4">Total</td>
                                <td>Rp {{number_format($total_bayar_pokok)}}</td>
                                <td>Rp {{number_format($total_bayar_jasa)}}</td>
                                <td colspan="3"></td>
                            </tr>
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
        <form class="modal-content tambah" action="{{route('petugas.cicilan.store')}}" method="POST">
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
                    <div class="col-12">
                        <label for="id_pinjaman">Nomor Pinjaman</label>
                        <input type="text" class="form-control" autocomplete="off" id="id_pinjaman" name="id_pinjaman" placeholder="Nomor Pinjaman" value="{{$pinjaman->id_pinjaman}}" readonly>
                    </div>
                    <div class="col-6">
                        <label for="bayar_pokok">Bayar Pokok</label>
                        <input type="number" class="form-control" autocomplete="off" id="bayar_pokok" name="bayar_pokok" placeholder="Bayar Pokok" value="{{old('bayar_pokok')}}" >
                    </div>
                    <div class="col-6">
                        <label for="bayar_jasa">Bayar Jasa</label>
                        <input type="number" class="form-control" autocomplete="off" id="bayar_jasa" name="bayar_jasa" placeholder="Bayar Jasa" value="{{old('bayar_jasa')}}" >
                    </div>
                    <div class="col-6">
                        <label for="tgl_bayar">Tanggal Bayar</label>
                        <input type="date" class="form-control" autocomplete="off" name="tgl_bayar" id="tgl_bayar" value="{{old('tgl_bayar') ?? date('Y-m-d')}}">
                    </div>
                    <div class="col-6">
                        <label for="simpanan_suka_rela">Total Bayar</label>
                        <input type="text" class="form-control" autocomplete="off" id="total_bayar" name="total_bayar" placeholder="Total Bayar" value="{{old('total_bayar')}}" readonly>
                    </div>

                    <div class="col-6">
                        <label for="sebelum_pokok">Sebelum Pokok</label>
                        <input type="hidden" class="form-control" autocomplete="off" id="sebelum_pokok" name="sebelum_pokok" placeholder="Sebelum Pokok" value="{{$pinjaman->sisa_pokok}}" readonly>
                        <input type="text" class="form-control" autocomplete="off"  placeholder="Sebelum Pokok" value="Rp {{number_format($pinjaman->sisa_pokok)}}" readonly>
                    </div>
                    <div class="col-6">
                        <label for="sebelum_jasa">Sebelum Jasa</label>
                        <input type="hidden" class="form-control" autocomplete="off" id="sebelum_jasa" name="sebelum_jasa" placeholder="Sebelum Jasa" value="{{$pinjaman->sisa_jasa}}" readonly>
                        <input type="text" class="form-control" autocomplete="off"  placeholder="Sebelum Jasa" value="Rp {{number_format($pinjaman->sisa_jasa)}}" readonly>
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
$('input[type=number]').keyup(function() {
    var pokok = $('input[name=bayar_pokok]').val();
    var jasa = $('input[name=bayar_jasa]').val();
    var total = parseInt(pokok) + parseInt(jasa);
    $('input[name=total_bayar]').val('Rp ' + new Intl.NumberFormat('id-ID').format(total));
    $('input[name=setelah_pokok]').val('Rp ' + new Intl.NumberFormat('id-ID').format(parseInt($('input[name=sebelum_pokok]').val()) - parseInt(pokok)));
    $('input[name=setelah_jasa]').val('Rp ' + new Intl.NumberFormat('id-ID').format(parseInt($('input[name=sebelum_jasa]').val()) - parseInt(jasa)));
});

$('input[type=number]').trigger('keyup');


</script>
