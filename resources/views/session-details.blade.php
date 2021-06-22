@extends('layouts.app')

@section('content')

    <div class="divider"></div>


    <section class="ticketsSection">
        <div style="display: flex; flex-direction: column; justify-content: center; background-color: #2B2B35; border-radius: 5px; padding: 30px">

        {{--        hook up to the proper route--}}
        <form action="/test" method="post" id="ticketform">
            @csrf

            @if($session->hall_size==32)
                @for($i=0; $i<4; $i++)
                    <div style="display: flex; flex-direction: row">
                        @for($j=0; $j<8; $j++)

                            {{--                    cleanup on ile six lol--}}

                            <div onclick="check({{$i*8+$j+1}})" id="{{$i*8+$j+1}}" class="ticketBox unchecked"
                                 style="width: 66px; height: 66px">{{$i*8+$j+1}}</div>
                            <input class="checkBox" id="{{$i*8+$j+1}}c" style="display: none" type="checkbox" name="{{$i*8+$j+1}}"
                                   value="checked" >
                        @endfor
                    </div>
                @endfor
            @elseif($session->hall_size==54)
                @for($i=0; $i<6; $i++)
                    <div style="display: flex; flex-direction: row">
                        @for($j=0; $j<9; $j++)
                            <div class="ticketBox" style="width: 60px; height: 60px">{{$i*9+$j+1}}</div>
                        @endfor
                    </div>
                @endfor
            @elseif($session->hall_size==98)
                @for($i=0; $i<7; $i++)
                    <div style="display: flex; flex-direction: row">
                        @for($j=0; $j<14; $j++)
                            <div class="ticketBox">{{$i*14+$j+1}}</div>
                        @endfor
                    </div>
                @endfor
            @endif

            @guest
                <div style="display: flex; justify-content: center; margin-top: 20px">
                    <a href="/login">
                        <button type="button" style="width: 100px">Buy</button>
                    </a>
                </div>
            @else
                <div style="display: flex; justify-content: center; margin-top: 20px">
                    <button onclick="event.preventDefault(); checkIfEmpty()" type="button" style="width: 100px">Buy</button>
                </div>
            @endguest

        </form>

            @if(auth()->user() && auth()->user()->priv_level==5)
            <div style="display: flex; justify-content: center; margin-top: 10px">
                <a href="/home"><button style="width: 135px; margin-right: 10px">Delete Session</button></a>
                <a href="/edit-session/{{$session->id}}"><button style="width: 135px; margin-left: 10px">Edit Session</button></a>
            </div>
            @endif

        </div>
    </section>

@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!--suppress VueDuplicateTag -->
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
        for (let i = 0; i < list.length; i++) {
            if(list[i].checked == true){
                document.getElementById("ticketform").submit();
            }
        }
    }


    $( document ).ready(function() {
            let list = document.getElementsByClassName('checkBox');
            for (let i = 0; i < list.length; i++) {
                if(list[i].checked == true){
                    let box = document.getElementById((i+1).toString())
                    box.classList.add("checked");
                    box.classList.remove("unchecked");
                }
            }
    });

</script>
