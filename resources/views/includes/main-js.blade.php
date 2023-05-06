<script src="{{ url('/') }}{{ mix('js/app.js') }}"></script>
<script src="{{ url('/') }}{{ mix('js/backend.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.4.0/perfect-scrollbar.js"></script> --}}
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

@include('sweetalert::alert')

@yield('third_party_scripts')

@livewireScripts

@stack('page_scripts')


{{-- <script src="{{  asset('js/jquery.min.js') }}"></script> --}}
<!-- batass================================Create Modal============================= -->
<div class="modal fade" id="ModalGue" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalHeader"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
           <div class="modal-body p-0" id="ModalContent"></div>
           <div class="modal-footer" id="ModalFooter"></div>
        </div>
    </div>
</div>
{{-- end modal ======================================================================--}}

 <script type='text/javascript'>
            (function($) {
                 var jq = $.noConflict();
                        jq(document).ready(function(){
                        jq('#ModalGue').on('hide.bs.modal', function () {
                           setTimeout(function(){
                               jq('#ModalHeader, #ModalContent, #ModalFooter').html('');
                           }, 500);

                          });

                        jq('#ModalGue').on('click', '.modal .close', function () {
                                jq(this).closest('.modal').modal('hide');
                            });

                        });
                    }
                (jQuery));
     </script>