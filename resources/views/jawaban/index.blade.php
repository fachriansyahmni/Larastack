@extends('layouts.master')

@section('title')
    Jawaban Dari {{ $jawaban->user_id }}
@endsection

@section('content')
    <div class="col-lg-12 my-3 text-left">
        <a href="{{ route('question-detail',['id' => $jawaban->pertanyaan_id]) }}"><button class="btn btn-info">Back</button></a>
    </div>
    <div class="col-lg-12 my-2">
        <div class="row mt-4 mb-3">
            <div class="col-lg-2 text-center">
                <div class="col">
                    @guest
                        <button onclick="cek()" class="btn btn-light" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                    @else
                        @php
                            $cekvotejawaban = DB::table('votejawaban')->join('users','users.id','=','votejawaban.user_id')
                                        ->where(['votejawaban.user_id' => Auth::user()->id, 'votejawaban.jawaban_id' => $jawaban->id])->first();
                        @endphp
                        @if($jawaban->user_id == Auth::user()->id)
                            <button class="btn btn-light mb-2" onclick="votejawaban()" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                        @else
                            @if($cekvotejawaban == null || $cekvotejawaban->vote == 0)
                            <form action="{{ route('vote-jawaban') }}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $jawaban->id }}" name="jawaban_id" >
                                <input type="hidden" value="1" name="vote">
                                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                            </form>
                            @elseif($cekvotejawaban->vote == 1)
                                <button class="btn btn-primary mb-2 active" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                            @endif
                        @endif
                    @endguest
                </div>
                <div class="col">
                    <h3>{{ $jawaban->vote }}</h3>
                </div>
                <div class="col">
                    @guest
                        <button type="button" onclick="cek()"  class="btn btn-light" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">\/</button>
                    @else
                        @if($jawaban->user_id== Auth::user()->id)
                            <button class="btn btn-light mb-2" onclick="votejawaban()" data-toggle="tooltip" data-placement="right" title="Jawaban ini kurang membantu">\/</button>
                        @else
                            @php
                                $cekrep = App\Profile::where('user_id', Auth::user()->id)->first();
                            @endphp
                            @if($cekrep->reputation < 15)
                            <button onclick="validasirep()" class="btn btn-light mb-2" data-toggle="tooltip" data-placement="right" title="Pertanyaan ini kurang bagus">\/</button>
                            @else
                                @if($cekvotejawaban == null || $cekvotejawaban->vote == 1)
                                    <form class="vote" action="{{ route('vote-jawaban') }}" method="POST">
                                        @csrf
                                        <input type="text" value="{{ $jawaban->id }}" name="jawaban_id" hidden>
                                        <input type="text" value="0" name="vote" hidden>
                                        <button type="submit" class="btn btn-light" data-toggle="tooltip" data-placement="right" title="Jawaban ini kurang membantu">\/</button>
                                    </form>
                                @elseif($cekvotejawaban->vote == 0)
                                    <button class="btn btn-primary mb-2 active" data-toggle="tooltip" data-placement="right" title="Pertanyaan ini kurang bagus">\/</button>   
                                @endif
                            @endif
                        @endif
                    @endguest
                </div>
            </div>
            <div class="col-lg-10 mb-4">
                {!! html_entity_decode($jawaban->jawaban) !!}
            </div>
        </div>
        <hr>
        <div class="row mt-3 mb-5">
            <p class="col-12">
                Komentar ({{$totalkomentar}})
            </p>
            {{-- Total Komentar --}}
            @foreach ($komentars as $k)
            <div class="col-lg-2 col-sm-2">
            </div>
            <div class="col-lg-10 col-sm-10">
                @php
                    $komen = strip_tags($k->isi, '');
                    $peoples = DB::table('users')->join('komentar_jawaban','komentar_jawaban.user_id','=','users.id')->where('komentar_jawaban.jawaban_id',$jawaban->id)->first();
                @endphp
                     <p>
                        <b>
                            {{$peoples->name}}</b>@ {!! html_entity_decode($komen) !!}
                    </p>
                    <div class="col text-right">
                        <small>{{ $k->created_at }}</small>
                    </div>
                    <hr style="margin-top: 1px; margin-bottom:1px;">
            </div>
            @endforeach
            <div class="col-lg-12 mt-5">
                <form action="{{ route('store-comment',['id' => $jawaban->id ]) }}" method="POST">
                    @csrf
                    <input type="text" value="{{$jawaban->id}}" name="id_jawaban" hidden>
                    <div class="form-group">
                        <label for="komentar">komentar Kamu</label>
                        <textarea id="komentar" name="komentar"></textarea>
                    </div>
                    <div class="form-group">
                        @guest
                            <button type="button" onclick="cek()"  class="btn btn-primary">Post</button>
                        @else
                        <button type="submit" class="btn btn-primary">Post</button>
                        @endguest
                    </div>
                </form>
                {{-- Forn Komentar --}}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/20.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
                .create( document.querySelector( '#komentar' ) )
                .then( editor => {
                          console.log( editor );
                                } )
                .catch( error => {
                            console.error( error );
                     } );
        
        function cek(){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Login dulu!',
                footer: '<a href=/login>Login</a>'
                })
        }
        function votejawaban(){
            Swal.fire({
                icon: 'error',
                title: 'Tidak bisa memberi vote pada jawaban sendiri'
                })
        }
        function validasirep(){
            Swal.fire({
                icon: 'error',
                title: 'Tidak Bisa Downvote',
                text: 'Downvote Harus Memiliki Reputasi Minimal 15 Poin'
                })
        }
        function cek(){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Login dulu!',
                footer: '<a href=/login>Login</a>'
                })
        }
    </script>
@endpush