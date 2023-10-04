  <div>
      @if (session()->has('message'))
      <div class="alert alert-success">
          {{ session('message') }}
      </div>
      @endif
      <form wire:submit.prevent="store">
          @csrf

          <div class="flex items-center justify-between mb-8">
              <div class="flex items-center">

              </div>


              <div class="w-2/4">
                  <div class="mb-2 md:mb-1 md:flex items-center">
                      <label class="w-32 text-gray-400 block font-semibold text-sm uppercase tracking-wide">Invoice No.</label>
                      <span class="mr-4 inline-block hidden md:block">:</span>
                      <div class="flex-1">
                          <input wire:model="distribusi_sales.invoice_no" type="text" name="invoice" id="first_name" placeholder="eg. #INV-100001" class="form-control @error('distribusi_sales.invoice_no') is-invalid @enderror">
                          @error('distribusi_sales.invoice_no')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                          @enderror
                      </div>

                  </div>

                  <div class="mb-2 md:mb-1 md:flex items-center">
                      <label class="w-32 text-gray-400 block font-semibold text-sm uppercase tracking-wide"> Date</label>
                      <span class="mr-4 inline-block hidden md:block">:</span>
                      <div class="flex-1">
                          <input wire:model="distribusi_sales.date" type="date" name="invoice" id="date" class="form-control @error('distribusi_sales.date') is-invalid @enderror">
                          @error('distribusi_sales.date')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                          @enderror
                      </div>
                  </div>

                  <div class="mb-2 md:mb-1 md:flex items-center">
                      <label class="w-32 text-gray-400 block font-semibold text-sm uppercase tracking-wide">Kepada</label>
                      <span class="mr-4 inline-block hidden md:block">:</span>
                      <div class="flex-1">
                          <select class="form-control select2" name="sales_id" wire:model="distribusi_sales.sales_id">
                              <option value="" selected disabled>Pilih Sales</option>
                              @foreach($dataSales as $sales)
                              <option value="{{$sales->id}}">
                                  {{$sales->name}}
                              </option>
                              @endforeach
                          </select>
                          @error('distribusi_sales.sales_id')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                          @enderror
                      </div>
                  </div>
              </div>

          </div>





          @foreach($distribusi_sales_details as $key => $value)
          <div class="flex justify-between mb-3">
              <div class="add-input w-full mx-auto flex flex-row grid grid-cols-5  gap-2">


                  <div class="form-group">
                      <?php

                        $field_name = 'distribusi_sales_details.' . $key . '.karat_id';
                        $field_lable = __('Parameter Karat');
                        $field_placeholder = Label_case($field_lable);
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="' . $field_name . '"';
                        ?>
                        @if ($key == 0)
                        <label class="text-gray-700" for="{{ $field_name }}">
                            {{ $field_lable }}<span class="text-danger">*</span></label>
                        @endif
                      <select class="form-control form-control-sm" wire:change="changeParentKarat('{{ $key }}')" wire:model="{{ $field_name }}" name="{{ $field_name }}">
                          <option value="" selected disabled>Select Karat</option>
                          @foreach($dataKarat as $karat)
                          <option value="{{$karat->id}}">
                              {{$karat->name}} | {{$karat->kode}}
                          </option>
                          @endforeach
                      </select>
                      @if ($errors->has($field_name))
                      <span class="invalid feedback" role="alert">
                          <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                      </span>
                      @endif
                  </div>

                  <div class="form-group">
                      <?php

                        $field_name = 'distribusi_sales_details.' . $key . '.sub_karat_id';
                        $field_lable = __('Kategori Karat');
                        $field_placeholder = Label_case($field_lable);
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="' . $field_name . '"';
                        ?>
                        @if ($key == 0)
                        <label class="text-gray-700" for="{{ $field_name }}">
                            {{ $field_lable }}<span class="text-danger">*</span></label>
                        @endif
                      <select class="form-control form-control-sm" wire:change="updateCode($event.target.value,'{{ $key }}')" wire:model="{{ $field_name }}">
                          <option value="" selected disabled>Select Kategori</option>
                          @foreach($distribusi_sales_details[$key]['sub_karat_choice'] as $karat)
                          <option value="{{$karat['id']}}">
                              {{$karat['name']}} | {{$karat['kode']}}
                          </option>
                          @endforeach
                      </select>
                      @if ($errors->has($field_name))
                      <span class="invalid feedback" role="alert">
                          <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                      </span>
                      @endif
                  </div>


                  <div class="form-group">
                      <?php

                        $field_name = 'distribusi_sales_details.' . $key . '.code';
                        $field_lable = label_case('code');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="' . $field_name . '"';
                        ?>
                        @if ($key == 0)
                        <label class="text-gray-700" for="{{ $field_name }}">
                            {{ $field_lable }}<span class="text-danger">*</span></label>
                        @endif
                    <input wire:model="{{ $field_name }}" type="text" placeholder="{{ $field_placeholder }}" class="form-control form-control-sm" readonly>
                      @if ($errors->has($field_name))
                      <span class="invalid feedback" role="alert">
                          <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                      </span>
                      @endif
                  </div>



                  <div class="form-group">
                      <?php
                        $field_name = 'distribusi_sales_details.' . $key . '.harga';
                        $field_lable = label_case('harga (%)');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="' . $field_name . '"';
                        ?>
                    @if ($key == 0)
                        <label class="text-gray-700" for="{{ $field_name }}">
                            {{ $field_lable }}</label>
                        @endif
                    <input wire:model="{{ $field_name }}" type="number" placeholder="{{ $field_placeholder }}" class="form-control form-control-sm @error('{{$field_name}}') is-invalid @enderror" min="0" step="0.001">
                      @if ($errors->has($field_name))
                      <span class="invalid feedback" role="alert">
                          <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                      </span>
                      @endif
                  </div>








                  <div class="form-group">
                      <?php

                        $field_name = 'distribusi_sales_details.' . $key . '.berat_bersih';
                        $field_lable = label_case('berat_bersih');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:change=calculateTotalJumlah() step="0.001" wire:model="' . $field_name . '"';
                        ?>
                    @if ($key == 0)
                        <label class="text-gray-700" for="{{ $field_name }}">
                            {{ $field_lable }}<span class="text-danger">*</span></label>
                    @endif
                    <input wire:model.lazy.1s="{{ $field_name }}" wire:change=calculateTotalBerat() type="number" placeholder="{{ $field_placeholder }}" class="form-control form-control-sm @error('{{$field_name}}') is-invalid @enderror" min="0" step="0.001">
                      @if ($errors->has($field_name))
                      <span class="invalid feedback" role="alert">
                          <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                      </span>
                      @endif
                  </div>





                </div>
                @if ($key == 0)
                <div class="px-1 pt-4 mt-1">
                    <button class="btn text-white text-xl btn-info btn-sm" wire:click.prevent="add" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="add"><i class="bi bi-plus"></i></span>
                        <span wire:loading wire:target="add" class="text-center">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </span>
                    </button>
                </div>
                @else
                <div class="px-1 pt-1">
                    <button class="btn text-white text-xl btn-danger btn-sm" wire:click.prevent="remove({{$key}})" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="remove({{$key}})"><i class="bi bi-trash"></i></span>
                        <span wire:loading wire:target="remove({{$key}})" class="text-center">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </span>
                    </button>
                </div>
                @endif
          </div>
          @endforeach





          <div class="flex items-center justify-between mb-8">
              <div class="flex items-center">

              </div>
              <div class="w-2/7">
                  <div class="mb-2 md:mb-1 flex items-center">
                      <label class="w-30 text-gray-700 block text-sm tracking-wide">Total Berat Bersih</label>
                      <span class="mr-4 inline-block hidden md:block">:</span>
                      <div class="flex-1">
                          <input class="form-control form-control-sm" wire:model="distribusi_sales.total_weight" type="text" placeholder="0" readonly>
                      </div>
                  </div>
              </div>
          </div>










          <div class="pt-2 border-t flex justify-between">
              <div></div>
              <div class="form-group">
                  <a class="px-5 btn btn-outline-danger" href="{{ route("goodsreceipt.index") }}">
                      @lang('Cancel')</a>
                  <button class="px-5 btn  btn-submit btn-outline-success" wire:click.prevent="store" wire:target="store" wire:loading.attr="disabled">
                      <span wire:loading.remove wire:target="store">
                          >@lang('Save')
                      </span>
                      <span wire:loading wire:target="store" class="text-center">
                          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                          Loading...
                      </span>
                  </button>
              </div>
          </div>



      </form>
  </div>