
<div class="col-lg-3">
    <div class="card">
        <div class="card-body">
            {{-- image lingkaran--}}
            <div class="text-center">
                <h4  class="card_title">Detail Anggota</h4>
                {{-- <img src="dummy internet --}}
                <img src="https://ui-avatars.com/api/?name={{$anggota->nama}}" alt="foto" class="rounded-circle" width="150" height="150">
                <p>Nama : {{$anggota->nama}}</p>
                <p>Sekolah : {{$anggota->sekolah->nama}}</p>

            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body">
            @foreach($sisaSimpanan as $ss)

                    <p> <b>{{ ucwords(str_replace('_', ' ', $ss['nama'])) }}</b> : Rp {{number_format($ss['nominal'], 0, ',', '.')}}</p>
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
        <a href="{{route('petugas.simpanan.show', $anggota->id_anggota)}}?aksi=download" class="btn btn-success" style="float: right">
            <i class="fa fa-file-excel"></i> Download
        </a>
        <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#modalTambahSimpanan" style="float: right; margin-right: 10px">
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
                        <table class="table table-hover progress-table table-striped table-bordered text-center">
                            <thead class="text-uppercase bg-primary">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Bulan</th>
                                @foreach($kategoriSimpanan as $item)
                                    <th scope="col" class="text-capitalize">{{$item->nama}}</th>
                                @endforeach
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                               @foreach($simpanan as $item)
                                    <tr>
                                        <td>{{$loop->iteration }}</td>
                                        @foreach($item as $key => $value)
                                            @if($key == 0)
                                                <td>{{$value}}</td>
                                            @else
                                                <td class="text-right">{{Helper::numericToRupiah($value, 0, ',', '.')}}</td>
                                            @endif
                                        @endforeach
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
                    <p class="m-0">* Isi nominal simpanan yang akan dibayarkan</p>
                    <p class="m-0">* Masukan 0 jika tidak ada simpanan yang dibayarkan</p>
                    <p class="m-0">* Jika terjadi kesalahan, hanya bisa diubah oleh <b>admin</b></p>
                </div>
                <input type="hidden" name="id_anggota" value="{{$anggota->id_anggota}}">
                <div class="row">
                    @foreach($simpananDefault as $s)

                        <div class="col-6">
                            <label for="{{$s['nama']}}">{{ ucwords(str_replace('_', ' ', $s['nama'])) }}</label>
                            <input type="text" class="form-control autonumeric-currency"

                            autocomplete="off" id="{{strtolower(str_replace(' ', '_', $s['nama']))}}" name="{{strtolower(str_replace(' ', '_', $s['nama']))}}" placeholder="{{ ucwords(str_replace('_', ' ', $s['nama'])) }}" value="{{old(strtolower(str_replace(' ', '_', $s['nama']))) ?? $s['jumlah']}}">
                        </div>
                    @endforeach

                    <div class="col-12">
                        <label for="simpanan_suka_rela">Total Bayar</label>
                        <input type="text" class="form-control" autocomplete="off" id="total_bayar" name="total_bayar" placeholder="Total Bayar" value="{{old('total_bayar')}}" readonly>
                    </div>
                    <div class="col-12">
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

 $('.autonumeric-currency').on('keyup', function() {
    @foreach($simpananDefault as $s)
        var {{strtolower(str_replace(' ', '_', $s['nama']))}} = $('#{{strtolower(str_replace(' ', '_', $s['nama']))}}').val();
    @endforeach

    var total_bayar = @foreach($simpananDefault as $s)convertRupiahToNumber({{strtolower(str_replace(' ', '_', $s['nama']))}})+ @endforeach 0;
    total_bayar = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total_bayar);

    $('#total_bayar').val(total_bayar);
 });

$('.autonumeric-currency').trigger('keyup');
</script>

<script>
    $(".autonumeric-currency").autoNumeric("init", { mDec: "0", aSep: ".", aDec: ",", aSign: "Rp " });
</script>
