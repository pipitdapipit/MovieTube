<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieTubeController extends Controller
{
    public function index(){
        $baseURL = env('MOVIETUBE_DB_URL');
        $imageBaseUrl = env('MOVIETUBE_DB_IMAGE');
        $apiKey = env('MOVIETUBE_DB_API_KEY');
        $max_banner = 3;
        $max_movies = 10;
        $max_tvshows = 10;

        // API Banner
        $bannerRespone = Http::get("{$baseURL}/trending/movie/week", [
            'api_key' => $apiKey,
        ]);

        $bannerArray = [];

        if($bannerRespone->successful()){
            $resultArray = $bannerRespone->object()->results;
        }

        if(isset($resultArray)){
            foreach($resultArray as $items){
                array_push($bannerArray, $items);

                if(count($bannerArray) == $max_banner){
                    break;
                }
            }
        }

        // Top 10 Movies
        $top10MoviesResponse = Http::get("{$baseURL}/movie/top_rated", [
            'api_key' => $apiKey,
        ]);

        $top10MoviesArray = [];

        if($top10MoviesResponse->successful()){
            $resultArray = $top10MoviesResponse->object()->results;
            if(isset($resultArray)){
                foreach($resultArray as $items){
                    array_push($top10MoviesArray, $items);

                    if(count($top10MoviesArray) == $max_tvshows){
                        break;
                    }
                }
            }
        }

        // Top 10 TV Shows
        $top10TVShowsResponse = Http::get("{$baseURL}/tv/top_rated", [
            'api_key' => $apiKey,
        ]);

        $top10TVShowsArray = [];

        if($top10TVShowsResponse->successful()){
            $resultArray = $top10TVShowsResponse->object()->results;
            if(isset($resultArray)){
                foreach($resultArray as $items){
                    array_push($top10TVShowsArray, $items);

                    if(count($top10TVShowsArray) == $max_movies){
                        break;
                    }
                }
            }
        }


        return view('home', [
            'baseURL' => $baseURL,
            'imageBaseURL' => $imageBaseUrl,
            'apiKey' => $apiKey,
            'banner' => $bannerArray,
            'topMovies' => $top10MoviesArray,
            'topTVShows' => $top10TVShowsArray
        ]);
    }

    public function movies(){
        $baseURL = env('MOVIETUBE_DB_URL');
        $imageBaseUrl = env('MOVIETUBE_DB_IMAGE');
        $apiKey = env('MOVIETUBE_DB_API_KEY');
        $sortBy = 'popularity.desc';
        $page = 1;
        $minimalVoter = 100;

        $movieResponse = Http::get("{$baseURL}/discover/movie", [
            'api_key' => $apiKey,
            'sort_by' => $sortBy,
            'vote_count.gte' => $minimalVoter,
            'page' => $page
        ]);

        $moviesArray = [];

        if($movieResponse->successful()){
            $resultArray = $movieResponse->object()->results;
            if(isset($resultArray)){
                foreach($resultArray as $items){
                    array_push($moviesArray, $items);
                }
            }
        }

        return view('movie', [
            'baseURL' => $baseURL,
            'imageBaseURL' => $imageBaseUrl,
            'apiKey' => $apiKey,
            'movies' => $moviesArray,
            'sortBy' => $sortBy,
            'page' => $page,
            'minimalVoter' => $minimalVoter
        ]);
    }

    public function tvshows(){
        $baseURL = env('MOVIETUBE_DB_URL');
        $imageBaseUrl = env('MOVIETUBE_DB_IMAGE');
        $apiKey = env('MOVIETUBE_DB_API_KEY');
        $sortBy = 'popularity.desc';
        $page = 1;
        $minimalVoter = 100;

        $TVResponse = Http::get("{$baseURL}/discover/tv", [
            'api_key' => $apiKey,
            'sort_by' => $sortBy,
            'vote_count.gte' => $minimalVoter,
            'page' => $page
        ]);

        $TVArray = [];

        if($TVResponse->successful()){
            $resultArray = $TVResponse->object()->results;
            if(isset($resultArray)){
                foreach($resultArray as $items){
                    array_push($TVArray, $items);
                }
            }
        }

        return view('TVShows', [
            'baseURL' => $baseURL,
            'imageBaseURL' => $imageBaseUrl,
            'apiKey' => $apiKey,
            'tvshows' => $TVArray,
            'sortBy' => $sortBy,
            'page' => $page,
            'minimalVoter' => $minimalVoter
        ]);
    }

    public function search(){
        $baseURL = env('MOVIETUBE_DB_URL');
        $imageBaseUrl = env('MOVIETUBE_DB_IMAGE');
        $apiKey = env('MOVIETUBE_DB_API_KEY');

        return view('search', [
            'baseURL' => $baseURL,
            'imageBaseURL' => $imageBaseUrl,
            'apiKey' => $apiKey,
        ]);
    }

    public function moviesDetail($id){
        $baseURL = env('MOVIETUBE_DB_URL');
        $imageBaseUrl = env('MOVIETUBE_DB_IMAGE');
        $apiKey = env('MOVIETUBE_DB_API_KEY');

        $response = Http::get("{$baseURL}/movie/{$id}", [
            'api_key' => $apiKey,
            'append_to_response' => 'videos'
        ]);

        $moviesData = null;

        if($response->successful()){
            $moviesData = $response->object();
        }

        return view('movie_details', [
            'baseURL' => $baseURL,
            'imageBaseURL' => $imageBaseUrl,
            'apiKey' => $apiKey,
            'movieData' => $moviesData,
        ]);
    }

    public function tvShowDetail($id){
        $baseURL = env('MOVIETUBE_DB_URL');
        $imageBaseUrl = env('MOVIETUBE_DB_IMAGE');
        $apiKey = env('MOVIETUBE_DB_API_KEY');

        $response = Http::get("{$baseURL}/tv/{$id}", [
            'api_key' => $apiKey,
            'append_to_response' => 'videos'
        ]);

        $moviesData = null;

        if($response->successful()){
            $tvData = $response->object();
        }

        return view('tv_details', [
            'baseURL' => $baseURL,
            'imageBaseURL' => $imageBaseUrl,
            'apiKey' => $apiKey,
            'tvData' => $tvData,
        ]);
    }
}
