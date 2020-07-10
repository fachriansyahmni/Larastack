@extends('layouts.master')
@section('content')
    <div class="container-sm">
        

          <div class="card text-center">
            <div class="card-header ">
              <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                  <a class="nav-link" href="#">Tanya</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Jawab</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="#" >Profile</a>
                </li>
              </ul>
            </div>
            <figure class="figure text-center">
                <img src="{{ asset('img/user-img-default.webp') }}" class="rounded shadow" alt="Img User" width="30%">
              </figure>
            <div class="card-body">
              <h5 class="card-title">My Profile</h5>
              <p class="card-text">
                <samp>Nama Saya <u>{{ $data->name }}</u>.</samp><br>
                <samp>Nama Lengkap Saya <u>{{ $data->nama_lengkap }}</u>- .</samp><br>
                <samp>Email Saya <u>{{ $data->email }}</u>- .</samp><br>
                <samp>Saya seorang <u>{{ $data->gender }}</u>- .</samp><br>
                <samp>Tanggal lahir Saya <u>{{ $data->tanggal_lahir }}</u>- .</samp><br>
                <samp>Saya memiliki reputasi {{$data->reputation}}.</samp>
                <form action="" method="post">
                    @csrf
                </form>
              </p>
              <a href="#" class="btn btn-primary">Back</a>
              <a href="{{route('edit-home',['id' => $data->user_id])}}" class="btn btn-primary">Edit</a>
            </div>
          </div>
            
    </div>
@endsection