<div class="flex justify-between py-2 border-bottom">

 <div class="w-10 mt-4">
    <a class="link" href="{{ route('home') }}">
                <i class="bi bi-house-door-fill" style="font-size: 1rem;"></i>
            </a>
  </div>

<div class="flex-row grid grid-cols-3 gap-1">
  
 <div>
    
      <livewire:search-product/>
  </div>

  <div class="form-group">
                <label class="mb-0">Kategori</label>
                <select wire:model="category" class="form-control">
                    <option value="">Semua Produk</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>

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
