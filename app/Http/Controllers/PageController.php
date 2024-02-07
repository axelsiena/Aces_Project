<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        // ultimi 4 annunci
        $last_ads = Ad::where('is_accepted',true)->latest()->take(8)->get();
        
        // 4 annunci più preferiti dagli utenti
        $popular_ads = Ad::where('is_accepted', true)
        ->withCount('favBy')
        ->orderByDesc('fav_by_count')
        ->latest()
        ->take(8)
        ->get();
        
        return view('welcome', compact('last_ads','popular_ads'));
    }

    public function profile(){

        $user = auth()->user();
        $ads = $user->ads()->withTrashed()->get();
        $created_at = Carbon::parse($user->created_at)->diffForHumans();

        return view('auth.profile', compact('user','created_at','ads'));
    }

    public function setLanguage($lang) {
        
        session()->put('locale', $lang);
        
        return redirect()->back();
    }
}
