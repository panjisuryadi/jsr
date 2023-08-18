<div class="form-group">
    <label class="mb-1">Product Category</label>
    <select wire:model="category" class="form-control">
        <option value="">All Products</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
        @endforeach
    </select>
</div>


