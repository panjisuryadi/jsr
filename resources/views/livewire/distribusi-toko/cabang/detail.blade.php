<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center">
                <div>
                    <span>DISTRIBUSI TOKO</span>
                </div>
                <a class="btn  mfs-auto btn-sm btn-success mfe-1" href="#"><i class="bi bi-house-door"></i> Dashboard
                </a>
                <a target="_blank" class="btn btn-sm btn-secondary mfe-1 d-print-none" href="#"><i class="bi bi-printer"></i> Print
                </a>
                <a id="Tracking" class="btn btn-sm btn-info mfe-1 d-print-none" href="#" wire:click.prevent="showTracking">
                    <i class="bi bi-save"></i> Tracking Product
                </a>
            </div>




            <div class="card-body px-4">
                <div class="row mb-4">

                    <div class="col-sm-6 mb-4 mb-md-0">
                        <h5 class="mb-2 border-bottom pb-2">Invoice Info:</h5>
                        <div>Invoice: <strong>{{ $dist_toko->no_invoice }}</strong></div>
                        <div>Tanggal: <strong> {{ \Carbon\Carbon::parse($dist_toko->date)->format('d M, Y') }}</strong></div>
                        <div>Cabang: <strong>{{ $dist_toko->cabang->name }}</strong></div>
                        <div>
                            Dibuat oleh: <strong>{{ $dist_toko->created_by }}</strong>
                        </div>

                    </div>
                    <div class="col-sm-6 mb-3 mb-md-0">
                        <h5 class="mb-2 border-bottom pb-2">Distribusi Info:</h5>
                        <div>Jumlah Item: <strong>{{ $dist_toko->items->count() }} buah</strong></div>
                        <div>Jumlah Jenis Karat: <strong> {{ $dist_toko->items->groupBy('karat_id')->count() }} </strong></div>
                        <div>Total Berat Emas: <strong> {{ $dist_toko->items->sum('gold_weight') }} gr</strong></div>
                        <div>
                            {{ Label_case('Status') }}: <label class="bg-white border-2 font-semibold uppercase border-green-500  text-green-500 py-0 px-4 m-1">Draft</label>
                        </div>

                    </div>
                </div>

                <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">


                    <div class="flex relative py-1 pb-3">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-b border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-left">
                            <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">
                                <span class="text-blue-400">Distribusi Toko Detail

                                </span>

                        </div>
                    </div>


                    <form action="{{ route('distribusitoko.approve_distribusi', $dist_toko) }}" method="POST">

                        @csrf

                        <table style="width: 100% !important;" class="table table-sm table-striped rounded rounded-lg table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <div class="p-1">
                                            <input type="checkbox" id="select-all">
                                        </div>

                                    </th>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Karat</th>
                                    <th class="text-center">Berat Emas</th>
                                    <th class="text-center">Produk</th>
                                    <th class="text-center">Group</th>
                                    <th class="text-center">Model</th>
                                    <th class="text-center">Code</th>
                                    <th class="text-center">Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $total_weight = 0;
                                @endphp
                                @forelse($dist_toko->items as $row)
                                @php
                                $data = json_decode($row->additional_data)->product_information;
                                $total_weight = $total_weight + $row->gold_weight;
                                @endphp
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" wire:model.lazy="selectedItems" value="{{$row->id}}" />
                                    </td>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td class="text-center font-semibold"> {{@$row->karat->name}} gr</td>
                                    <td class="text-center font-semibold"> {{@$row->gold_weight}} gr</td>
                                    <td class="text-center font-semibold">{{ $data->product_category->name }}</td>
                                    <td class="text-center font-semibold">{{ $data->group->name }}</td>
                                    <td class="text-center font-semibold">{{ $data->model->name }}</td>
                                    <td class="text-center font-semibold">{{ $data->code }}</td>
                                    <td class="text-center font-semibold">
                                        <a href="#" class="hover:text-blue-400 btn btn-sm btn-danger px-4">Preview</a>

                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <th colspan="5" class="text-center">Tidak ada data</th>
                                </tr>
                                @endforelse
                                <tr>
                                    <td class="border-0" colspan="3"></td>
                                    <td class="border-0"></td>
                                    <td class="border-0"></td>
                                    <td class="border-0"></td>
                                    <td class="border-0">

                                    </td>

                                    <td colspan="2" class="border-0 text-center font-semibold">
                                        <div class="text-right px-3 text-2xl">
                                            <span class="text-base text-gray-500"> Jumlah Emas : </span>

                                            <span class="px-2"> {{ $total_weight }} <small>GR</small></span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>

                        </table>


                </div>

                <div class="flex flex-col grid grid-cols-2 gap-2">

                    <div></div>

                    <div class="px-2">

                        <div class="form-group">
                            <?php
                            $field_name = 'status';
                            $field_lable = label_case('Status');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = "required";
                            ?>
                            <label class="mb-0" for="{{ $field_name }}">@lang('Status') <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm" name="{{ $field_name }}" id="{{ $field_name }}" required>
                                <option value="" selected disabled>@lang('Status')</option>
                                <option value="3">Approved</option>
                                <option value="4">Reject</option>
                            </select>
                            <div class="invalid feedback" role="alert">
                                <span class="text-danger error-text {{ $field_name }}_err"></span>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label style="font-size: 0.7rem;" class="mb-0" for="status">@lang('Note') <span class="text-danger">(Optional)</span></label>
                            <textarea name="note" id="note" rows="2" class="form-control form-control-sm"></textarea>
                        </div>


                    </div>


                </div>

                <div class="flex justify-between mt-1 ">
                    <div></div>
                    <div>

                        <a href="#" class="px-5 btn btn-lg btn-success" wire:click.prevent="proses">Proses</a>
                    </div>
                </div>



                </form>




            </div>
        </div>
    </div>
</div>