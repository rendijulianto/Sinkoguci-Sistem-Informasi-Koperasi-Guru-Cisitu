
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
            @foreach($anggota->kategori_simpanan_anggota as $ks)
                    <p> <b>{{$ks->kategori->nama}} : </b> Rp {{number_format($ks->saldo, 0, ',', '.')}}</p>
            @endforeach
        </div>
    </div>
</div>
<div class="col-lg-9">
   <div class="row">
     <div class="col-12 mb-3">
        <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#modalTambahPenarikanSimpanan" style="float: right">
            <i class="fa fa-plus"></i> Tambah
        </button>
     </div>
     <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card_title">
                    Data Penarikan Simpanan
                </h4>
                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table table-hover progress-table text-center">
                            <thead class="text-uppercase bg-primary">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nominal</th>
                                <th>Keterangan</th>
                                <th>Tanggal Penarikan</th>
                                <th>Petugas</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($penarikan as $p)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>Rp {{number_format($p->jumlah, 0, ',', '.')}}</td>
                                    <td>{{$p->keterangan}}</td>
                                    <td>{{$p->tgl_penarikan}}</td>
                                    <td>{{$p->petugas->nama}}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
     </div>
   </div>
</div>
<div class="modal fade" id="modalTambahPenarikanSimpanan">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content tambah" action="{{route('petugas.penarikan.store')}}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Penarikan Simpanan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <ul class="m-0">
                        <li>
                            <b>Saldo Simpanan:</b>
                        </li>
                    @foreach($anggota->kategori_simpanan_anggota as $ks)
                        <li>{{$ks->kategori->nama}} : Rp {{number_format($ks->saldo, 0, ',', '.')}}</li>
                    @endforeach
                    </ul>
                </div>
                <input type="hidden" name="id_anggota" value="{{$anggota->id_anggota}}">
                <div class="row">
                    <div class="col-6">
                        <label for="id_kategori">Kategori Simpanan</label>
                        <select name="id_kategori" id="id_kategori" class="form-control">
                            <option value="" selected disabled>-- Pilih Kategori --</option>
                            @foreach($kategoriSimpanan as $k)
                            <option value="{{$k->id_kategori}}" {{old('id_kategori') == $k->id_kategori ? 'selected' : ''}}>{{$k->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="jumlah">Jumlah Penarikan</label>
                        <input type="number" class="form-control" autocomplete="off" id="jumlah" name="jumlah" placeholder="Jumlah Penarikan" value="{{old('jumlah')}}">
                    </div>
                    <div class="col-6">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" name="keterangan" autocomplete="off" id="keterangan" cols="30" rows="5" placeholder="Keterangan">{{old('keterangan')}}</textarea>
                    </div>
                    <div class="col-6">
                        <label for="tgl_penarikan">Tanggal Penarikan</label>
                        <input type="date" class="form-control" autocomplete="off" name="tgl_penarikan" id="tgl_penarikan" value="{{old('tgl_penarikan') ?? date('Y-m-d')}}">
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


</script>