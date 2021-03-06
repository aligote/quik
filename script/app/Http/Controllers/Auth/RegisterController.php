<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Option;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            //'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z\-_0-9]+$/i','not_regex:/^(hitler|pedophile)$/i', 'max:20', 'unique:users'],
            'password' => ['required', 'string', 'min:8'/*, 'confirmed'*/],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
            $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
        }else{  
            $ip = $_SERVER['REMOTE_ADDR'];  
        }  

        $address = geoip()->getLocation($ip);

        $option = Option::where('key', 'user_value')->first();
        $user_value = json_decode($option->value);
        if ($user_value->user_verification == 'enabled')
        {
            $status = 'deactive';
        }else{
            $status = 'active';
        }
		$username = Str::slug($data['username']);
		/*if (mb_strlen($username) < 3 OR mb_strlen($username) > 20)
            return redirect()->back()->withInput($data->only('username', 'remember'))->withErrors(['approve' => '???????????????????????? ?????????? ?????? ????????????.']);
			//return response()->json(['errors' => 'The message contains invalid words.']);*/

		/*$words = ['hitler', 'pedophile'];
		$allowwords = true;
		foreach ($words as $word)
			if (mb_stripos($username, $word) !== false)
				$allowwords = false;

		if (!$allowwords)
            return redirect()->back()->withErrors(['approve' => '???????????????????????? ?????????? ?????? ????????????.']);
			//return response()->json(['errors' => 'The message contains invalid words.']);
		$allowchars = true;
			
		for ($i = 0; $i < mb_strlen($username); $i ++)
			if (mb_strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz_.0123456789-', $username[$i]) === false)
				$allowchars = false;

		if (!$allowchars)
            return redirect()->back()->withErrors(['approve' => '???????????????????????? ?????????? ?????? ????????????.']);
			//return response()->json(['errors' => 'This username is not available.']);*/

		if (!empty($data['ncapt']) && $data['ncapt'] == md5(date('d.m.Y'). 'qick.fun'))
		{
	
			return User::create([
				'role_id' => 2,
				'first_name' => $data['first_name'],
				//'last_name' => $data['last_name'],
				'slug' => Str::slug($data['username']),
				'email' => $data['email'],
				'username' => '@'.$username,
				'country' => $address->country,
				'password' => Hash::make($data['password']),
				'value' => '{"bio":null,"total_view":0,"total_like":0,"city":"'.$address['city'].'","country":"'.$address['country'].'","gender":null,"age":null,"status":"'.$status.'","verified":"unverified","facebook":null,"twitter":null,"instagram":null,"pinterest":null,"onlyfans":null,"twitch":null,"reddit":null,"offwebsite":null,"youtube":null,"relation":null,"cover":"uploads/cover.png","two_step":"disable","wallet":"0"}',
			]);
		}
    }
}