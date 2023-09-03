
<div class="col-lg-3">
    <div class="card">
        <div class="card-body">
            {{-- image lingkaran--}}
            <div class="text-center">
                <h4  class="card_title">Detail Anggota</h4>
                {{-- <img src="dummy internet --}}
                <img src="https://dummyimage.com/150x150/c4c4/fff"
                alt="foto" class="rounded-circle" width="150" height="150">
                <p>Nama : {{$anggota->nama}}</p>
                <p>Sekolah : {{$anggota->sekolah->nama}}</p>

            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body">
            @foreach($sisaSimpanan as $key => $sisa)
                    <p> <b>{{ ucwords(str_replace('_', ' ', $key)) }}</b>: Rp {{number_format($sisa, 0, ',', '.')}}</p>
            @endforeach
        <a class="btn btn-primary btn-block btn-xs text-white"
        {{-- direct with sesssion --}}
        href="{{route('petugas.penarikan.simpanan')}}?id_anggota={{$anggota->id_anggota}}" target="_blank"

        ><i class="fa fa-print"></i> Tarik Simpanan</a>
        </div>
    </div>
</div>
<div class="col-lg-9">
   <div class="row">
     <div class="col-12 mb-3">
        <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#modalTambahSimpanan" style="float: right">
            <i class="fa fa-plus"></i> Tambah
        </button>
     </div>
     <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card_title">
                    Data Simpanan
                </h4>
                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table table-hover progress-table text-center">
                            <thead class="text-uppercase bg-primary">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Bulan</th>
                                @foreach($kategoriSimpanan as $s)
                                    <th scope="col">{{$s->nama}}</th>
                                @endforeach
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                               @foreach($simpanan as $s)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$s->bulan}}</td>
                                        @foreach($kategoriSimpanan as $ks)
                                            @php
                                                $object = strtolower(str_replace(' ', '_', $ks->nama));
                                                $nominal = $s->$object = $s->$object ?? 0;
                                            @endphp
                                            @if($nominal == 0)
                                                <td>-</td>
                                            @else
                                                <td>Rp {{number_format($nominal, 0, ',', '.')}}</td>
                                            @endif
                                        @endforeach
                                        <td>Rp {{number_format($s->total, 0, ',', '.')}}</td>
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
        <form class="modal-content tambah" action="{{route('petugas.simpanan.store')}}" method="post" autocomplete="off">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Simpanan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <ul class="m-0">
                        <li>Kosongkan simpanan / isi dengan 0 jika tidak ingin menambahkan simpanan / dana khusus.</li>
                        <li>Simpanan pokok, wajib, khusus, karya wisata, hari raya, suka rela, dan dana khusus akan dijumlahkan menjadi total bayar.</li>
                    </ul>
                </div>
                <input type="hidden" name="id_anggota" value="{{$anggota->id_anggota}}">
                <div class="row">
                    @foreach($simpananDefault as $key => $s)
                        <div class="col-6">
                            <label for="{{$key}}">{{ ucwords(str_replace('_', ' ', $key)) }}</label>
                            <input type="number" class="form-control" autocomplete="off" id="{{$key}}" name="{{$key}}" placeholder="{{ ucwords(str_replace('_', ' ', $key)) }}" value="{{old($key) ? old($key) : $s}}">
                        </div>
                    @endforeach

                    <div class="col-12">
                        <label for="simpanan_suka_rela">Total Bayar</label>
                        <input type="text" class="form-control" autocomplete="off" id="total_bayar" name="total_bayar" placeholder="Total Bayar" value="{{old('total_bayar')}}" readonly>
                    </div>
                    <div class="col-6">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" name="keterangan" autocomplete="off" id="keterangan" cols="30" rows="5" placeholder="Keterangan">{{old('keterangan')}}</textarea>
                    </div>
                    <div class="col-6">
                        <label for="tgl_bayar">Tanggal Bayar</label>
                        <input type="date" class="form-control" autocomplete="off" name="tgl_bayar" id="tgl_bayar" value="{{old('tgl_bayar') ?? date('Y-m-d')}}">
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
 $('input[type=number]').on('keyup', function() {
    @foreach($simpananDefault as $key => $s)
        var {{$key}} = $('#{{$key}}').val() || 0;
    @endforeach

    var total_bayar = @foreach($simpananDefault as $key => $s) parseInt({{$key}}) + @endforeach 0;
    total_bayar = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total_bayar);
    $('#total_bayar').val(total_bayar);
 });

$('input[type=number]').trigger('keyup');

</script>
