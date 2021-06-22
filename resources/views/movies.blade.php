@extends('layouts.app')

@section('content')

    <div class="divider"></div>


    <section class="movies">

        <div class="movieContainer">

            @if(count($movies)!=0)
                @foreach($movies as $movie)
                    <a class="block" href="/movies/{{$movie->id}}">
                        <img src="{{$movie->poster}}">
                        <p class="blocktext1">{{$movie->categories}}</p>
                        <p class="blocktext2">{{$movie->title}}</p>
                        <p class="blocktext3">{{$movie->description}}</p>

                    </a>
                @endforeach
            @else
                <div style="width: 100%; height: 530px; display: flex; justify-content: center; align-items: center">
                    <p style="color: #5a6268; font-size: 20px">Nothing to show</p>
                </div>

            @endif

        </div>
    </section>
@endsection
