@extends('layouts.master')

@section('title')
   Edit Jawaban
@endsection

@section('content')
    <div class="col-lg-12 my-3 text-left">
        <a href="{{ route('question-detail',['id' => $data->pertanyaan_id]) }}" style="text-decoration:none;"><< Back</a>
    </div>
    <div class="col-lg-12 my-2">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Edit Jawaban</h1>
            </div>
        </div>
        <div class="row mt-4 mb-3">
            <div class="col-lg-12">
                <form action="{{ route('update-answer',['id' => $data->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-md-12 mb-5">
                      <label for="Isi">Isi Jawaban</label>
                      <textarea name="isi" id="Isi" cols="30" rows="10">{!! html_entity_decode($data->jawaban) !!}</textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                  </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/20.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
                .create( document.querySelector( '#Isi' ) )
                .then( editor => {
                          console.log( editor );
                                } )
                .catch( error => {
                            console.error( error );
                     } );
    </script>
@endpush