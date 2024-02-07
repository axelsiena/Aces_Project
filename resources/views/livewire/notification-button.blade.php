<div class="me-lg-2">
    <a href="{{route('revisor.index')}}" class="btn btn-outline-danger position-relative w-100" aria-current="page" wire:click="mount">
        {{__('ui.revisor_dashboard')}}
        @if ($notificationButton > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $notificationButton }}
                <span class="visually-hidden">Nuovi Annunci</span>
            </span>
        @endif
    </a>
</div>