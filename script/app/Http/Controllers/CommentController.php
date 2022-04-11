<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Video;
use Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
		if (mb_strlen($request->comment) > 150)
			return response()->json(['errors' => 'Length of comment must be less than 150 characters.']);

		$words = ['nigger', 'whore', 'slut', 'fuck', 'http://', 'https://', 'www', '.com'];
		$allowwords = true;
		foreach ($words as $word)
			if (mb_stripos($request->comment, $word) !== false)
				$allowwords = false;

		if (!$allowwords)
			return response()->json(['errors' => 'The message contains invalid words.']);

    	$video = $video = Video::with('user')->where('id', $request->video_id)->first();
    	$comment = new Comment();
    	$comment->user_id = Auth::User()->id;
    	$comment->video_id = $request->video_id;
    	if ($request->parent_id != null)
    	{
    		$comment->parent_id = $request->parent_id;
    	}
        if ($request->mention_id != null)
        {
            $comment->mention_id = $request->mention_id;
        }
    	$comment->message = $request->comment;
    	$comment->save();
    	return view('comment', compact('video'));
    }
}
