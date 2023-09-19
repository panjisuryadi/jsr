<div>

<div class="flex gap-2">
  <div class="w-3/4">
  <div class="form-group">
                <label class="mb-0">Kategori</label>
                <select wire:model="category" class="form-control">
                    <option value="">Semua Produk</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>

</div>
  <div class="w-1/4">

  <div class="form-group">
                <label class="mb-0">Jumlah Produk</label>
                <select wire:model="showCount" class="form-control">
                    <option value="9">9 Products</option>
                    <option value="15">15 Products</option>
                    <option value="21">21 Products</option>
                    <option value="30">30 Products</option>
                    <option value="">All Products</option>
                </select>
            </div>


</div>
</div>


</div>
