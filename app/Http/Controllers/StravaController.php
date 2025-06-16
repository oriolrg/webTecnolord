<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Carbon\Carbon;

class StravaController extends Controller
{
    // Redirigeix a Strava per autorització OAuth
    public function redirectToStrava()
    {
        Log::info('redirectToStrava cridat');
        
        $redirectUrl = Socialite::driver('strava')
            ->scopes(['read_all'])
            ->redirect()
            ->getTargetUrl();
            
        Log::info('redirectToStrava cridat', ['url' => $redirectUrl]);
        
        return redirect($redirectUrl);
    }
    

    // Rep la resposta després que l’usuari autoritzi o denegui l'app
    public function handleStravaCallback()
    {
        try {
            $stravaUser = Socialite::driver('strava')->user();
    
            $user = User::updateOrCreate(
                ['strava_id' => $stravaUser->getId()],
                [
                    'name' => $stravaUser->getName(),
                    'token' => $stravaUser->token,
                    'refresh_token' => $stravaUser->refreshToken,
                    'token_expires_at' => Carbon::now()->addSeconds($stravaUser->expiresIn),
                ]
            );
    
            session(['user_id' => $user->id]);
    
            return redirect('/enruta/privat');
    
        } catch (\Exception $e) {
            return redirect('/enruta')->with('error', 'Error autenticant amb Strava');
        }
    }
}
