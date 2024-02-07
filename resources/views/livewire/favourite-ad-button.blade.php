<div>
    <i role="button" class="d-inline @if($isFavourite)fa-solid text-danger @else fa-regular opacity-50 @endif fa-heart mb-3" wire:click="toggleFavAd"></i>
    <p class="small opacity-50 d-inline ms-1">{{$count}}</p>
</div>