@extends('layouts.app')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
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
<div class="row mb-4">
    <div class="col-12">
        <div class="form-group">
            <label class="col-form-label">Pilih Anggota</label>
            <br>
            <select class="custom-select select2" fdprocessedid="bq1eom" id="anggota">
                <option selected disabled> -- Pilih Anggota -- </option>
                @foreach ($anggota as $ak)
                <option value="{{$ak->id_anggota}}" >{{$ak->nama}} -  {{$ak->sekolah->nama}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div id="result" class="row mb-4"></div>
 @endsection
 @section('js')
 <script>
    
 $(document).ready(function() {
     $('.select2').select2();
    @if(old('id_anggota'))
        $('#anggota').val('{{old('id_anggota')}}').trigger('change');
    @elseif(Request::get('id_anggota'))
        $('#anggota').val('{{Request::get('id_anggota')}}').trigger('change');
    @endif
    //  jalan ajax
 });
 $('#anggota').on('change', function() {
         $('#result').html('');
         var id = $(this).val();
         var url = "{{route('petugas.penarikan.show', ':id')}}";
         url = url.replace(':id', id);
         $.ajax({
             url: url,
             type: "GET",
             beforeSend: function() {
                 $('#result').html('<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
             },
             success: function(data) {
                    $('#result').html(data);
             },
            error: function(data) {
                console.log(data);
            },
         });
     });
 </script>
 @endsection
