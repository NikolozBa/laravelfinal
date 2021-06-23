@extends('layouts.app')

@section('content')





    <div class="detailsContainer">
        <div class="block" style="margin-top: 116px">
            <img src="{{$movie->poster}}">
            <p class="blocktext1">{{$movie->categories}}</p>
            <p class="blocktext2">{{$movie->title}}</p>
            <p class="blocktext3">{{$movie->description}}</p>
            @if(auth()->user() && auth()->user()->priv_level==5)
                <form action="/delete-movie/{{$movie->id}}" method="post" id="deleteMovie">
                    @csrf
                    <button type="submit" onclick="event.preventDefault(); dialog();" style="position: absolute; left: 56%; top: 87%; width: 120px;">Delete Movie</button>
                    <script>
                        function dialog() {
                            if(confirm('Do you really want to delete this movie and all of its sessions?')){
                                document.getElementById("deleteMovie").submit();
                            }
                        }
                    </script>
                </form>
                <a href="/edit-movie/{{$movie->id}}">
                    <button type="submit" style="position: absolute; left: 78%; top: 87%; width: 120px;">Edit Movie</button>
                </a>
            @endif

        </div>

        <div class="horizontalContainer">
            <div class="horizontalContainerHead">
                <p>Sessions</p>
            </div>

            <div class="horizontalContainerBody">
                @if($movie->availability == false)
                    @if(auth()->user() && auth()->user()->priv_level==5)
                        @foreach($sessions as $session)
                            <a href="/sessions/{{$session->id}}">
                                <button class="horizontalContainerItem">{{date("d/m/Y H:i", strtotime($session->date_time))}}</button>
                            </a>
                        @endforeach
                            <form action="/add-session" method="get">
                                <input type="hidden" name="movie_id", value="{{$movie->id}}">
                                <button class="horizontalContainerItem">Add session</button>
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
                                <button class="horizontalContainerItem">{{date("d/m/Y H:i", strtotime($session->date_time))}}</button>
                            </a>
                        @endforeach
                            @if(auth()->user() && auth()->user()->priv_level==5)
                                <form action="/add-session" method="get">
                                    <input type="hidden" name="movie_id", value="{{$movie->id}}">
                                    <button class="horizontalContainerItem">Add session</button>
                                </form>
                            @endif
                    @else
                        @if(auth()->user() && auth()->user()->priv_level==5)
                            <form action="/add-session" method="get">
                                <input type="hidden" name="movie_id", value="{{$movie->id}}">
                                <button class="horizontalContainerItem">Add session</button>
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
