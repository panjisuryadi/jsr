<div class="row mt-0 p-3">


    <div class="col-md-5 bg-white">
        <div class="pt-3">
            @if($active_location['id'] == '1')
            <?php
            $model = "Modules\Stok\Models\StockOffice";
            ?>
            <livewire:stock-opname.gudang-office.table :active_location="$active_location" :model="$model" />
            @endif
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">

            <div class="card-body">
                @include('utils.alerts')
                <form action="{{ route('adjustments.store') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="reference">Reference <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="reference" required readonly value="ADJ">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="from-group">
                                <div class="form-group">
                                    <label for="date">Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control form-control-sm" name="date" required value="{{ now()->format('Y-m-d') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="tablelist">
                            <thead>
                                <tr class="align-middle">
                                    <th class="align-middle">@lang('Product Name')</th>
                                    <th class="align-middle">@lang('Location')</th>
                                    <th class="align-middle">Stock Data</th>
                                    <th class="align-middle">@lang('Stock Rill')</th>
                                    <th class="align-middle">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($adjustment_items as $item )
                                <tr>
                                    <td>{{ $item['karat']['name'] }} {{ $item['karat']['kode'] }}</td>
                                    <td>{{ $active_location['label'] }}</td>
                                    <td>{{ $item['stock_data'] }}</td>
                                    <td>{{ $item['stock_rill'] }}</td>
                                    <td>Aksi</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>



                    <div class="form-group">
                        <label for="notes">Note <span class="small text-danger">( @lang('If Needed'))</span></label>
                        <textarea name="notes" id="notes" rows="3" class="form-control"></textarea>
                    </div>




                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            @lang('Create Adjustment') <i class="bi bi-check"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('page_scripts')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('alreadySelected', function () {
            toastr.error('Item sudah dipilih!');
        });
    });
</script>

@endpush