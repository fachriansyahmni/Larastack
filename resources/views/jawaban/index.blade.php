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
                    <button class="btn btn-gray btn-sm" data-toggle="tooltip" data-placement="right" title="Jawaban ini membantu">/\</button>
                </div>
                <div class="col">
                    <h3>0</h3>
                </div>
                <div class="col">
                    <button class="btn btn-gray btn-sm" data-toggle="tooltip" data-placement="right" title="Jawaban ini kurang membantu">\/</button>
                </div>
            </div>
            <div class="col-lg-10 mb-4">
                {!! html_entity_decode($jawaban->jawaban) !!}
            </div>
        </div>
        <hr>
        <div class="row mt-3 mb-5">
                Komentar (0)
            {{-- Total Komentar --}}
            <div class="col-lg-12 mt-5">
                <form action="{{ route('store-comment',['id' => $jawaban->id ]) }}" method="POST">
                    @csrf
                    <input type="text" value="{{$jawaban->id}}" name="id_jawaban" hidden>
                    <div class="form-group">
                        <label for="komentar">komentar Kamu</label>
                        <textarea id="komentar" name="komentar"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Post</button>
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
    </script>
@endpush