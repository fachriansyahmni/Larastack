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
            <div class="col-md-12 mb-2">Asked {{ $pertanyaan->created_at }}, Updated {{ $pertanyaan->updated_at }} by <b>{{ $pertanyaan->User->name}}</b></div>
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
                    <a href="#" class="vote-pertanyaan">
                        <button class="btn btn-gray btn-sm" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                    </a>
                </div>
                <div class="col">
                    <h3>0</h3>
                </div>
                <div class="col">
                    <a href="#" class="vote-pertanyaan">
                        <button class="btn btn-gray btn-sm" data-toggle="tooltip" data-placement="right" title="Jawaban ini kurang membantu">\/</button>
                    </a>
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
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="{{ route('edit-question',['id' => $pertanyaan->id]) }}">
                        <button class="btn btn-outline-warning btn-sm">Edit</button>
                    </a>
                </li>
                <li class="list-inline-item">
                    <form action="{{ route('delete-question',['id' => $pertanyaan->id]) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </li>
            </ul>
        </div>
        @endif
        @endguest
            Answer ({{$totaljwbn}})
        <div class="row mt-3">
            @foreach ($jawaban as $j)
                <div class="col-lg-2 col-sm-2 mt-2 text-center">
                    <div class="col">
                        <button class="btn btn-gray" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                    </div>
                    <div class="col">
                        <h3>0</h3>
                    </div>
                    <div class="col">
                        <button class="btn btn-gray" data-toggle="tooltip" data-placement="right" title="Jawaban ini kurang membantu">\/</button>
                    </div>
                    <div class="col">
                        <button class="btn btn-success disabled" data-toggle="tooltip" data-placement="right" title="Jawaban ini paling tepat">Ya</button>
                    </div>
                </div>
                <div class="col-lg-10 col-sm-10 mb-2">
                    @php
                        $str = strip_tags($j->jawaban, '<p><strong><ol><li><blockquote>');
                    @endphp
                     <p>{!! html_entity_decode($str) !!}</p>
                </div>
                <div class="col-12 mb-3 my-4">
                <footer class="blockquote-footer text-right">by <cite title="Source Title">{{ $j->user_id }}</cite> </footer>
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
                        <button type="submit" class="btn btn-primary">Post</button>
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
@endpush