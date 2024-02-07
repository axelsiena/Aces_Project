<?php

namespace App\Livewire;

use App\Models\Ad;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FavouriteAdButton extends Component
{
    public $adId;
    public $isFavourite;   
    public $count;

    public function mount()
    {
        $ad = Ad::find($this->adId);
        $user = Auth::user();

        // Check if the ad is already favorited
        $this->isFavourite = $user->favAds()->wherePivot('ad_id', $ad->id)->count() > 0;
        $this->count = $ad->favBy()->count();
    }

    public function toggleFavAd(){        

        $user = Auth::user();
        $ad = Ad::find($this->adId);

        if ($this->isFavourite) {
                $user->favAds()->detach($ad);
            } else {
                $user->favAds()->attach($ad);
            }

        $this->mount();
    }

    public function render()
    {
        return view('livewire.favourite-ad-button');
    }
}
