<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\NewUser;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auth\Http;

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
    protected $redirectTo = '/home';

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

      
    }

    public function redirectTo() {
        $user = auth()->user();
    
        // Retrieve all admins as a collection
        $admins = User::where('is_admin', 1)->get();
    
        if ($admins->count() == 1) {
            // If only one admin, notify them
            $admins->first()->notify(new NewUser($user));
        }
    
        if ($admins->count() > 1) {
            // Loop through all admins and notify each
            foreach ($admins as $admin) {
              
                $admin->notify(new NewUser($user));
            }
        }

        $response = Http::withOptions([
            'verify' => 'C:\\laragon\\bin\\php\\php-8.2.23\\extras\\cacert.pem', // Path to cacert.pem
        ])->post('https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage', [
            'chat_id' => env('TELEGRAM_CHAT_ID', '1104146677'),
            'parse_mode' => 'HTML',
            'text' => $messageText,
        ]);

        // Redirect to a specific route after notifying
        return redirect()->route('home'); // Ensure you're returning a redirect response
    }
    
}
