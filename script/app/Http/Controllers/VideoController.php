<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use App\User;
use Auth;
use Session;
use DB;

class VideoController extends Controller
{
    public function show(Request $request, $username, $id, $slug)
    {
		$rand = Video::orderByRaw('RAND()')->get();
    	$randuser = User::where('id', $rand[0]->user_id)->first();
		$randvideo = $randuser->slug.'/'.$rand[0]->id.'/'.$rand[0]->slug;
 
		$user = User::where('slug', $username)->first();
		$video = Video::where('slug', $slug)->where('id', $id)->first();
    	if ($user)
		{
			if ($video)
			{
				$video_key = 'video_'.$video->id;
				if (!Session::has($video_key))
				{
					$video->increment('view');
					Session::put($video_key,1);
				}
				$isvideo = true;
				return view('singlevideo', compact('video', 'randvideo', 'user', 'isvideo'));
			}
			else
				return abort(404);
		}
		else
			return abort(404);
    }

    public function latest(Request $request)
    {
		$md = new \App\Libraries\Mobiledetect();

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  
            $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
	           $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
	    }else{  
	          $ip = $_SERVER['REMOTE_ADDR'];  
	     }  

    	$address = geoip()->getLocation($ip);

		$videos = Video::with('user')->where([
			//['status','public'],
			['country', $address->country],
			])->latest()->paginate(20);

		if ($videos->count() < 15)
		{
			$videos = Video::with('user')->/*where([
						    ['status', 'public'],
						])->*/latest()->paginate(20);
		}

		if ($request->data)
		{
            if ($videos->isEmpty())
            {
                return "no";
            }
            abort_if($videos->isEmpty(),204);
			return view('layouts.frontend.section.video', compact('videos', 'md'));
		}
		$type = "latest";
		return view('video', compact('videos', 'type', 'md'));
    	
    }

    public function popular(Request $request)
    {
		if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
            $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
	         $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
	    }else{  
	            $ip = $_SERVER['REMOTE_ADDR'];  
	     }  

		$md = new \App\Libraries\Mobiledetect();
    	$address = geoip()->getLocation($ip);

		$videos = Video::with('user')->where([
			 // ['status', 'public'],
			['country',$address->country],
			])->orderBy('view','desc')
			->paginate(20);

		if ($videos->count() < 15)
		{
			$videos = Video::with('user')->/*where([
				['status', 'public'],
				])->*/orderBy('view','desc')
				->paginate(20);
		}

		if ($request->data)
		{
            if ($videos->isEmpty())
                return 'no';
			abort_if($videos->isEmpty(),204);
			return view('layouts.frontend.section.video', compact('videos', 'md'));
		}
		$type = 'popular';
		return view('video', compact('videos', 'type', 'md'));
    }

    public function trending(Request $request)
    {
		if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
            $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
	         $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
	    }else{  
	        $ip = $_SERVER['REMOTE_ADDR'];  
	    }
		$md = new \App\Libraries\Mobiledetect();

    	$address = geoip()->getLocation($ip);

		$videos = Video::with('user')->where([
			//['status', 'public'],
			['country', $address->country],
			])->withCount('favourite_to_user')
			->withCount('comments')
			->orderBy('favourite_to_user_count','desc')
			->orderBy('view','desc')
			->orderBy('comments_count','desc')
			->paginate(20);

		if ($videos->count() < 15)
		{
			$videos = Video::with('user')->/*where([
				['status','public'],
				])->*/withCount('favourite_to_user')
				->withCount('comments')
				->orderBy('favourite_to_user_count','desc')
				->orderBy('view','desc')
				->orderBy('comments_count','desc')
				->paginate(10);
		}

		if ($request->data)
		{
            if ($videos->isEmpty())
            {
                return "no";
            }
            abort_if($videos->isEmpty(), 204);
			return view('layouts.frontend.section.video', compact('videos', 'md'));
		}

		$type = "trending";
		return view('video', compact('videos', 'type', 'md'));
    }

	public function videopol(Request $request)
	{
		$md = new \App\Libraries\Mobiledetect();
		if ($request['pol'] == 'all')
			$videos = Video::with('user')->/*where('status', 'public')->*/where('processing', 2)->latest()->paginate(20);
		else
			$videos = Video::with('user')->/*where('status', 'public')->*/where('processing', 2)->where('pol', $request['pol'])->latest()->paginate(20);
		return view('ajaxvideo', compact('videos', 'md'));
	}
	
    public function genrandvid(Request $req)
    {
		if ($req->pol != 'all')
			$vid = DB::table('videos')->
				where('pol', $req->pol)->
				whereNotIn('slug', $req->videos)->
				inRandomOrder()->limit(1)->
				get();
		else
			$vid = DB::table('videos')->
				whereNotIn('slug', $req->videos)->
				inRandomOrder()->limit(1)->
				get();
		if (isset($vid[0]))
		{
			print $vid[0]->slug;
			$vid = Video::where('slug', $vid[0]->slug)->first();
			$vid->view = $vid->view + 1;
			$vid->save();
		}
    }
}