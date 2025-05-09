<!-- php artisan make:component library/Webcam -->
{{-- <x-library.dropzone /> --}}

@push('page_css')
    <!-- CSS -->
 <style>
    .drop-zone {
  max-width: 100%;
  height: 220px;
  padding: 25px;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  font-family: "Quicksand", sans-serif;
  font-weight: 500;
  font-size: 20px;
  cursor: pointer;
   border: 2px dashed #FF9800 !important;
        border-radius: 8px;
        background: #ff98003d !important;
}

.drop-zone--over {
  border-style: solid;
}

.drop-zone__input {
  display: none;
}

.drop-zone__thumb {
  width: 100%;
  height: 100%;
  border-radius: 10px;
  overflow: hidden;
  background-color: #cccccc;
  background-size: cover;
  position: relative;
}

.drop-zone__thumb::after {
  content: attr(data-label);
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  padding: 5px 0;
  color: #ffffff;
  background: rgba(0, 0, 0, 0.75);
  font-size: 14px;
  text-align: center;
}

    </style>
@endpush

@push('page_scripts')
 <script type="text/javascript" src="{{ asset('plugin/dropzone/script.js') }}"></script>


@endpush
