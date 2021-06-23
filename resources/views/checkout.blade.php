@extends('layouts.app')

@section('content')

    <div style="width: 100%; height: 700px; background-color: #1f1f1f; display: flex; justify-content: space-evenly">

        <div class="horizontalContainer">
            <div class="horizontalContainerHead">
                <p>Selected tickets</p>
            </div>
            <div class="horizontalContainerBody">


                @foreach($tickets as $seat=>$id)
                <div class="horizontalContainerItem" style="background-color: #1c1c1c; text-align: center; height: 45px; line-height: 45px">
                    No. {{$seat}}
                </div>
                @endforeach
            </div>
        </div>

        <div class="horizontalContainer">
            <div class="horizontalContainerHead">
                <p>Checkout</p>
            </div>



            <div class="horizontalContainerBody">

                <form action="/buy-tickets" method="post" id="buyTickets">
                    @csrf

                    @foreach($tickets as $seat=>$id)
                    <input type="hidden" name="{{$seat}}" value="{{$id}}">
                    @endforeach

                    <button onclick="event.preventDefault(); dialog();" class="horizontalContainerItem" >buy</button>
                    <script>
                        function dialog() {
                            if(confirm('Do you really want to buy all of the selected tickets?')){
                                document.getElementById("buyTickets").submit();
                            }
                        }
                    </script>
                </form>
                <a href="/movies">
                    <button class="horizontalContainerItem" >cancel</button>
                </a>

            </div>

        </div>

    </div>


@endsection
