<style type="text/css">
label {
    display: inline-block;
    margin-bottom: 0.2rem !important;
}
.form-control {
    font-size: 0.7rem !important;

}
button, input, optgroup, select, textarea {
    padding: 0;
    line-height: inherit;
    color: inherit;
}
.text-danger {
	font-size: 0.6rem !important;
    color: #e55353 !important;
    line-height: 1 !important;
}

@media (min-width: 992px)
.modal-lg, .modal-xl {
    max-width: 920px !important;
}
</style>

<div class="px-3">
    <x-library.alert />

    <form id="FormTambah" action="{{ route("$module_name.saveajax") }}" method="POST" enctype="multipart/form-data">
        @csrf

 <div class="flex flex-row grid grid-cols-3 gap-4">

<div class="p-2">

image

</div>


<div class="col-span-2">

<div class="flex flex-row grid grid-cols-2 gap-2">

<div class="form-group">
	<?php
	$field_name = 'product_name';
	$field_lable = label_case($field_name);
	$field_placeholder = $field_lable;
	$invalid = $errors->has($field_name) ? ' is-invalid' : '';
	$required = "required";
	?>
	<label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
	<input class="form-control"
	type="text"
	name="{{ $field_name }}"
	id="{{ $field_name }}"
	placeholder="{{ $field_placeholder }}">
	<span class="invalid feedback" role="alert">
		<span class="text-danger error-text {{ $field_name }}_err"></span>
	</span>
</div>




<div class="form-group">
	<?php
	$field_name = 'category_id';
	$field_lable = label_case('Kategori');
	$field_placeholder = $field_lable;
	$invalid = $errors->has($field_name) ? ' is-invalid' : '';
	$required = "required";
	?>
	<label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
		<select class="form-control" name="{{ $field_name }}" id="{{ $field_name }}" required>
		    <option value="" selected disabled>Pilih Kategori</option>
		    @foreach(\Modules\Product\Entities\Category::all() as $kate)
		    <option value="{{ $kate->id }}">{{ $kate->category_name }}</option>
		    @endforeach
		</select>
	<span class="invalid feedback" role="alert">
		<span class="text-danger error-text {{ $field_name }}_err"></span>
	</span>
</div>

</div>

   <div class="flex row px-3 py-0">
   {{-- ============================= --}}
                                    <div class="form-row">
                                        <div class="col-md-3">
								<div class="form-group">
									<?php
									$field_name = 'berat_emas';
									$field_lable = label_case('Berat');
									$field_placeholder = $field_lable;
									$invalid = $errors->has($field_name) ? ' is-invalid' : '';
									$required = "required";
									?>
									<label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
									<input class="form-control"
									type="number"
									name="{{ $field_name }}"
									min="0" step="0.01"
									id="{{ $field_name }}"
									value="{{old($field_name)}}"
									placeholder="{{ $field_placeholder }}">
									<span class="invalid feedback" role="alert">
										<span class="text-danger error-text {{ $field_name }}_err"></span>
									</span>
								</div>

                                        </div>
                                        <div class="col-md-3">

				                      <div class="form-group">
											<?php
											$field_name = 'berat_accessories';
											$field_lable = label_case('berat_accessories');
											$field_placeholder = $field_lable;
											$invalid = $errors->has($field_name) ? ' is-invalid' : '';
											$required = "required";
											?>
											<label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
											<input class="form-control"
											type="number"
											name="{{ $field_name }}"
											min="0" step="0.01"
											id="{{ $field_name }}"
											value="{{old($field_name)}}"
											placeholder="{{ $field_placeholder }}">
											<span class="invalid feedback" role="alert">
												<span class="text-danger error-text {{ $field_name }}_err"></span>
											</span>
										</div>


                                        </div>
                                        <div class="col-md-3">

				                      <div class="form-group">
											<?php
											$field_name = 'berat_label';
											$field_lable = label_case('berat_label');
											$field_placeholder = $field_lable;
											$invalid = $errors->has($field_name) ? ' is-invalid' : '';
											$required = "required";
											?>
											<label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
											<input class="form-control"
											type="number"
											name="{{ $field_name }}"
											min="0" step="0.01"
											id="{{ $field_name }}"
											value="{{old($field_name)}}"
											placeholder="{{ $field_placeholder }}">
											<span class="invalid feedback" role="alert">
												<span class="text-danger error-text {{ $field_name }}_err"></span>
											</span>
										</div>


                                        </div>
                                        <div class="col-md-3">

		                                 <div class="form-group">
													<?php
													$field_name = 'berat_total';
													$field_lable = label_case('berat_total');
													$field_placeholder = $field_lable;
													$invalid = $errors->has($field_name) ? ' is-invalid' : '';
													$required = "required";
													?>
													<label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
													<input class="form-control"
													type="number"
													name="{{ $field_name }}"
													min="0" step="0.01"
													id="{{ $field_name }}"
													value="{{old($field_name)}}"
													placeholder="{{ $field_placeholder }}">
													<span class="invalid feedback" role="alert">
														<span class="text-danger error-text {{ $field_name }}_err"></span>
													</span>
												</div>

                                        </div>
                                    </div>
 {{-- ======================================= --}}
                                </div>




 {{-- harga ========= --}}
            <div class="form-row">
                <div class="col-md-4">

				<div class="form-group">
					<?php
					$field_name = 'product_price';
					$field_lable = label_case($field_name);
					$field_placeholder = $field_lable;
					$invalid = $errors->has($field_name) ? ' is-invalid' : '';
					$required = "required";
					?>
					<label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
					<input class="form-control"
					type="text"
					name="{{ $field_name }}"
					id="{{ $field_name }}"
					value="{{old($field_name)}}"
					placeholder="{{ $field_placeholder }}"
					>
					<span class="invalid feedback" role="alert">
						<span class="text-danger error-text {{ $field_name }}_err"></span>
					</span>
				</div>



                </div>
                <div class="col-md-4">

					<div class="form-group">
						<?php
						$field_name = 'product_cost';
						$field_lable = label_case($field_name);
						$field_placeholder = $field_lable;
						$invalid = $errors->has($field_name) ? ' is-invalid' : '';
						$required = "required";
						?>
						<label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
						<input class="form-control"
						type="text"
						name="{{ $field_name }}"
						id="{{ $field_name }}"
						value="{{old($field_name)}}"
						placeholder="{{ $field_placeholder }}"
						>
						<span class="invalid feedback" role="alert">
							<span class="text-danger error-text {{ $field_name }}_err"></span>
						</span>
					</div>

                </div>
                <div class="col-md-4">


                   <div class="form-group">
						<?php
						$field_name = 'product_sale';
						$field_lable = label_case($field_name);
						$field_placeholder = $field_lable;
						$invalid = $errors->has($field_name) ? ' is-invalid' : '';
						$required = "required";
						?>
						<label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
						<input class="form-control"
						type="text"
						name="{{ $field_name }}"
						id="{{ $field_name }}"
						value="{{old($field_name)}}"
						placeholder="{{ $field_placeholder }}"
						>
						<span class="invalid feedback" role="alert">
							<span class="text-danger error-text {{ $field_name }}_err"></span>
						</span>
					</div>



                </div>
            </div>
  {{-- ========= --}}





