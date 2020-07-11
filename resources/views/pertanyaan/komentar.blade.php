@extends('layouts.master')

@section('title')
  {{ $data->judul }}
@endsection

@section('content')
<div class="col-lg-12 my-3 text-left">
    <a href="{{ route('question-detail',['id' => $data->id]) }}"><button class="btn btn-info">Back</button></a>
</div>
<div class="col-lg-12 my-2">
    <div class="row mt-4 mb-3">
        <div class="col-lg-2 text-center">
            <div class="col">
                @guest
                    <button onclick="cek()" class="btn btn-light" data-toggle="tooltip" data-placement="right" title="Pertanyaan ini bagus">/\</button>
                @else
                    @php
                        $cekvotepertanyaan = DB::table('votepertanyaan')->join('users','users.id','=','votepertanyaan.user_id')
                                    ->where(['votepertanyaan.user_id' => Auth::user()->id, 'votepertanyaan.pertanyaan_id' => $data->id])->first();
                    @endphp
                    @if($data->penanya_id == Auth::user()->id)
                        <button class="btn btn-light mb-2" onclick="votepertanyaan()" data-toggle="tooltip" data-placement="right" title="Pertanyaan ini bagus">/\</button>
                    @else
                        @if($cekvotepertanyaan == null || $cekvotepertanyaan->vote == 0)
                        <form action="{{ route('vote-pertanyaan') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $data->id }}" name="pertanyaan_id" >
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
                <h3>{{ $data->vote }}</h3>
            </div>
            <div class="col">
                @guest
                    <button type="button" onclick="cek()"  class="btn btn-light" data-toggle="tooltip" data-placement="right" title="Pertanyaan ini kurang bagus">\/</button>
                @else
                    @if($data->penanya_id== Auth::user()->id)
                        <button class="btn btn-light mb-2" onclick="votepertanyaan()" data-toggle="tooltip" data-placement="right" title="Pertanyaan ini kurang bagus">\/</button>
                    @else
                        @php
                            $cekrep = App\Profile::where('user_id', Auth::user()->id)->first();
                        @endphp
                        @if($cekrep->reputation < 15)
                            <button   button onclick="validasirep()" class="btn btn-light mb-2" data-toggle="tooltip" data-placement="right" title="Pertanyaan ini kurang bagus">\/</button>
                        @else
                            @if($cekvotepertanyaan == null || $cekvotepertanyaan->vote == 1)
                                <form class="vote" action="{{ route('vote-pertanyaan') }}" method="POST">
                                    @csrf
                                    <input type="text" value="{{ $data->id }}" name="pertanyaan_id" hidden>
                                    <input type="text" value="0" name="vote" hidden>
                                    <button type="submit" class="btn btn-light" data-toggle="tooltip" data-placement="right" title="Pertanyaan ini kurang bagus">\/</button>
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
            {!! html_entity_decode($data->isi) !!}
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
        <div class="col-lg-10 col-sm-10 mt-2">
            @php
                $komen = strip_tags($k->isi, '<b>');
                $peoples = DB::table('users')->join('komentar_pertanyaan','komentar_pertanyaan.user_id','=','users.id')->where('komentar_pertanyaan.pertanyaan_id',$data->id)->first();
            @endphp
                    {!! html_entity_decode($komen) !!} <p class="blockquote-footer"><cite title="Source Title">{{$peoples->name}} {{ $k->created_at }}</cite>
                    @guest
                    @else    
                        @if ($k->user_id == Auth::user()->id)
                            <a href="#" class="pull-right" data-toggle="tooltip" data-placement="top" title="Hapus Pertanyaan"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <a href="#" class="pull-right mr-2" data-toggle="tooltip" data-placement="top" title="Edit Pertanyaan"><i class="fa fa-edit" aria-hidden="true"></i></a>
                        @endif
                    @endguest
                </p>
                
                <hr style="margin-top: 1px; margin-bottom:1px;">
        </div>
        @endforeach
        <div class="col-lg-12 mt-5">
            <form action="{{ route('store-comment-pertanyaan',['id' => $data->id ]) }}" method="POST">
                @csrf
                <input type="text" value="{{$data->id}}" name="id_pertanyaan" hidden>
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
        function votepertanyaan(){
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