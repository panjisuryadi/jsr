@push('page_css')
<!-- CSS -->
<style>
    .camera {
        width: 100% !important;
        height: 240px !important;
        border: 2px dashed #FF9800 !important;
        border-radius: 8px;
        background: #ff98003d !important;

    }


    .results {
        width: 100% !important;
        /*height: 240px !important;*/
        /* border: 2px dashed #FF9800 !important;*/
        border-radius: 8px;
        background: #ff98003d !important;

    }

    .d-none {
        display: none !important;
    }

    .d-blok {
        display: block;
    }
</style>

<!-- -->

@endpush
<?php
$ogg = asset('js/webcamjs/shutter.ogg');
$mp3 = asset('js/webcamjs/shutter.mp3');

?>
<div class="flex flex-row grid grid-cols-1">
    <div class="py-0">

        <div class="h-320 d-flex flex-wrap align-items-center justify-content-center d-blok camera relative">
            @if ($isCameraActive)
            <div id="camera{{$key}}">
                
            </div>
            @else
            <div class="absolute m-auto z-0">
                <i style="font-size: 3.5rem !important;" class="text-red-800 bi bi-camera"></i>
            </div>
            <div class="d-flex flex-wrap align-items-center justify-content-center results z-10" id="results{{$key}}" wire:ignore>
                <img id="imageprev{{$key}}">
            </div>
            @endif
        </div>




        <div class="flex py-3 flex-row gap-1 align-items-center justify-content-center">
            <input class="btn btn-sm btn-warning" type=button value="Start" wire:click="configure({{$key}})">
            <input class="btn btn-sm btn-warning" type=button value="Capture" wire:click="takeSnapshot({{$key}})">
            <input class="btn btn-sm btn-primary" type=button value="Reset" wire:click="resetSnapshot({{$key}})">
        </div>

    </div>


</div>
<!-- Script -->




@push('page_scripts')
<script>

document.addEventListener('livewire:load', function () {
    let webcam = Webcam;
    Livewire.on('configureCamera', function (key) {
        webcam.set({
            width: 360,
            height: 220,
            autoplay: false,
            image_format: 'jpeg',
            jpeg_quality: 90,
            force_flash: false
        });
        webcam.attach('#camera' + key);
    });

    Livewire.on('takeSnapshot', function(key){
        // play sound effect
        // take snapshot and get image data
        webcam.snap(function(data_uri) {
            document.getElementById('imageprev' + key).src = data_uri
            Livewire.emit('webcamCaptured',key,data_uri)
        });
        webcam.reset()
    });

    Livewire.on('removePrev', function(key){
        document.getElementById('imageprev' + key).style = 'display:none'
        Livewire.emit('webcamReset',key)
        webcam.reset()
    });
});

</script>



@endpush