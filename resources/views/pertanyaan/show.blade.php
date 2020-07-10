@extends('layouts.master')

@section('title')
  {{ $pertanyaan->judul }}
@endsection

@section('content')
    <div class="col-lg-12 my-3 text-left">
        <a href="{{ route('question') }}"><button class="btn btn-info">Back</button></a>
    </div>
    @error('jawabankamu')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="col-lg-12 my-2">
        <div class="row">
            <div class="col-md-12">
                <h1><b>{{ $pertanyaan->judul}} </b></h1>
            </div>
            <div class="col-md-12 mb-2">Asked {{ $pertanyaan->created_at }}<br>
                @if($pertanyaan->updated_at != $pertanyaan->created_at )
                <mark>Updated {{ $pertanyaan->updated_at }} </mark>
                @endif
                <p class="text-right">by <b>{{ $pertanyaan->User->name}}</b></p>
            </div>
            <div class="col-md-12 mb-2" style="text-align: right;">
                <small>
                    @foreach (explode(',',$pertanyaan->tag) as $tag)
                        @if ($tag == "")
                        @else
                            <button class="btn btn-info btn-sm disabled">{{$tag}}</button>
                        @endif
                    @endforeach
                </small>
            </div>
        </div>
        <hr>
        <div class="row mt-4 mb-5">
            <div class="col-lg-2 text-center">
                <div class="col">
                @guest
                    <button type="button" onclick="cek()"  class="btn btn-light" data-toggle="tooltip" data-placement="right" title="Pertanyaan ini bagus">/\</button>
                @else
                @if($pertanyaan->User->id == Auth::user()->id)
                  <button type="button" onclick="votepertanyaan()"  class="btn btn-light" data-toggle="tooltip" data-placement="right" title="Pertanyaan ini bagus">/\</button>
                @else 
                <form action="{{ route('vote-pertanyaan') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $pertanyaan->id }}" name="pertanyaan_id" >
                    <input type="hidden" value="1" name="vote">
                    {{-- @if($cekvote->isEmpty())
                        <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                    @else
                        @foreach ($cekvote as $c)
                            @if($c->user_id == Auth::user()->id && $c->pertanyaan_id == $j->id && $c->vote == 1)
                                <button type="button" class="btn btn-primary active" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                            @elseif($c->user_id != Auth::user()->id && $c->jawaban_id != $j->id) 
                            <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                            @endif
                        @endforeach --}}
                        <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" data-placement="right" title="Pertanyaan ini bagus">/\</button>
                    {{-- @endif --}}
                </form>
                @endif
                @endguest
                </div>
                <div class="col">
                    <h3>{{$pertanyaan->vote}}</h3>
                </div>
                <div class="col">
                    @guest
                    <button type="button" onclick="cek()" class="btn btn-light" data-toggle="tooltip" data-placement="right" title="Pertanyaan ini kurang bagus">\/</button>
                    @else
                    @if($pertanyaan->User->id == Auth::user()->id)
                    <button type="button" onclick="votepertanyaan()"  class="btn btn-light" data-toggle="tooltip" data-placement="right" title="Pertanyaan ini kurang bagus">\/</button>
                    @else 
                    @php
                        $cekrep = App\Profile::where('user_id', Auth::user()->id)->first();
                    @endphp
                    @if($cekrep->reputation < 15)
                    <button type="button" onclick="validasirep()" class="btn btn-light mb-2" data-toggle="tooltip" data-placement="right" title="Pertanyaan ini kurang bagus">\/</button>
                    @else
                    <form action="{{ route('vote-pertanyaan') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $pertanyaan->id }}" name="pertanyaan_id" >
                        <input type="hidden" value="0" name="vote">
                        {{-- @if($cekvote->isEmpty())
                            <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                        @else
                            @foreach ($cekvote as $c)
                                @if($c->user_id == Auth::user()->id && $c->pertanyaan_id == $j->id && $c->vote == 1)
                                    <button type="button" class="btn btn-primary active" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                                @elseif($c->user_id != Auth::user()->id && $c->jawaban_id != $j->id) 
                                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                                @endif
                            @endforeach --}}
                            <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" data-placement="right" title="Pertanyaan ini kurang bagus">\/</button>
                        {{-- @endif --}}
                    </form>
                    @endif
                    @endif
                    @endguest
                </div>
            </div>
            <div class="col-lg-10 mb-4">
                {!! html_entity_decode($pertanyaan->isi) !!}
            </div>
        </div>
        @guest
        @else
        @if($pertanyaan->User->id == Auth::user()->id)
        <div class="col-md-12 text-right">
            <ul class="list-inline" style="display: -webkit-inline-box;">
                <li>
                    <a href="{{ route('edit-question',['id' => $pertanyaan->id]) }}">
                        <button class="btn btn-outline-warning btn-sm">Edit</button>
                    </a>
                </li>
                <li>
                    <form action="{{ route('delete-question',['id' => $pertanyaan->id]) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </li>
            </ul>
        </div>
        
        <p class="mb-5">
            <a href="#" class="text-decoration-none text-muted"><i>add a comment</i></a>
        </p>
        @endif
        @endguest
            Answer ({{$totaljwbn}})
        <div class="row mt-3">
            @foreach ($jawaban as $j)
                <div class="col-lg-2 col-sm-2 mt-2 text-center">
                    <div class="col">
                        @guest
                        <button type="button" onclick="cek()"  class="btn btn-light" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                        @else
                        @php
                            $cekvote = DB::table('votejawaban')->join('users','users.id','=','votejawaban.user_id')->get();
                            $result = $cekvote->count();
                        @endphp
                        <form action="{{ route('vote-jawaban') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $j->id }}" name="jawaban_id" >
                            <input type="hidden" value="1" name="vote">
                            @if($cekvote->isEmpty())
                                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                            @else
                                @foreach ($cekvote as $c)
                                    @if($c->user_id == Auth::user()->id && $c->jawaban_id == $j->id && $c->vote == 1)
                                        <button type="button" class="btn btn-primary active" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                                    @elseif($c->user_id != Auth::user()->id && $c->jawaban_id != $j->id) 
                                    <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                                    @endif
                                @endforeach
                                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                            @endif
                        </form>
                        
                        @endguest
                    </div>
                    <div class="col">
                        <h3>{{$j->vote}}</h3>
                    </div>
                    <div class="col">
                        @guest
                        <button type="button" onclick="cek()"  class="btn btn-light" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">\/</button>
                        @else
                        <form class="vote" action="{{ route('vote-jawaban') }}" method="POST">
                            @csrf
                            <input type="text" value="{{ $j->id }}" name="jawaban_id" hidden>
                            <input type="text" value="0" name="vote" hidden>
                            <button type="submit" class="btn btn-light" data-toggle="tooltip" data-placement="right" title="Jawaban ini kurang membantu">\/</button>
                        </form>
                        @endguest
                    </div>
                    @guest
                    @else
                    @if($pertanyaan->User->id == Auth::user()->id)
                    <div class="col mt-3">
                        <button class="btn btn-outline-success disabled" data-toggle="tooltip" data-placement="right" title="Tetapkan Jawaban Terbaik">Jadikan Jawaban Yang Terbaik</button>
                    </div>
                    @endif
                    @endguest
                </div>
                <div class="col-lg-10 col-sm-10 mb-2">
                    @php
                        $str = strip_tags($j->jawaban, '<p><strong><ol><li><blockquote>');
                    @endphp
                     <p>{!! html_entity_decode($str) !!}</p>
                </div>
                <div class="col-12 mb-3 my-4">
                <div class="blockquote-footer text-right">by <cite title="Source Title">
                    @php
                        $nama = DB::table('users')->join('jawaban','jawaban.user_id','=','users.id')->where('jawaban.id',$j->id)->get();
                    @endphp
                    @foreach($nama as $n)
                        {{$n->name}}<br>
                        {{$n->created_at}}
                    @endforeach
                    </cite> </div>
                <a href="{{ route('answer',$j->id) }}" class="text-decoration-none text-muted"><i>add a comment</i></a>
                     <hr>
                </div>
            @endforeach
            <div class="col-lg-12">
            <form action="{{ route('store-answer',['pertanyaan_id' => $pertanyaan->id ]) }}" method="POST">
                    @csrf
                    <input type="text" value="{{$pertanyaan->id}}" name="id_pertanyaan" hidden>
                    <div class="form-group">
                        <label for="youranswer">Jawaban Kamu</label>
                        <textarea id="youranswer" name="jawabankamu"></textarea>
                    </div>
                    <div class="form-group">
                        @guest
                        <button type="button" onclick="cek()" class="btn btn-primary">Post</button>
                        @else
                        <button type="submit" class="btn btn-primary">Post</button>
                        @endguest
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('ckeditor5-bc/ckeditor.js')}}"></script>
    <script>
        ClassicEditor
                .create( document.querySelector( '#youranswer' ) )
                .then( editor => {
                          console.log( editor );
                                } )
                .catch( error => {
                            console.error( error );
                     } );
    </script>
    <script>
        function cek(){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Login dulu!',
                footer: '<a href=/login>Login</a>'
                })
        }
        function votepertanyaan(){
            Swal.fire({
                icon: 'error',
                title: 'Tidak bisa memberi vote pada pertanyaan sendiri'
                })
        }
        function validasirep(){
            Swal.fire({
                icon: 'error',
                title: 'Tidak Bisa Downvote',
                text: 'Minimal Downvote Reputasi Harus Minimal 15 Poin'
                })
        }
    </script>
@endpush