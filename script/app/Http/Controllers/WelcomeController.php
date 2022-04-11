<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Video;
use App\Option;
use DB;
use App\Libraries\Mobiledetect;

class WelcomeController extends Controller
{
    function index(){
        $md = new Mobiledetect();
        $option = Option::where('key', 'site_value')->first();
        $site_value = json_decode($option->value);
        $videos = Video::with('user')->where([
            ['processing', 2],
            // ['country', 'Russia'],
        ])->withCount('favourite_to_user')
        ->withCount('comments')
//        ->orderBy('favourite_to_user_count','desc')
//        ->orderBy('view','desc')
        ->orderBy('comments_count','desc')->latest()->get();

        // ->paginate(20);
        // dd($videos);
        return view ('welcome', ['videos' => $videos, 'md'=> $md, 'site_value' => $site_value ]);
    }
    function getByCategory($category){
        $md = new Mobiledetect();
        $option = Option::where('key', 'site_value')->first();
        $site_value = json_decode($option->value);
        $videos = Video::with('user')->where([
            ['processing', 2],
             ['pol', $category],
        ])->withCount('favourite_to_user')
            ->withCount('comments')
//            ->orderBy('favourite_to_user_count','desc')
//            ->orderBy('view','desc')
            ->orderBy('comments_count','desc')->latest()->get();
        return view ('welcome', ['videos' => $videos, 'md'=> $md, 'site_value' => $site_value ]);
    }

	public function logout()
	{
		Auth::logout();
		return redirect()->route('welcome');
	}
}
