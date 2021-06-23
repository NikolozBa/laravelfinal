<?php

namespace App\Http\Controllers;

use App\Models\MovieModel;
use App\Models\SessionModel;
use App\Models\TicketModel;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function getMovies(){
        $movies = MovieModel::where('availability', true)->get();
        return view('movies', ['movies'=>$movies]);
    }



    public function getOneMovie($id){
        $movie = MovieModel::where('id', $id)->first();
        $sessions = SessionModel::where('movie_id', $id)->orderby('date_time')->get();
        if($movie==null){
            abort(404);
        }
        return view('movie-details', ['movie' => $movie, 'sessions'=>$sessions]);
    }



    public function getComingMovies(){
        $movies = MovieModel::where('availability', false)->get();
        return view('movies', ['movies'=>$movies]);
    }



    public function addMovie(){
        if(auth()->user()==null || auth()->user()->priv_level < 5){
            abort(404);
        }
        return view("add-edit-movie");
    }



    public function editMovie($id){
        $movie = MovieModel::where('id', $id)->first();
        if(auth()->user()==null || auth()->user()->priv_level < 5 || $movie==null){
            abort(404);
        }
        return view("add-edit-movie", ['movie'=>$movie]);
    }


    public function submitMovie(Request $request){

        $request->validate([
            'title' => 'required|max:30',
            'description' => 'required|max:255',
            'poster' => 'required',
            'categories' => 'required|max:25',
            'availability' => 'required|in:0,1'
        ]);

        $title = $request->post('title');
        $description = $request->post('description');
        $poster = $request->post('poster');
        $categories = $request->post('categories');
        $availability = $request->post('availability');
        $action = $request->post('action');


        if($action=='add'){
            MovieModel::create([
                'title' => $title,
                'description' => $description,
                'poster' => $poster,
                'categories' => $categories,
                'availability' => $availability
            ]);
            return redirect("/movies");
        }


        else if($action=='edit'){
            $id = $request->post('id');
            MovieModel::where('id', $id)->first()->update([
                'title' => $title,
                'description' => $description,
                'poster' => $poster,
                'categories' => $categories,
                'availability' => $availability
            ]);
            return redirect("/movies/{$id}");
        }

        return redirect("/movies");
    }




    public function deleteMovie($id){
        $movie = MovieModel::where('id', $id)->first();
        $sessions = SessionModel::where('movie_id', $id);

        foreach($sessions->get() as $session){
            TicketModel::where('session_id', $session->id)->delete();
        }
        $sessions->delete();
        $movie->delete();

        return redirect("/movies");
    }




    public function test(Request $request){
        //print_r($request->post());

        $pickedTickets = [];
        foreach ($request->post() as $key=>$value){
            $pickedTickets[] = $key;
            //print_r("{$key}");
        }

        print_r($pickedTickets);
    }
}
