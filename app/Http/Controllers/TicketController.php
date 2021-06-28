<?php

namespace App\Http\Controllers;

use App\Models\MovieModel;
use App\Models\SessionModel;
use App\Models\TicketModel;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function getSelectedTickets(Request $request){

        $pairs = [];
        foreach($request->post() as $key=>$value){
            if($key=='_token'){
                continue;
            }
            $pairs[$key] = $value;
        }
        return view('checkout', ['tickets'=>$pairs]);
    }

    public function buyTickets(Request $request){
        $tickets = [];
        foreach($request->post() as $key=>$value){
            if($key=='_token'){
                continue;
            }
            $tickets[$key] = $value;
        }

        foreach($tickets as $seat_number=>$ticket_id){
            TicketModel::where('id', $ticket_id)->first()->update([
                'sold'=>true,
                'owner'=>auth()->user()->id,
            ]);
        }
        return redirect('/movies');
    }

    public function getYourTickets(){
        if(auth()->user()==null){
            return redirect('/login');
        }

        $your_tickets = TicketModel::where('owner', auth()->user()->id)->get();
        $compiled_data = [
//            [
//                'movie'=>'randtitle',
//                'time'=>'randtime',
//                'seat'=>'seatnum',
//                'id'=>'ticketid'
//            ]
        ];

        foreach ($your_tickets as $ticket){
            $session = SessionModel::where('id', $ticket->session_id)->first();
            $movie = MovieModel::where('id', $session->movie_id)->first();
            $item = [
                'movie'=>$movie->title,
                'time'=>$session->date_time,
                'seat'=>$ticket->seat,
                'id'=>$ticket->id
            ];
            $compiled_data[] = $item;
        }

        return view('your-tickets', ['tickets'=>$compiled_data]);
    }
}
