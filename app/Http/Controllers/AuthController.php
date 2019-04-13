<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use Keygen;
use App\Notifications\SignupActivate;
use Avatar;
use Storage;
use Illuminate\Routing\UrlGenerator;
class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'user_name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);
        //Verificar si el correo o el username existen
        $avatar;
        $avatarPath;
        
        $user = new User([
            'name'              => $request->name,
            'email'             => $request->email,
            'user_name'         => $request->user_name,
            'password'          => bcrypt($request->password),
            'activation_token'  => str_random(60),
            
        ]);
        if($request->file){
            $avatar = str_replace('data:image/png;base64,','',$request->input('file')) ;
            $avatar = str_replace(' ', '+', $avatar);
            $avatarPath = 'avatars/'.str_random(40).'.'.'jpg';
            Storage::disk('public')->put($avatarPath, base64_decode($avatar));
        }else{
            $avatar=Avatar::create($request->name)->getImageObject()->encode('png');
            $avatarPath='avatars/'.str_random(20).'.png';
            Storage::disk('public')->put($avatarPath, (string) $avatar);
        }
        $user->active = true;
        $user->activation_token = '';
        $user->avatar=Storage::url($avatarPath);
        $user->save();
        //$user->notify(new SignupActivate($user));
        
        return response()->json(['message' => 'Usuario creado existosamente!'], 201);
    }
    
    
    private function generateKey(){
        $flag=false;
        $key="";
        do
        {
            $key=Keygen::alphanum(12)->generate();
            if(User::find($key)){
                $flag=true;
            }
        }
        while($flag);
        return $key;
    }
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'       => 'required|string|email',
            'password'    => 'required|string',
            'remember_me' => 'boolean',
        ]);
        $credentials = request(['email', 'password']);
        //$credentials['active'] = 1;
        //$credentials['deleted_at'] = null;
        
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'No Autorizado'], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Token Acceso Personal');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(9);
        }
        $token->save();
        return response()->json([
            'id'=>$user->id,
            'name'=>$user->name,
            'email'=>$user->email,
            'user_name'=>$user->user_name,
            'avatar'=>url($user->avatar),
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
        ]);
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        $user=$request->user();
        return [
            'id'=>$user->id,
            'name'=>$user->name,
            'email'=>$user->email,
            'user_name'=>$user->user_name,
            'avatar'=>url($user->avatar) 
        ];
    }

    public function userUnReadNotications(Request $request)
    {
        return $request->user()->unreadNotifications;
    }
    public function userNotications(Request $request)
    {
        return $request->user()->notifications;
    }
    public function markAsRead(Request $request)
    {
        $notification=$request->user()->notifications->find($request->notification);
        if($notification){
            $notification->markAsRead();
            return response()->json(['message' => 'Notification mark as read'], 201);
        }
        else{
            return response()->json(['message' => 'Notification not found'], 401);
        }
    }

    public function markAsReadAllNotification(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        return response()->json(['message' => 'Notifications mark as read'], 201);
    }

    public function signupActivate($token)
    {
        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return abort(404);
        }
        $user->active = true;
        $user->activation_token = '';
        $user->save();

        //redirigir a /
        return redirect('/');
    }
}