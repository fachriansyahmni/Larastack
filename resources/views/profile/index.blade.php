@extends('layouts.master')
@section('content')
    <div class="container-sm">
        

          <div class="card text-center">
            <div class="card-header ">
              <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                  <a class="nav-link active" href="#" >Profile</a>
                </li>
              </ul>
            </div>
            <figure class="figure text-center">
              @if (!empty($data->photo))
              <img src="{{ asset('img/profile/'.$data->photo) }}" class="rounded shadow" alt="Img User" width="25%">
              @else
              <img src="{{ asset('img/profile/nophoto.jpg')}}" class="rounded shadow" alt="Img User" width="25%">
              @endif
                
              </figure>
            <div class="card-body">
              <h5 class="card-title">My Profile</h5>
              <p class="card-text">
                <samp>Nama Saya <u>{{ $data->name }}</u>.</samp><br>
                <samp>Nama Lengkap Saya <u>{{ $data->nama_lengkap }}</u>.</samp><br>
                <samp>Email Saya <u>{{ $data->email }}</u>.</samp><br>
                <samp>Saya seorang <u>{{ $data->gender }}</u>.</samp><br>
                <samp>Tanggal lahir Saya <u>{{ $data->tanggal_lahir }}</u>.</samp><br>
                <samp>Saya memiliki reputasi {{$data->reputation}}.</samp>
                <form action="" method="post">
                    @csrf
                </form>
              </p>
              <a href="{{route('question')}}" class="btn btn-primary">Back</a>
              <a href="{{route('edit-home',['id' => $data->user_id])}}" class="btn btn-warning">Edit</a>
            </div>
          </div>
            
    </div>
@endsection