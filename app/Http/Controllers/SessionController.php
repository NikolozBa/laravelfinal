<?php

namespace App\Http\Controllers;

use App\Models\MovieModel;
use App\Models\SessionModel;
use App\Models\TicketModel;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function getSessions(){
        $movies = MovieModel::where('availability', true)->orderBy('title')->get();

        $compiled_data = [
//            'movie'=>[
//                's1'=>['time'=>'asd','id'=>'iii'],
//                's2'=>['time'=>'asd','id'=>'iii'],
//                's3'=>['time'=>'asd','id'=>'iii'],
//            ],
        ];

        foreach($movies as $movie){
            $compiled_data[$movie->title] = [];
            $sessions = SessionModel::where('movie_id', $movie->id)->orderBy('date_time')->get();
            foreach ($sessions as $session){
                $time_and_id = [];
                $time_and_id['time']=$session->date_time;
                $time_and_id['id']=$session->id;
                $compiled_data[$movie->title][]=$time_and_id;
            }
        }

        return view('sessions', ['data'=>$compiled_data]);

    }

    public function getOneSession($id){
        $session = SessionModel::where('id', $id)->first();
        $tickets = TicketModel::where('session_id', $id)->orderby('seat')->get();
        $movie = MovieModel::where('id', $session->movie_id)->first();
        if($session==null){
            abort(404);
        }
        if(!$movie->availability){
            abort(404);
        }
        return view('session-details', ['session'=>$session, 'tickets'=>$tickets]);
    }



    public function addSession(Request $request){
        $movie_id = $request->get('movie_id');
        if(auth()->user()==null || auth()->user()->priv_level < 5 || MovieModel::where('id', $movie_id)->first()==null){
            abort(404);
        }
        return view('add-edit-session',['movie_id'=>$movie_id]);
    }



    public function editSession($id){
        $session = SessionModel::where('id', $id)->first();
        if(auth()->user()==null || auth()->user()->priv_level < 5 || $session==null){
            abort(404);
        }
        return view("add-edit-session", ['session'=>$session]);
    }




    public function submitSession(Request $request){
        $request->validate([
            'date_time' => 'required|date',
            'hall_size' => 'required|integer|in:32,54,98'
        ]);

        $date_time = $request->post('date_time');
        $hall_size = $request->post('hall_size');
        $action = $request->post('action');

        if($action=='add'){
            $movie_id = $request->get('movie_id');
            $newSession = SessionModel::create([
                'date_time' => $date_time,
                'hall_size' => $hall_size,
                'movie_id' =>$movie_id,
            ]);
            for($i=0; $i<$hall_size; $i++){
                TicketModel::create([
                    'session_id'=>$newSession->id,
                    'sold'=>false,
                    'seat'=>$i+1
                ]);
            }
            return redirect("/movies/$movie_id");
        }


        else if($action=='edit'){
            $session = SessionModel::where('id', $request->post('id'))->first();

            if($session->hall_size != $hall_size){
                TicketModel::where('session_id', $session->id)->delete();
                for($i=0; $i<$hall_size; $i++){
                    TicketModel::create([
                        'session_id'=>$session->id,
                        'sold'=>false
                    ]);
                }
            }

            $session->update([
                'date_time' => $date_time,
                'hall_size' => $hall_size,
            ]);

            return redirect("/sessions/{$session->id}");
        }

        return redirect("/movies");
    }

    public function deleteSession($id){
        $session = SessionModel::where('id',$id)->first();
        TicketModel::where('session_id', $id)->delete();
        $session->delete();
        return redirect("/movies/{$session->movie_id}");
    }
}
