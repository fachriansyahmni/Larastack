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
                    @php
                        $cekvotepertanyaan = DB::table('votepertanyaan')->join('users','users.id','=','votepertanyaan.user_id')
                                        ->where(['votepertanyaan.user_id' => Auth::user()->id, 'votepertanyaan.pertanyaan_id' => $pertanyaan->id])->first();
                    @endphp
                    @if($cekvotepertanyaan == null || $cekvotepertanyaan->vote == 0)
                        <form action="{{ route('vote-pertanyaan') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $pertanyaan->id }}" name="pertanyaan_id" >
                            <input type="hidden" value="1" name="vote">
                            <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" data-placement="right" title="Pertanyaan ini bagus">/\</button>
                        </form>
                    @elseif($cekvotepertanyaan->vote == 1)
                        <button class="btn btn-primary mb-2 active" data-toggle="tooltip" data-placement="right" title="Pertanyaan ini bagus">/\</button>
                    @endif
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
                                @if($cekvotepertanyaan == null || $cekvotepertanyaan->vote == 1)
                                    <form action="{{ route('vote-pertanyaan') }}" method="POST">
                                        @csrf
                                        <input type="hidden" value="{{ $pertanyaan->id }}" name="pertanyaan_id" >
                                        <input type="hidden" value="0" name="vote">
                                        <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" data-placement="right" title="Pertanyaan ini kurang bagus">\/</button>
                                    </form>
                                @elseif($cekvotepertanyaan->vote == 0)
                                    <button class="btn btn-primary mb-2 active" data-toggle="tooltip" data-placement="right" title="Pertanyaan ini kurang bagus">\/</button>                                    
                                @endif
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
                            <button class="btn btn-outline-info btn-sm" data-toggle="tooltip" data-placement="top" title="Edit Pertanyaan"><i class="fa fa-edit" aria-hidden="true"></i></button>
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('delete-question',['id' => $pertanyaan->id]) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Pertanyaan"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </form>
                    </li>
                </ul>
            </div>
            @endif
        @endguest
        <div class="col-lg-2 col-sm-2">
        </div>
        <div class="col-lg-10 col-sm-10">
            <small>
                @php
                    $komentarpertanyaan = App\KomentarPertanyaan::where('pertanyaan_id',$pertanyaan->id)->latest()->paginate(5);
                @endphp
                @if ($komentarpertanyaan->count() > 0)
                    <hr class="mt-1 mb-1">
                    @foreach ($komentarpertanyaan as $kp)
                        @php
                            $komen = strip_tags($kp->isi, '<b>');
                            $peoples = DB::table('users')->join('komentar_pertanyaan','komentar_pertanyaan.user_id','=','users.id')->where('komentar_pertanyaan.user_id',$kp->user_id)->first();
                        @endphp
                        {!! html_entity_decode(\Illuminate\Support\Str::limit($komen, 100, $end='...')) !!} - <cite title="Source Title">{{$peoples->name}} {{ $kp->created_at }}</cite>
                        <hr class="mt-1 mb-1">
                    @endforeach
                @endif
            </small>
        </div>
        <p class="mb-5">
            <a href="{{route('comments-question',['id' => $pertanyaan->id])}}" class="text-decoration-none text-muted"><i>add a comment</i></a>
        </p>
            Answer ({{$totaljwbn}})
        <div class="row mt-3">
            @foreach ($jawaban as $j)
                <div class="col-lg-2 col-sm-2 mt-2 text-center">
                    <div class="col">
                        @guest
                            <button onclick="cek()" class="btn btn-light" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                        @else
                            @php
                                $cekvotejawaban = DB::table('votejawaban')->join('users','users.id','=','votejawaban.user_id')
                                        ->where(['votejawaban.user_id' => Auth::user()->id, 'votejawaban.jawaban_id' => $j->id])->first();
                            @endphp
                            @if($j->user_id == Auth::user()->id)
                                <button class="btn btn-light mb-2" onclick="votejawaban()" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                            @else
                                @if($cekvotejawaban == null || $cekvotejawaban->vote == 0)
                                <form action="{{ route('vote-jawaban') }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ $j->id }}" name="jawaban_id" >
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
                        <h3>{{$j->vote}}</h3>
                    </div>
                    <div class="col">
                        @guest
                            <button type="button" onclick="cek()"  class="btn btn-light" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">\/</button>
                        @else
                            @if($j->user_id== Auth::user()->id)
                                <button class="btn btn-light mb-2" onclick="votejawaban()" data-toggle="tooltip" data-placement="right" title="Jawaban ini kurang membantu">\/</button>
                            @else
                                @php
                                    $cekrep = App\Profile::where('user_id', Auth::user()->id)->first();
                                @endphp
                                @if($cekrep->reputation < 15)
                                 <button onclick="validasirep()" class="btn btn-light mb-2" data-toggle="tooltip" data-placement="right" title="Jawaban ini kurang membantu">\/</button>
                                @else
                                    @if($cekvotejawaban == null || $cekvotejawaban->vote == 1)
                                        <form class="vote" action="{{ route('vote-jawaban') }}" method="POST">
                                            @csrf
                                            <input type="text" value="{{ $j->id }}" name="jawaban_id" hidden>
                                            <input type="text" value="0" name="vote" hidden>
                                            <button type="submit" class="btn btn-light" data-toggle="tooltip" data-placement="right" title="Jawaban ini kurang membantu">\/</button>
                                        </form>
                                    @elseif($cekvotejawaban->vote == 0)
                                        <button class="btn btn-primary mb-2 active" data-toggle="tooltip" data-placement="right" title="Jawaban ini kurang membantu">\/</button>   
                                    @endif
                                @endif
                            @endif
                        @endguest
                    </div>
                    @guest
                    @else
                        @if($pertanyaan->User->id == Auth::user()->id && $j->is_best == 0)
                        <div class="col mt-3">
                            <form action="{{ route('best-answer') }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id_jawaban" value="{{ $j->id }}">
                                    <button type="submit" class="btn btn-outline-success disabled" data-toggle="tooltip" data-placement="right" title="Tetapkan Jawaban Terbaik">Jadikan Jawaban Yang Terbaik</button>
                            </form>
                        </div>
                        @endif
                    @endguest
                    @if($j->is_best == 1)
                        <button class="btn btn-lg" data-toggle="tooltip" data-placement="right" title="Jawaban Terbaik"><i class="fa fa-check text-success"></i></button>
                        <br>
                        @guest
                        @else
                        @if($pertanyaan->User->id == Auth::user()->id)
                            <button class="btn btn-sm btn-outline-danger disabled" data-toggle="tooltip" data-placement="right" title="Batalkan Jawaban Terbaik"><small>Batalkan Menjadi Jawaban Terbaik</small></button>
                        @endif
                        @endguest
                    @endif  
                </div>
                <div class="col-lg-10 col-sm-10 mb-2">
                    @guest 
                    @else 
                        @if($j->user_id== Auth::user()->id)
                            <form action="{{ route('delete-answer',['id' => $j->id]) }}" method="post" class=" pull-right">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm"><i class="fa fa-trash text-danger"></i> </button>
                            </form>
                            <a href="{{ route('edit-answer',['id' => $j->id]) }}" class="pull-right">
                                <button class="btn btn-sm"><i class="fa fa-edit"></i> </button>
                            </a>
                        @endif
                    @endguest 
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
                    </cite> 
                </div>
                <div class="col-lg-2 col-sm-2">
                </div>
                <div class="col-lg-10 col-sm-10">
                    <small>
                        @php
                            $komentarjawaban = App\KomentarJawaban::where('jawaban_id',$j->id)->latest()->paginate(5);
                        @endphp
                        @if ($komentarjawaban->count() > 0)
                            <hr class="mt-1 mb-1">
                            @foreach ($komentarjawaban as $kj)
                                @php
                                    $komen2 = strip_tags($kj->isi, '<b>');
                                    $peoples2 = DB::table('users')->join('komentar_jawaban','komentar_jawaban.user_id','=','users.id')->where('komentar_jawaban.user_id',$kj->user_id)->get();
                                @endphp
                                {!! html_entity_decode(\Illuminate\Support\Str::limit($komen2, 100, $end='...')) !!} - 
                                <cite title="Source Title">
                                    @foreach ($peoples2 as $p)
                                    {{$p->name}} 
                                    @endforeach
                                    {{ $kj->created_at }}</cite>
                                <hr class="mt-1 mb-1">
                            @endforeach
                        @endif
                    </small>
                </div>
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
    </script>
@endpush