</div>








 </div>


  </form>
</div>
<script src="{{ asset('js/jquery-mask-money.js') }}"></script>
<script>
    jQuery.noConflict();
    (function( $ ) {
        function autoRefresh(){
            var table = $('#datatable').DataTable();
            table.ajax.reload();
        }
        function Tambah()
        {
            $.ajax({
                url: $('#FormTambah').attr('action'),
                type: "POST",
                cache: false,
                data: $('#FormTambah').serialize(),
                dataType:'json',
                success: function(data) {
                    console.log(data.error)
                    if($.isEmptyObject(data.error)){
                        $('#ResponseInput').html(data.success);
                        $("#sukses").removeClass('d-none').fadeIn('fast').show().delay(3000).fadeOut('slow');
                        $("#ResponseInput").fadeIn('fast').show().delay(3000).fadeOut('slow');
                        setTimeout(function(){ autoRefresh(); }, 1000);
                        $('#FormTambah').each(function(){
                            this.reset();
                        });
                          setTimeout(function () {
                              $('#ModalGue').modal('hide');
                            }, 3000);

                    }else{
                        printErrorMsg(data.error);
                    }
                }
            });
        }
        function printErrorMsg (msg) {
            $.each( msg, function( key, value ) {
                console.log(key);
                $('#'+key+'').addClass("");
                $('#'+key+'').addClass("is-invalid");
                $('.'+key+'_err').text(value);
            });
        }
        $(document).ready(function(){
            var Tombol = "<a href='<?php route('products.create-modal') ;?>' id='Back' class='btn btn-success px-5'>{{ __('Back') }}</a>";
            Tombol += "<button type='button' class='px-5 btn btn-primary' id='SimpanTambah'>{{ __('Create') }}</button>";
            $('#ModalFooterKategori').html(Tombol);
            $("#FormTambah").find('input[type=text],textarea,select').filter(':visible:first').focus();
            $('#SimpanTambah').click(function(e){
                e.preventDefault();
                Tambah();
            });
            $('#FormTambah').submit(function(e){
                e.preventDefault();
                Tambah();
            });
        });

       $('#product_price').maskMoney({
            prefix: 'Rp ',
            thousands: '.',
            decimal: ',',
            precision: 0
          });


       $('#product_cost').maskMoney({
            prefix: 'Rp ',
            thousands: '.',
            decimal: ',',
            precision: 0
          });


        $('#product_sale').maskMoney({
            prefix: 'Rp ',
            thousands: '.',
            decimal: ',',
            precision: 0
          });

    })(jQuery);
</script>


