<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAuthorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        // Ottieni l'annuncio (ad) dalla richiesta
        $ad = $request->route('ad');

        if(is_string($ad)){
            $adBelongsToUser = $user->ads()->where('id', $ad)->exists();
        }else{

            $adId = $ad->id;            
            $adBelongsToUser = $user->ads()->where('id', $adId)->exists();
        }
        
        if($adBelongsToUser){
            return $next($request);
        }

        return redirect('/profile')->with('error', 'Non puoi modificare un annuncio non tuo');

        
    }
}
