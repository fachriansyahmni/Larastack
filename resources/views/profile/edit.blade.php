@extends('layouts.master')
@section('content')
@php
$ar_gender = ['Laki-Laki'=>'Laki-Laki','Perempuan'=>'Perempuan'];   
@endphp
<div class="x_panel">
    <div class="x_title">
        <h2>Edit Profile </h2>
        
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br>
        <form class="form-label-left input_mask" action="{{ route('update-home',['id' => $data->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-md-6 col-sm-6 form-group has-feedback">
                <div class="col-auto">
                    <label  >Id</label>
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">@</div>
                      </div>
                      <input type="text" class="form-control" name="user_id" value="{{$data->user_id}}">
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 form-group has-feedback">
                <div class="col-auto">
                    <label  >Nama Lengkap</label>
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><li class="fa fa-user"></li></div>
                      </div>
                      <input type="text" class="form-control" id="inputSuccess3" name="nama_lengkap" value="{{$data->nama_lengkap}}" >
                    </div>
                </div>
            </div>
            
            <div class="col-md-12 form-group has-feedback">
                <div class="col-auto">
                <label >Tanggal Lahir</label>
                 <div class="input-group mb-2 ">
                    <input class="date-picker form-control" name="tanggal_lahir" type="date" value="{{$data->tanggal_lahir}}" >
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 form-group has-feedback">
                <div class="col-auto">
                <label class="col-4">Jenis Kelamin</label>
                    <div class="input-group mb-2"> 
                    @foreach($ar_gender as $label => $jk) 
                    @php
                        $cek = ($jk == $data->gender) ? 'checked' : '';
                    @endphp
                        <div class="form-check form-check-inline col-md-3 col-sm-3">
                            <input name="gender"  type="radio" {{$cek}}
                                    class="form-check-input" value="{{ $jk }}"> 
                            <label  class="form-check-label">{{ $label }}</label>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 form-group has-feedback">
                <label>Foto</label>
                <br/>
                <input type="file" class=" is-invalid " name="photo" /> 
                <div class="invalid-feedback"></div>      
              </div>
            <div class="form-group row">
                
            </div>
            <div class="ln_solid"></div>
            <div class="form-group row ">
                <div class="col-md-9 col-sm-9  offset-md-5">
                    <a  href="{{route('home')}}" class="btn btn-primary">Back</a>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection