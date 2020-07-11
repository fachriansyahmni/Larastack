@extends('layouts.master')

@section('title')
  Dashboard {{ $data->name }}
@endsection

@section('content')
    <div class="container-sm">
      <div class="card mt-4 text-center">
          <div class="bg-light">
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fa fa-user"></i> Profile</a>
                <a class="nav-item nav-link" id="nav-pertanyaan-tab" data-toggle="tab" href="#nav-pertanyaan" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fa fa-question"></i> Pertanyaan</a>
              </div>
          </div>
          <div class="card-body mt-4">
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                  <figure class="figure text-center">
                    <img src="{{ asset('img/user-img-default.webp') }}" class="rounded shadow" alt="Img User" width="30%">
                  </figure>
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
                    <a href="{{route('edit-home',['id' => $data->user_id])}}" class="btn btn-primary">Edit</a>
                  </div>
                <div class="tab-pane fade" id="nav-pertanyaan" role="tabpanel" aria-labelledby="nav-pertanyaan-tab">
                    <h1 class="display-5">Pertanyaan Saya</h1>
                    @if($pertanyaan->count() > 0)
                    <div class="text-left mt-3">
                      @foreach ($pertanyaan as $i => $p)  
                      <a href="{{ route('question-detail',['id' => $p->id]) }}">  
                        <div class="card bg-light mb-3">
                          <div class="card-body">
                            @php
                                $totaljwbn = App\Jawaban::where('pertanyaan_id', $p->id)->count();
                            @endphp
                          <p class="card-text">#{{$i+1}} {{ $p->judul }}<kbd class="pull-right">Answers : {{$totaljwbn}}</kbd> <kbd class="pull-right mr-2 bg-success">Votes : {{$p->vote}}</kbd> </p>
                          </div>
                        </div>
                      </a>
                      @endforeach
                    </div>
                    @else 
                    <h5>- Kamu Belum Pernah Bertanya -</h5>
                    <br>
                  <img src="{{ asset('img/nothing.svg') }}" width="220px" alt="">
                    @endif
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection