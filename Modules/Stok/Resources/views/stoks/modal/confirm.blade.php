<div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Konfirmasi Penerimaan Barang</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                @dump($selectedItems)
                @php
                    $selected_count = count($selectedItems);
                    $total_count = count($details);
                    $retur_count = $total_count - $selected_count;
                @endphp
                <p>Jumlah Barang diterima : <strong>{{ $total_count }}</strong> buah</p>
                <div class="flex mt-4">
                    <select class="form-control uppercase" name="status_id" id="status_id" required>
                        <option value="" selected disabled>Pilih Status</option>
                        @foreach(\Modules\Product\Models\ProductStatus::get() as $status)
                            <option value="{{$status->id}}" class="uppercase">
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @if ($retur_count)
                    <p>Jumlah Barang di Retur : <strong>{{ $retur_count }}</strong> buah</p>
                    <div class="form-group mt-3">
                        <label for="note" class="font-medium">Catatan / Berita Acara</label>
                        <textarea id="note" class="form-control" wire:model="note" cols="30" rows="10" placeholder="Tulis disini..."></textarea>
                        @if($errors->has('note'))
                            <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first('note') }}.</small>
                    </span>
                        @endif
                    </div>
                @endif

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" wire:click.prevent="submit">
                    @lang('Submit')
                </button>
            </div>

        </div>
    </div>
</div>
