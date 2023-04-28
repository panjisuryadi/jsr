<div>

            <div class="form-group">
                <label for="parent_id">@lang('Locations') <span class="text-danger">*</span></label>
                <select wire:model="parent_id" wire:change="getParentlocations" name="parent_id" class="form-control form-control-sm">
                    <option value="">-- @lang('Select') @lang('Locations') --</option>
                    @foreach($main as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

    {{--          <div class="form-group">
                    <label for="sub"> @lang('Sub Locations') <span class="text-danger">*</span></label>
                    <select wire:model="sub_location" name="sub_location" class="form-control form-control-sm">
                        <option value="">-- @lang('Select') @lang('Sub Locations') --</option>
                        @if(!empty($locations))
                        @foreach($locations as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
 --}}

        <div class="form-group">
                <label>Pilih Parent*</label>
                <select wire:model="sub_location" name="sub_location" class="form-control form-control-sm">
                    <option value=""> -- Pilih  Parent Lokasi -- </option>
                    @if($locations)
                    <?php $no = 1; ?>
                    @foreach($locations as $location)
                    <?php $dash='>'; ?>
                    <option value="{{$location->id}}" level="<?php echo strlen(trim($dash)); ?>">{!! $dash !!}
                        &nbsp;{{$location->name}}
                </option>
                    @if(count($location->childs))
                        @include('locations::locations.partials.option_location',['sublocations' => $location->childs])
                    @endif
                    @endforeach
                    @endif
                </select>
            </div>










</div>