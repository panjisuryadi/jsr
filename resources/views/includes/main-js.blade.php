<script src="{{ url('/') }}{{ mix('js/app.js') }}"></script>
<script src="{{ url('/') }}{{ mix('js/backend.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.4.0/perfect-scrollbar.js"></script> --}}
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

@include('sweetalert::alert')

@yield('third_party_scripts')

@livewireScripts

@stack('page_scripts')
