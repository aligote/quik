<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Verification;
use Carbon\Carbon;
use Auth;

class VerificationController extends Controller
{
    public function store(Request $request)
    {
    	$validator = \Validator::make($request->all(), [
            'national_id' => 'image|required|max:10240',
            'verifyimage' => 'image|required|max:10240',
            'selfieimage' => 'image|required|max:10240',
            'secondimage' => 'image|required|max:10240'
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()[0]]);
        }

        $file = $request->file('national_id');
        if (isset($file)) {
            $curentdate = Carbon::now()->toDateString();
            $imagename =  $curentdate . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            $path = 'uploads/verification/';

            $file->move($path, $imagename);

            $image_path = $path.$imagename;

        }else{
            $image_path = 'uploads/nation.png';
        }

        $file = $request->file('secondimage');
        if (isset($file)) {
            $curentdate = Carbon::now()->toDateString();
            $imagename =  $curentdate . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            $path = 'uploads/verification/';

            $file->move($path, $imagename);

            $secondimage = $path.$imagename;

        }else{
            $secondimage = 'uploads/nation.png';
        }

        $file = $request->file('selfieimage');
        if (isset($file)) {
            $curentdate = Carbon::now()->toDateString();
            $imagename =  $curentdate . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            $path = 'uploads/verification/';

            $file->move($path, $imagename);

            $selfieimage = $path.$imagename;

        }else{
            $selfieimage = 'uploads/nation.png';
        }

        $file = $request->file('verifyimage');
        if (isset($file)) {
            $curentdate = Carbon::now()->toDateString();
            $imagename =  $curentdate . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            $path = 'uploads/verification/';

            $file->move($path, $imagename);

            $verifyimage = $path.$imagename;

        }else{
            $verifyimage = 'uploads/nation.png';
        }

    	$verification = new Verification();
    	$verification->user_id = Auth::User()->id;
    	$verification->image = $image_path;
    	$verification->secondimage = $secondimage;
    	$verification->selfieimage = $selfieimage;
    	$verification->verifyimage = $verifyimage;
    	$verification->first_name = $request->first_name;
    	$verification->last_name = $request->last_name;
    	$verification->birthdate = $request->birthdate;
    	$verification->message = $request->message?$request->message:'';
    	$verification->status = 'pending';
    	$verification->save();

    	return response()->json('ok');
    }
}
