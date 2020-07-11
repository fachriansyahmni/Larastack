@extends('layouts.master')

@section('title','LaraStack')

@section('content')

<div class="col-lg-12 my-2">
    @if ($hitungdata == 0)
    <div class="text-center mt-5">
        <img src="{{ asset('img/bg-blank.svg') }}" width="20%" />
        <h4>Jadilah orang pertama yang bertanya</h4>
    </div>
        @endif
        @foreach ($data as $p)
        <div class="card mb-5 p-2">
            <div class="row no-gutters">
                <div class="col-md-3 text-center" style="align-self: center">
                        @php
                            $totalvote = App\Pertanyaan::where(['id' => $p->id])->get();
                            $totaljwbn = App\Jawaban::where('pertanyaan_id', $p->id)->count();
                        @endphp
                        <div class="col-lg-12 col-md-6">
                            <h3>@foreach ($totalvote as $tv)
                                {{$tv->vote}}
                            @endforeach</h3>
                            <small>votes</small>
                        </div>
                        <div class="col-lg-12 col-md-6 mt-2">
                            <h3>{{$totaljwbn}}</h3>
                            <small>answer</small>
                        </div>
                </div>
                <div class="col-md-9">
                    <div class="card-body">
                        <h5 class="card-title"><a href="{{ route('question-detail',['id' => $p->id ]) }}" class="card-link">{{ $p->judul }}</a></h5>
                          
                            @php
                                $str = strip_tags($p->isi, '');
                            @endphp
                            <p class="card-text mb-4">{!! html_entity_decode(\Illuminate\Support\Str::limit($str, 150, $end='...')) !!}</p>
                            <small>
                                @foreach (explode(',',$p->tag) as $tag)
                                            @if ($tag == "")
                                            @else
                                                <button class="btn btn-info btn-sm disabled">{{$tag}}</button>
                                            @endif
                                        @endforeach
                                        <h6 class="card-subtitle mb-2 text-muted text-right">{{ $p->User->name }}</h6> 
                            </small>
                        </div>
                </div>
            </div>
          </div>
        @endforeach
    </div>
            <div class="text-center">
                {{$data->links()}}
            </div>

@guest
@else
<div class="tambah-pertanyaan">
    <a href="{{ url('/pertanyaan/new') }}">
        <button class="btn btn-warning btn-lg">+</button>
    </a>
</div>
@endguest
@endsection