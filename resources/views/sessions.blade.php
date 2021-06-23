@extends('layouts.app')

@section('content')

    <div style="width: 100%; background-color: #1f1f1f; display: flex; justify-content: space-evenly">

        <div class="horizontalContainer" style="height: fit-content; padding-bottom: 60px">

            @foreach($data as $movie=>$sessions)

                <div class="horizontalContainerHead"><p>{{$movie}}</p></div>

                @foreach($sessions as $session)

                    <a href="/sessions/{{$session['id']}}">
                        <button class="horizontalContainerItem">{{date("d/m/Y H:i", strtotime($session['time']))}}</button>
                    </a>
                @endforeach

            @endforeach

        </div>

    </div>


@endsection
