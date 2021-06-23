@extends('layouts.app')

@section('content')

    <div style="width: 100%; height: 700px; background-color: #1f1f1f; display: flex; justify-content: space-evenly">

        <div class="horizontalContainer">
            <div class="horizontalContainerHead">
                <p>Your tickets</p>
            </div>
            <div class="horizontalContainerBody">


                @foreach($tickets as $ticket)
                    <div class="horizontalContainerItem" style="background-color: #1c1c1c;width: 300px;height: 55px;display: flex;flex-flow: column wrap;line-height: 23px;justify-content: center;align-items: center;">
                        <div style="left: 10%">{{$ticket['movie']}}</div>
                        <div>{{date("d/m/Y H:i", strtotime($ticket['time']))}}</div>
                        <div>seat No. {{$ticket['seat']}}</div>
                        <div>ticket id {{$ticket['id']}}</div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>


@endsection
