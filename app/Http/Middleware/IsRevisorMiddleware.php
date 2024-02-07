<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsRevisorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if (Auth::check() && Auth::user()->is_revisor) {
            
            return $this->checkRevisorOwnership($request, $next);
        }

        return redirect('/')->with('error', 'Attenzione! Solo i revisori hanno accesso a questa pagina');
    }

    /**
     * Check if the logged-in revisor is trying to revise their own ad.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    private function checkRevisorOwnership(Request $request, Closure $next): Response
    {
        // Ottieni l'ID dell'annuncio (ad) dalla richiesta
        $adId = $request->route('ad');

        $revisor = Auth::user();

        $adBelongsToRevisor = $revisor->ads()->where('id', $adId)->exists();

        if ($adBelongsToRevisor) {
            
            return redirect()->route('revisor.index')->with('error', 'Non puoi revisionare il tuo annuncio.');
        }

        // Se il revisore non è l'autore, procedi con la revisione
        return $next($request);
    }
}
