<div class="position-relative px-0">
{{--     <div wire:loading class="position-absolute mt-1 border-0" style="z-index: 10;left: 0;top: 10;right: 0;">
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="card mb-0 border-0">
        <div class="px-0">
            <div class="form-group">
                <input name="rfid" class="form-control rounded rounded-lg sortir text-center" wire:keydown.enter="clickQuery"
                type="text"
                wire:model="search"
                placeholder="@lang('Scanner RFID')" autofocus>
            </div>
        </div>
    </div>

</div>


<style type="text/css">

.sortir {
    border: 0.2rem solid;
    color: #111827;
    font-size: 1.2rem;
    font-weight: 600;
    letter-spacing: 0.1rem;
    background-color: #f0f0f0;
    border-style: dashed;
    height: 21rem;
}


.sortir:focus {
  background-color: #fbe5e5;
}

</style>


{{-- <div class="form-group">
    <input class="form-control rounded rounded-lg sortir text-center" wire:keydown.enter="clickQuery"
    type="text"
    wire:model="search"
    placeholder="@lang('Scan RFID')">
</div> --}}
