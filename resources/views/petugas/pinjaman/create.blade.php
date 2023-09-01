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
<form class="row mb-4">
   <div class="col-lg-3">
         <div class="form-group">
              <label class="col-form-label">Tanggal Awal</label>
              <br>
                <input type="date" class="form-control" name="tgl_awal" value="{{old('tgl_awal')}}">
         </div>
   </div>
    <div class="col-lg-3">
            <div class="form-group">
                  <label class="col-form-label">Tanggal Akhir</label>
                  <br>
                 <input type="date" class="form-control" name="tgl_akhir" value="{{old('tgl_akhir')}}">
            </div>
    </div>
</form>

 @endsection
 @section('js')

 @endsection
