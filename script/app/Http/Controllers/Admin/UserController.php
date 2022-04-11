<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Report;
use App\Verification;

class UserController extends Controller
{
    public function index()
    {
    	$users = User::latest()->paginate(20);
    	return view('admin.user.index',compact('users'));
    }

    public function report()
    {
        $reports = Report::where('type','user')->paginate(20);
    	return view('admin.user.report',compact('reports'));
    }

    public function achievments()
    {
    	$users = User::latest()->paginate(20);
    	return view('admin.user.achievments', compact('users'));
    }
    
    public function saveachievments(Request $req)
    {
        $uid = $req->uid;
        $achiev = $req->achiev;
        $checked = $req->checked;
        if ($uid AND $achiev)
        {
            $user = User::find($uid);
            switch ($achiev)
            {
            case 'check':
                $user->check = $checked;
                print $user->check;
                break;
            case 'fire':
                $user->fire = $checked;
                print $user->fire;
                break;
            case 'heart':
                $user->heart = $checked;
                print $user->heart;
                break;
            case 'diamond':
                $user->diamond = $checked;
                print $user->diamond;
                break;
            }
            $user->save();
        }
        return;
    }
    
    public function delete($id)
    {
    	User::find($id)->delete();
    	toast('User successfully deleted','success');
    	return back();
    }

    public function verification_request()
    {
        $verifications = Verification::where('status', 'pending')->latest()->paginate(20);
        return view('admin.user.verification', compact('verifications'));
    }

    public function verify($id)
    {
        $verification = Verification::find($id);
		$user = User::find($verification->user_id);
        $verification->status = 'approved';
        $verification->save();
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
								
		$headers .= 'To: '.$user->first_name.' <'.$user->email.'>'."\r\n";
		$headers .= 'From: Documents verification <no-reply@leak.fun>'."\r\n";
		$text = 'Congratulations, you are verified. Thanks for verifying your account.<br><br>

If you plan to upload videos with another person or multiple people before they appear on your account, these steps must be repeated for each person individually. If other people appear in your videos who did not follow these steps before they appeared on your account, your videos with that person may be deleted.';

		mail($user->email, 'Your documents were verified', $text, $headers);
        toast('User successfully verified','success');
        return back();
    }

    public function verify_delete($id)
    {
        Verification::find($id)->delete();
        toast('User verify request successfully deleted','success');
        return back();
    }

    public function pending_users()
    {
        $pending_users = User::orderBy('id', 'DESC')->get();
        return view('admin.user.pending',compact('pending_users'));
    }

    public function approved($id)
    {
        $user = User::find($id);
        $user_data = json_decode($user->value);
        $user_data->status = 'active';
        $user->value = json_encode($user_data);
        $user->save();
        
        return back();
    }
}
