<?php

namespace App\Http\Controllers;

use App\Models\MovieModel;
use App\Models\SessionModel;
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

        print_r($request->post());
        $validatedData = $request->validate([
            'title' => 'required|max:30',
            'description' => 'required|max:255',
            'poster' => 'required',
            'categories' => 'required|max:25',
            'availability' => 'required|in:0,1'
        ]);

        if($request->post('action')=='add'){
            MovieModel::create([
                'title' => $request->post('title'),
                'description' => $request->post('description'),
                'poster' => $request->post('poster'),
                'categories' => $request->post('categories'),
                'availability' => $request->post('availability')
            ]);
            return redirect("/movies");
        }


        else if($request->post('action')=='edit'){
            MovieModel::where('id', $request->post('id'))->first()->update([
                'title' => $request->post('title'),
                'description' => $request->post('description'),
                'poster' => $request->post('poster'),
                'categories' => $request->post('categories'),
                'availability' => $request->post('availability')
            ]);
            return redirect("/movies/{$request->post('id')}");
        }

        return redirect("/movies");
    }





    //not yet implemented


    public function deleteMovie($id){
        print_r("asdasddd");
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
