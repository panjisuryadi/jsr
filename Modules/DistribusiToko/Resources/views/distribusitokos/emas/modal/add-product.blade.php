<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static" wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title text-lg font-bold" id="addModalLabel">Tambah Produk</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="$set('showModal',false)">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body p-4">
                <form wire:submit.prevent="store">
                    <div class="grid grid-cols-4 gap-10">
                        <div class="col-span-2">
                            <div class="grid grid-cols-2 gap-2">
                                <div class="form-group">
                                    <label for="product_category">Product Category</label>
                                    <select id="product_category" wire:model="new_product.product_category_id" class="form-control @error('new_product.product_category_id') is-invalid @enderror" wire:change="productCategoryChanged">
                                    <option value="">Semua Produk</option>
                                        @foreach($product_categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('new_product.product_category_id'))
                                        <span class="invalid feedback"role="alert">
                                            <small class="text-danger">{{ $errors->first('new_product.product_category_id') }}.</small
                                            class="text-danger">
                                        </span>
                                    @endif
                                </div>
            
                                <div class="form-group">
                                    <?php
                                    $field_name = 'new_product.group_id';
                                    $field_lable = label_case('group');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = "required";
                                    ?>
                                    <label for="{{ $field_name }}">@lang($field_lable)
                                        <span class="text-danger">*</span>
                                        <span class="small">Jenis Perhiasan</span>
                                    </label>
                                    <select class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                        <option value="" selected disabled>Pilih {{ $field_lable }}</option>
                                        @foreach(\Modules\Group\Models\Group::all() as $jp)
                                        <option value="{{ $jp->id }}">{{ $jp->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback"role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                        class="text-danger">
                                    </span>
                                    @endif
            
                                </div> 
                                <div class="form-group">
                                    <?php
                                    $field_name = 'new_product.model_id';
                                    $field_lable = label_case('model');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = "required";
                                    ?>
                                    <label for="{{ $field_name }}">{{ $field_lable }}</label>
                                    <select class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                        <option value="" selected disabled>Pilih Model</option>
                                        @foreach(\Modules\ProdukModel\Models\ProdukModel::all() as $sup)
                                        <option value="{{$sup->id}}">
                                            {{$sup->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback"role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                        class="text-danger">
                                    </span>
                                    @endif
                                </div>
            
                                <div class="form-group">
                                    <?php
                                    $field_name = 'new_product.code';
                                    $field_lable = label_case('code');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = "required";
                                    ?>
                                    <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="{{ $field_name }}" class="form-control @error($field_name) is-invalid @enderror" wire:model="{{ $field_name }}" readonly>
                                        <span class="input-group-btn">
                                            <button class="btn btn-info relative rounded-l-none" wire:click.prevent="generateCode">Check</button>
                                        </span>
                                    </div>
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback"role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                        class="text-danger">
                                    </span>
                                    @endif
                                </div>

                            </div>
                            @if($isLogamMulia)
    
                    <div class="grid grid-cols-2 gap-2">
                        <div class="form-group">
                            <?php
                            $field_name = 'new_product.certificate_id';
                            $field_lable = label_case('certificate_id');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = "required";
                            ?>
                            <label for="{{ $field_name }}">@lang('Certificate') <span class="text-danger">*</span></label>
                            <select class="form-control select2 @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                <option value="" selected disabled>Pilih Certificate</option>
                                @foreach(\Modules\DiamondCertificate\Models\DiamondCertificate::all() as $certificate)
                                <option value="{{ $certificate->id }}">{{ $certificate->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has($field_name))
                            <span class="invalid feedback"role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                class="text-danger">
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <?php
                            $field_name = 'new_product.no_certificate';
                            $field_lable = label_case('no_certificate');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = "required";
                            ?>
                            <label for="{{ $field_name }}">@lang('No .Certificate') <span class="text-danger">*</span></label>
                            <input id="{{ $field_name }}" type="text" class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" wire:model.lazy="{{ $field_name }}">
                            @if ($errors->has($field_name))
                            <span class="invalid feedback"role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                class="text-danger">
                            </span>
                            @endif
                        </div>
                    </div>
    
                    <div class="flex relative py-1">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-b border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-left">
                            <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Berat <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Detail Berat Barang."></i>
                            </span>
                        </div>
                    </div>
    
    
                    <div class="grid grid-cols-2 gap-2">
                        
                        <div class="form-group">
                            <?php
                            $field_name = 'new_product.gold_weight';
                            $field_lable = label_case('emas');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = "required";
                            ?>
                            <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                            <input class="form-control @error($field_name) is-invalid @enderror"
                            type="number"
                            name="{{ $field_name }}"
                            min="0" step="0.01"
                            id="{{ $field_name }}"
                            wire:model.lazy="{{ $field_name }}"
                            wire:change="calculateTotalWeight"
                            placeholder="{{ $field_placeholder }}">
                            @if ($errors->has($field_name))
                            <span class="invalid feedback"role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                class="text-danger">
                            </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <?php
                            $field_name = 'new_product.total_weight';
                            $field_lable = label_case('Total');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = "required";
                            ?>
                            <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                            <input class="form-control"
                            type="number"
                            name="{{ $field_name }}"
                            id="{{ $field_name }}"
                            wire:model="{{ $field_name }}"
                            placeholder="{{ $field_placeholder }}"
                            readonly>
                        </div>
                        
                    </div>
    
                    @else
    
                    <div class="grid grid-cols-2 gap-2">
                        <div class="form-group">
                                <?php
                                $field_name = 'new_product.karat_id';
                                $field_lable = label_case('karat');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label for="{{ $field_name }}">@lang('Karat') <span class="text-danger">*</span></label>
                                <select class="form-control select2 @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                    <option value="" selected disabled>Pilih {{ $field_lable }}</option>
                                    @foreach($dataKarat as $jp)
                                    <option value="{{ $jp->id }}">{{ $jp->name }} {{$jp->kode}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has($field_name))
                                <span class="invalid feedback"role="alert">
                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                    class="text-danger">
                                </span>
                                @endif
                            </div>
                        </div>
    
                        {{-- BERAT --}}
    
                        <div class="flex relative py-1">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-b border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-left">
                                <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Berat <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Detail Berat Barang."></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-row grid grid-cols-4 gap-2">
                            
                        <div class="form-group">
                                <?php
                                $field_name = 'new_product.accessories_weight';
                                $field_lable = label_case('Accessories');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}</label>
                                <input class="form-control @error($field_name) is-invalid @enderror"
                                type="number"
                                name="{{ $field_name }}"
                                step="0.001"
                                wire:model.lazy="{{ $field_name }}"
                                wire:change="calculateTotalWeight()"
                                id="{{ $field_name }}"
                                placeholder="{{ $field_placeholder }}"
                                min="0"
                                >
                                @if ($errors->has($field_name))
                                <span class="invalid feedback"role="alert">
                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                    class="text-danger">
                                </span>
                                @endif
                            </div>
    
                        <div class="form-group">
                                <?php
                                $field_name = 'new_product.tag_weight';
                                $field_lable = label_case('tag');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}</label>
                                <input class="form-control @error($field_name) is-invalid @enderror"
                                type="number"
                                wire:model.lazy="{{ $field_name }}"
                                wire:change="calculateTotalWeight()"
                                min="0" step="0.001"
                                id="{{ $field_name }}"
                                placeholder="{{ $field_placeholder }}">
                                @if ($errors->has($field_name))
                                <span class="invalid feedback"role="alert">
                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                    class="text-danger">
                                </span>
                                @endif
                            </div>
    
                            <div class="form-group">
                                <?php
                                $field_name = 'new_product.gold_weight';
                                $field_lable = label_case('emas');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                <input class="form-control @error($field_name) is-invalid @enderror"
                                type="number"
                                name="{{ $field_name }}"
                                min="0" step="0.001"
                                id="{{ $field_name }}"
                                wire:model.lazy="{{ $field_name }}"
                                wire:change="calculateTotalWeight()"
                                placeholder="{{ $field_placeholder }}">
                                @if ($errors->has($field_name))
                                <span class="invalid feedback"role="alert">
                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                    class="text-danger">
                                </span>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <?php
                                $field_name = 'new_product.total_weight';
                                $field_lable = label_case('Total');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                <input class="form-control"
                                type="number"
                                name="{{ $field_name }}"
                                id="{{ $field_name }}"
                                wire:model="{{ $field_name }}"
                                placeholder="{{ $field_placeholder }}"
                                readonly>
                            </div>
                            
                        </div>
                        @endif
                        </div>
                        <div class="col-span-2">
                            <div class="form-group">
                                <x-library.distribusi-toko.emas.webcam />
                                @if ($errors->has('new_product.webcam_image'))
                                <span class="invalid feedback"role="alert">
                                    <small class="text-danger">{{ $errors->first('new_product.webcam_image') }}.</small
                                    class="text-danger">
                                </span>
                                @endif
                            </div>
                        </div>
                        
    
    
                    </div>
                    
                    <div class="float-right mt-5">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="$set('showModal',false)">Batal</button>
                        <button type="submit" class="btn btn-primary" wire:click.prevent="add_new_product">Tambah</button>
                    </div>
                </form>
        </div>

        </div>
    </div>
</div>