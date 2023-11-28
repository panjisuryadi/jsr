<div>
    <div class="col-md-12">
        @if(!auth()->user()->isUserCabang())
        <div class="form-group">
            <?php
                $field_name = 'cabang_id';
                $field_lable = __('Pilih Canag');
                $field_placeholder = Label_case($field_lable);
                $required = '';
            ?>
            <select id="{{ $field_name }}" class="form-control"  name="{{ $field_name }}" wire:model = "{{ $field_name }}">
                <option value="">Pilih </option>
                @foreach(\Modules\Cabang\Models\Cabang::all() as $item)
                    <option data-val="{{ $item->id }}" value="{{ $item->id }}" > {{ $item->name }} </option>
                @endforeach
            </select>
            @if ($errors->has($field_name))
            <span class="invalid feedback" role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
            </span>
            @endif
        </div>
        @endif

        <!-- Search box -->
        <div class="row">
       <div class="col-md-6 col-sm-6">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Cari Produk" style="width: 100%;" wire:model="searchTerm" >
        </div>
    </div>
       <div class="col-md-6 col-sm-6">
        <div class="form-group">

        </div>


       </div>

        </div>
        <!-- Paginated records -->
        
        <div class="table-responsive">
        <table class="table table-sm table-striped" style="width: 100%;">
            <thead>
                <tr>
                     <th class="no-sort text-center">No</th>
                    <th class="no-sort">Karat</th>
                    <th class="no-sort">Stok</th>
                    <th class="no-sort text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($products->count())
                @foreach ($products as $key => $value)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $value->karat->name }} - {{$value->karat->kode}}</td>
                    <td>{{ $value->berat_real }}</td>
                    <td>
            <button wire:click="selectProduct('{{ $value->id }}')" class="w-100 btn btn-sm btn-outline-success " style="cursor: pointer;"> 
                Tambah
            </button>
             </td>
                </tr>
                @livewire('stock-opname.cabang.modal', ['data'=>$value,'key'=>$value->id,'active_location' => $active_location['label']],key('modal-'.$value->id))
                @endforeach
                @else
                <tr>
                    <td colspan="6" align="center">No record found</td>
                </tr>
                @endif
            </tbody>
        </table>
        <!-- Pagination navigation links -->
        {{ $products->links() }}
        </div>
    </div>
    
</div>


@push('page_scripts')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('showModal', function(data){
            $("#addModal"+data.modalId).modal('show');
        });
        Livewire.on('closeModal', function (data) {
            $("#addModal"+data.modalId).modal('hide');
        });

        $("#cabang_id").on('change', function(){
            console.log($.data(this))
            if($("#cabang_id").val()) {
                if(confirm('Jika cabang dirubah, maka semua perubahan akan direset!')) {
                    // Livewire.emit('resetAll'); // Belum
                }
            }

        })
    });
</script>

@endpush