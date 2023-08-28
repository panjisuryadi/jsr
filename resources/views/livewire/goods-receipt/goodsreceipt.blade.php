<div>
    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif
    <form wire:submit.prevent="store">
        @csrf
        <div class="flex justify-between">
            <div class="add-input w-full mx-auto flex flex-row grid grid-cols-2 gap-2">
                <div class="form-group">
                    <?php
                    $field_name = 'no_invoice.0';
                    $field_lable = label_case('no_invoice');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"';
                    ?>
                    {{ html()->number($field_name)->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control   '.$invalid.'')->attributes(["$required"]) }}
                    @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                </div>


   <div class="form-group">
                    <?php
                    $field_name = 'qty.0';
                    $field_lable = label_case('qty');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"';
                    ?>
                    {{ html()->number($field_name)->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control   '.$invalid.'')->attributes(["$required"]) }}
                    @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                </div>






            </div>
            <div class="px-1">
                <button class="btn text-white text-xl btn-info btn-md" wire:click.prevent="add({{$i}})" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="add"><i class="bi bi-plus"></i></span>
                <span wire:loading wire:target="add" class="text-center">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
                </button>
            </div>
        </div>
        @foreach($inputs as $key => $value)
        <div class="flex justify-between">
            <div class="add-input w-full mx-auto flex flex-row grid grid-cols-2 gap-2">
                <div class="form-group">
                    <?php
                    $field_name = 'no_invoice.'.$value.'';
                    $field_lable = label_case('no_invoice');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"';
                    ?>
                    {{ html()->number($field_name)
                        ->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control   '.$invalid.'')
                    ->attributes(["$required"]) }}
                    @error('qty.'.$value)
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
  <div class="form-group">
                    <?php
                    $field_name = 'qty.'.$value.'';
                    $field_lable = label_case('qty');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"';
                    ?>
                    {{ html()->number($field_name)
                        ->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control   '.$invalid.'')
                    ->attributes(["$required"]) }}
                    @error('qty.'.$value)
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>







            </div>
            <div class="px-1">
                <button class="btn text-white text-xl btn-danger btn-md" wire:click.prevent="remove({{$key}})" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="remove({{$key}})"><i class="bi bi-trash"></i></span>
                <span wire:loading wire:target="remove({{$key}})" class="text-center">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
                </button>
            </div>
        </div>
        @endforeach
        <div class="pt-2 border-t flex justify-between">
            <div></div>
            <div class="form-group">
                <a class="px-5 btn btn-danger"
                    href="{{ route("goodsreceipt.index") }}">
                @lang('Cancel')</a>
 <button class="px-5 btn  btn-submit btn-success" wire:click.prevent="store" wire:target="store" wire:loading.attr="disabled">
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