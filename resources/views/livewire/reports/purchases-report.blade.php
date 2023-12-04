<div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form wire:submit.prevent="generateReport">
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Start Date <span class="text-danger">*</span></label>
                                    <input wire:model.defer="start_date" type="date" class="form-control" name="start_date">
                                    @error('start_date')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>End Date <span class="text-danger">*</span></label>
                                    <input wire:model.defer="end_date" type="date" class="form-control" name="end_date">
                                    @error('end_date')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Supplier</label>
                                    <select wire:model.defer="supplier_id" class="form-control" name="supplier_id">
                                        <option value="">Select Supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <span wire:target="generateReport" wire:loading class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <i wire:target="generateReport" wire:loading.remove class="bi bi-shuffle"></i>
                                Filter Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <table class="table table-bordered table-striped text-center mb-0">
                        <div wire:loading.flex class="col-12 position-absolute justify-content-center align-items-center" style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <thead>
                        <tr>
                            <th>@lang('Transaction Date')</th>
                            <th>@lang('Transaction No')</th>
                            <th>@lang('Supplier')</th>
                            <th >@lang('Detail')</th>
                            <th>@lang('Total')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($datas as $data)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($data->date)->format('d M, Y') }}</td>
                                <td>{{ $data->code }}</td>
                                <td>{{ $data->supplier->supplier_name }}</td>
                                <td  class="text-left">
                                    <div class="text-xs">
                                        <b>No. Surat Jalan / Invoice</b> : {{ $data->no_invoice }}
                                    </div>
                                    <div class="text-xs">
                                        <b>Tgl Bayar </b> : {{ $data->pembelian->updated_at }} {{-- tgl pembayarn diambil dari updated at untuk akomodir semua case pembayaran, ketika cicilan, jatuh tempo, dan lunas maka dia akan update ke table tipe pembelian--}}
                                    </div>
                                    <div class="text-xs">
                                        <b>Karat </b>: {{ $data->goodsreceiptitem->pluck('karat.label')->implode(', ')  }}
                                    </div>
                                    <div class="text-xs">
                                        <b>Berat yang dibayar</b> : {{ $data->total_berat }} gr
                                    </div>
                                </td>
                                <td>Rp. {{ number_format($data->harga_beli) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <span class="text-danger">No Purchases Data Available!</span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div @class(['mt-3' => $datas->hasPages()])>
                        {{ $datas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
