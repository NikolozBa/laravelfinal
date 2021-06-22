<?php

namespace App\Http\Controllers;

use App\Models\MovieModel;
use App\Models\SessionModel;
use App\Models\TicketModel;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function getOneSession($id){
        return view('session-details', ['session'=>SessionModel::where('id', $id)->first()]);
    }



    public function addSession(Request $request){
        if(auth()->user()==null || auth()->user()->priv_level < 5 || MovieModel::where('id', $request->get('movie_id'))->first()==null){
            abort(404);
        }
        return view('add-edit-session',['movie_id'=>$request->get('movie_id')]);
    }



    public function editSession($id){
        $session = SessionModel::where('id', $id)->first();
        if(auth()->user()==null || auth()->user()->priv_level < 5 || $session==null){
            abort(404);
        }
        return view("add-edit-session", ['movie_id'=>$session->movie_id, 'session'=>$session]);
    }




    public function submitSession(Request $request){
        $validatedData = $request->validate([
            'date_time' => 'required|date',
            'hall_size' => 'required|integer|in:32,54,98'
        ]);

        if($request->post('action')=='add'){
            $newSession = SessionModel::create([
                'date_time' => $request->post('date_time'),
                'hall_size' => $request->post('hall_size'),
                'movie_id' =>$request->post('movie_id'),
            ]);

            for($i=0; $i<$newSession->hall_size; $i++){
                TicketModel::create([
                    'session_id'=>$newSession->id,
                    'sold'=>false
                ]);
            }

            return redirect("/movies/{$request->post('movie_id')}");
        }

        else if($request->post('action')=='edit'){
            $session = SessionModel::where('id', $request->post('id'))->first();

            if($session->hall_size != $request->post('hall_size')){
                TicketModel::where('session_id', $session->id)->delete();
                for($i=0; $i<$request->post('hall_size'); $i++){
                    TicketModel::create([
                        'session_id'=>$request->post('id'),
                        'sold'=>false
                    ]);
                }
            }

            $session->update([
                'date_time' => $request->post('date_time'),
                'hall_size' => $request->post('hall_size'),
            ]);

            return redirect("/movies/{$request->post('movie_id')}");
        }

    }
}
