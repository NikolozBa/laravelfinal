@extends('layouts.app')

@section('content')

    <div class="divider"></div>



    <div class="detailsContainer">
        <div class="block">
            <img src="{{$movie->poster}}">
            <p class="blocktext1">{{$movie->categories}}</p>
            <p class="blocktext2">{{$movie->title}}</p>
            <p class="blocktext3">{{$movie->description}}</p>
            @if(auth()->user() && auth()->user()->priv_level==5)
                <form action="/delete-movie/{{$movie->id}}" method="post">
                    @csrf
                    <button type="submit" style="position: absolute; left: 56%; top: 87%; width: 120px;">Delete Movie</button>
                </form>
                <a href="/edit-movie/{{$movie->id}}">
                    <button type="submit" style="position: absolute; left: 78%; top: 87%; width: 120px;">Edit Movie</button>
                </a>
            @endif

        </div>

        <div class="sessionsContainer"
             style="display: flex; justify-content: center; flex-wrap: wrap; align-content: flex-start">
            <div style="display: flex; justify-content: center; width: 100%; height: 60px">
                <p style="border-bottom: 1px solid">Sessions</p>
            </div>

            <div style="width: 92%; display: flex; flex-wrap: wrap; justify-content: center">
                @if($movie->availability == false)
                    @if(auth()->user() && auth()->user()->priv_level==5)
                        @foreach($sessions as $session)
                            <a href="/sessions/{{$session->id}}">
                                <button
                                    style="width: 120px; height: 60px; margin-left: 8px; margin-top: 8px">{{date("d/m/Y H:i", strtotime($session->date_time))}}</button>
                            </a>
                        @endforeach
                            <form action="/add-session" method="get">
                                <input type="hidden" name="movie_id", value="{{$movie->id}}">
                                <button
                                    style="width: 120px; height: 60px; margin-left: 8px; margin-top: 8px">Add session</button>
                            </form>
                    @else
                    <div
                        style="display: flex; flex-direction: column; justify-content: center; align-items: center; width: 750px; height: 400px; color: #5a6268;">
                        <p>COMING SOON</p>
                    </div>
                    @endif
                @else
                    @if(count($sessions)!=0)
                        @foreach($sessions as $session)
                            <a href="/sessions/{{$session->id}}">
                                <button
                                    style="width: 120px; height: 60px; margin-left: 8px; margin-top: 8px">{{date("d/m/Y H:i", strtotime($session->date_time))}}</button>
                            </a>
                        @endforeach
                            @if(auth()->user() && auth()->user()->priv_level==5)
                                <form action="/add-session" method="get">
                                    <input type="hidden" name="movie_id", value="{{$movie->id}}">
                                    <button
                                        style="width: 120px; height: 60px; margin-left: 8px; margin-top: 8px">Add session</button>
                                </form>
                            @endif
                    @else
                        @if(auth()->user() && auth()->user()->priv_level==5)
                            <form action="/add-session" method="get">
                                <input type="hidden" name="movie_id", value="{{$movie->id}}">
                                <button
                                    style="width: 120px; height: 60px; margin-left: 8px; margin-top: 8px">Add session</button>
                            </form>
                        @else
                        <div
                            style="display: flex; justify-content: center; align-items: center; width: 750px; height: 400px; color: #5a6268;">
                            <p>no sessions for this movie</p>
                        </div>
                        @endif
                    @endif
                @endif
            </div>

        </div>

    </div>


@endsection
