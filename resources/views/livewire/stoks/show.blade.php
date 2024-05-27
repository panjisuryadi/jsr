<div class="card">
    <div class="card-header d-flex flex-wrap align-items-center">
        <div>
            <h2 class="text-lg font-bold uppercase">detail stok pending</h2>
        </div>
        <a class="btn  mfs-auto btn-sm btn-success mfe-1" href="/"><i class="bi bi-house-door"></i>
            Dashboard
        </a>
    </div>
{{--    @dump($details)--}}
    <div class="card-body">
        <div class="table-responsive">
            <table style="width: 100% !important;" class="w-full table table-sm table-striped rounded-lg table-bordered">
                <thead>
                <tr>
                    <th class="text-center">
                        <div class="p-1">
                            <input type="checkbox" wire:model="selectAll" id="select-all">
                        </div>
                    </th>
                    <th class="text-center">No</th>
                    <th class="text-center">Image</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Code</th>
                    <th class="text-center">Category</th>
                    <th class="text-center">Berat</th>
                </tr>
                </thead>
                <tbody>
                @forelse($details as $row => $detail)
                    @php
                        $total_weight =+ $detail->berat_emas;
                        $image = $detail->images;
                        $imagePath = '';
                        if(empty($image)){
                            $imagePath = url('images/fallback_product_image.png');
                        }else{
                            $imagePath = asset(imageUrl().$image);
                        }
                    @endphp
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" wire:model="selectedItems" value="{{$detail->id}}" name="selected_items[]" />
                        </td>
                        <td class="text-center">{{$row + 1}}</td>
                        <td class="flex justify-center">
                            <a href="{{ $imagePath }}" data-lightbox="{{ @$image }} " class="single_image">
                                <img src="{{ $imagePath }}" order="0" width="100" class="img-thumbnail"/>
                            </a>
                        </td>
                        <td class="text-center">
                            <strong class="text-medium">{{@$detail->product_name}}</strong>
                        </td>
                        <td class="text-center">
                            <strong class="text-warning">{{@$detail->product_code}}</strong>
                        </td>
                        <td class="text-center">{{$detail->category->category_name}}</td>
                        <td class="text-center text-danger">{{formatWeight($detail->berat_emas)}}</td>
                    </tr>
                @empty
                    <tr>
                        <th colspan="8" class="text-center">Tidak ada Data</th>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="flex justify-end items-center mt-1 gap-3">
                <div>
                    <span class="font-bold text-gray-800-500">
                    <table style="width: 100% !important;" class="w-full table table-sm table-borderless rounded-lg">
                        <tr>
                            <td>Jumlah Barang</td>
                            <td>{{ count($selectedItems) }}</td>
                        </tr>
                        <tr>
                            <td>Total Berat</td>
                            <td>{{formatBerat($totalWeight)}}</td>
                        </tr>
                    </table>
                    </span>

                </div>
                <div>
                    <a href="#" class="px-5 btn btn-lg btn-success" wire:click.prevent="proses">Proses</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
         aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-lg font-bold" id="addModalLabel">Konfirmasi Penerimaan Barang</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    @php
                        $selected_count = 0;
                        if (isset($selectedItems) && is_array($selectedItems)) {
                            $selected_count = count($selectedItems);
                        }
                        $total_count = count($details);
                        $retur_count = $total_count - $selected_count;
                    @endphp
                    <p>Jumlah Barang diterima : <strong>{{ $selected_count }}</strong> buah</p>
                    <div class="flex mt-4">
                        <select class="form-control uppercase" name="status_id" id="status_id"
                                wire:model="selected_status_id" required>
                            <option value="" selected disabled>Pilih Status</option>
                            @forelse($product_status as $status)
                                <option value="{{$status->id}}" class="uppercase">
                                    {{ $status->name }}
                                </option>
                            @empty
                                <option value="" selected disabled>Pilih Status</option>
                            @endforelse
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="store">
                        @lang('Submit')
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>
