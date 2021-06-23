@extends('layouts.app')

@section('content')

    <div class="divider"></div>


    <section class="ticketsSection">
        <div style="display: flex; flex-direction: column; justify-content: center; background-color: #2B2B35; border-radius: 5px; padding: 30px">
            <p style="text-align: center">{{date("d M Y H:i", strtotime($session->date_time))}}</p>

        {{--        hook up to the proper route--}}
        <form action="/checkout" method="post" id="ticketform">
            @csrf

            @if($session->hall_size==32)
                @for($i=0; $i<4; $i++)
                    <div style="display: flex; flex-direction: row">
                        @for($j=0; $j<8; $j++)

                            <script>
                                {{$ticket = $tickets[$i*8+$j]}}
                            </script>

                            <div @if($ticket->sold==false) onclick="check({{$ticket->seat}})" @endif id="{{$ticket->seat}}" class="ticketBox @if($ticket->sold==true) unavailable @else unchecked @endif" style="width: 66px; height: 66px">
                                {{$ticket->seat}}
                            </div>
                            @if($ticket->sold==false)
                            <input class="checkBox" autocomplete="off" id="{{$ticket->seat}}c" style="display: none" type="checkbox" name="{{$ticket->seat}}" value="{{$ticket->id}}" >
                            @endif

                        @endfor
                    </div>
                @endfor
            @elseif($session->hall_size==54)
                @for($i=0; $i<6; $i++)
                    <div style="display: flex; flex-direction: row">
                        @for($j=0; $j<9; $j++)

                            <script>
                                {{$ticket= $tickets[$i*9+$j]}}
                            </script>

                            <div @if($ticket->sold==false) onclick="check({{$ticket->seat}})" @endif id="{{$ticket->seat}}" class="ticketBox @if($ticket->sold==true) unavailable @else unchecked @endif" style="width: 60px; height: 60px">
                                {{$ticket->seat}}
                            </div>
                            @if($ticket->sold==false)
                            <input class="checkBox" autocomplete="off" id="{{$ticket->seat}}c" style="display: none" type="checkbox" name="{{$ticket->seat}}" value="{{$ticket->id}}" >
                            @endif
                        @endfor
                    </div>
                @endfor
            @elseif($session->hall_size==98)
                @for($i=0; $i<7; $i++)
                    <div style="display: flex; flex-direction: row">
                        @for($j=0; $j<14; $j++)

                            <script>
                                {{$ticket = $tickets[$i*14+$j]}}
                            </script>

                            <div @if($ticket->sold==false) onclick="check({{$ticket->seat}})" @endif id="{{$ticket->seat}}" class="ticketBox @if($ticket->sold==true) unavailable @else unchecked @endif">
                                {{$ticket->seat}}
                            </div>
                            @if($ticket->sold==false)
                            <input class="checkBox" autocomplete="off" id="{{$ticket->seat}}c" style="display: none" type="checkbox" name="{{$ticket->seat}}" value="{{$ticket->id}}" >
                            @endif

                        @endfor
                    </div>
                @endfor
            @endif

            @guest
                <div style="display: flex; justify-content: center; margin-top: 20px">
                    <a href="/login">
                        <button type="button" style="width: 100px">Continue</button>
                    </a>
                </div>
            @else
                <div style="display: flex; justify-content: center; margin-top: 20px">
                    <button onclick="event.preventDefault(); checkIfEmpty()" type="button" style="width: 100px">Continue</button>
                </div>
            @endguest

        </form>

            @if(auth()->user() && auth()->user()->priv_level==5)
            <div style="display: flex; justify-content: center; margin-top: 10px">
                <form action="/delete-session/{{$session->id}}" method="post" id="deleteSession">
                    @csrf
                    <button onclick="event.preventDefault(); dialog();" style="width: 135px; margin-right: 10px">Delete Session
                    </button>
                    <script>
                        function dialog() {
                            if(confirm('Do you really want to delete this session and all of its tickets?')){
                                document.getElementById("deleteSession").submit();
                            }
                        }
                    </script>
                </form>
                <a href="/edit-session/{{$session->id}}"><button style="width: 135px; margin-left: 10px">Edit Session</button></a>
            </div>
            @endif

        </div>
    </section>

    <script>
        function check(id) {
            let checkBox = document.getElementById(id + 'c');
            let ticketBox = document.getElementById(id);

            if (checkBox.checked == false) {
                ticketBox.classList.add("checked")
                ticketBox.classList.remove("unchecked");
                checkBox.checked = true;
            } else {
                ticketBox.classList.add("unchecked")
                ticketBox.classList.remove("checked");
                checkBox.checked = false;
            }
        }


        function checkIfEmpty(){
            let list = document.getElementsByClassName('checkBox');
            let i=0;
            for (; i < list.length; i++) {
                if(list[i].checked == true){
                    document.getElementById("ticketform").submit();
                    break;
                }
            }
            if(i==list.length){
                alert("You dont have any tickets selected.");
            }

        }

    </script>

@endsection
