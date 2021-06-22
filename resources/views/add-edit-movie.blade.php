@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="margin-top: 100px">
                    <div class="card-header">@isset($movie) Edit movie @else Add movie @endisset</div>

                    <div class="card-body">
                        <form method="POST" action="/submit-movie">
                            @csrf

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                           @if(old('title')!=null)
                                                value="{{ old('title') }}"
                                           @else
                                                @isset($movie)
                                                    value="{{$movie->title}}"
                                                @endisset
                                           @endif
                                           required>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>

                                <div class="col-md-6">
                                    <textarea style="height: 110px" id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" required></textarea>

                                    @if(old('description')!=null)
                                        <script>document.getElementById("description").innerHTML="{{ old('description') }}"</script>
                                    @else
                                        @isset($movie)
                                            <script>document.getElementById("description").innerHTML="{{$movie->description}}"</script>
                                        @endisset
                                    @endif

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="poster" class="col-md-4 col-form-label text-md-right">Poster URL</label>

                                <div class="col-md-6">
                                    <input id="poster" type="text" class="form-control @error('poster') is-invalid @enderror" name="poster"
                                           @if(old('poster')!=null)
                                                value="{{ old('poster') }}"
                                           @else
                                                @isset($movie)
                                                    value="{{$movie->poster}}"
                                                @endisset
                                           @endif
                                           required>

                                    @error('poster')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="categories" class="col-md-4 col-form-label text-md-right">Categories</label>

                                <div class="col-md-6">
                                    <input id="categories" type="text" class="form-control @error('categories') is-invalid @enderror" name="categories"
                                           @if(old('categories')!=null)
                                                value="{{ old('categories') }}"
                                           @else
                                                @isset($movie)
                                                    value="{{$movie->categories}}"
                                                @endisset
                                           @endif
                                           required>

                                    @error('categories')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row" style="display: flex; justify-content: space-evenly">
                                <div style="display: flex; justify-content: center">
                                    <label for="available" class="col-md-4 col-form-label text-md-right" style="max-width: 100%">Available</label>
                                    <input type="radio" style="height: 38px" name="availability" id="available" required value="1"
                                        @if(isset($movie) && $movie->availability == true)
                                           checked="checked"
                                        @endif>
                                </div>

                                <div style="display: flex; justify-content: center">
                                    <label for="comingSoon" class="col-md-4 col-form-label text-md-right" style="max-width: 100%; flex: 0 0 92%;">Coming soon</label>
                                    <input type="radio" style="height: 38px" name="availability" id="comingSoon" required value="0"
                                        @if(isset($movie) && $movie->availability == false)
                                           checked="checked"
                                        @endif>
                                </div>

                            </div>

                            @isset($movie)
                                <input type="hidden" name="action" value="edit" >
                                <input type="hidden" name="id" value="{{$movie->id}}">
                            @else
                                <input type="hidden" name="action" value="add" >
                            @endisset

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        @isset($movie)
                                            Edit
                                        @else
                                            Add
                                        @endisset
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
