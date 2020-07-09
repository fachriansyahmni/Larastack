@extends('layouts.master')

@section('title','Buat Pertanyaan')

@section('content')
    <div class="col-lg-12 my-5">
        <a href="/pertanyaan"><button class="btn btn-info">Back</button></a>
    </div>
    <div class="col-lg-12">
        <form action="{{ route('store-question') }}" method="POST">
                    @csrf
                    <div class="form-group">
                      <label for="judul">Judul</label>
                      <input type="text" class="form-control col-sm-4" id="judul" name="judul" maxlength="120">
                    </div>
                    <div class="form-group">
                      <label for="tag">Tag</label>
                      <textarea class="form-control col-6" id="tag" name="tag" rows="1" placeholder="ex: komputer, elektronik, game"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="isi">Isi</label>
                      <textarea class="form-control" id="newquestion" name="isi" rows="3"></textarea>
                    </div>
                    <div class="form-group" style="text-align: center">
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      <button type="reset" class="btn btn-light">Reset</button>
                    </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('ckeditor5-bc/ckeditor.js')}}"></script>
    <script>
        ClassicEditor
                .create( document.querySelector( '#newquestion' ) )
                .then( editor => {
                          console.log( editor );
                                } )
                .catch( error => {
                            console.error( error );
                     } );
    </script>
@endpush