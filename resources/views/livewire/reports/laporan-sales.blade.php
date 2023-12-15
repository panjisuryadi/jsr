
<div class="form-group">
    <label for="">Data Sales</label>
    <select wire:click="cariSales($event.target.value)" name="sales"
        id="sales" class="form-control">
        <option value="">Pilih Sales</option>
        @foreach ($datasales as $row)
        <option value="{{ $row->id }}">{{ $row->name }}</option>
        @endforeach
    </select>
</div>

    <div class="form-group">
        <div class="form-group">
            <label for="">Pilih Periode Jurnal</label>
            <select name="" id="type" class="form-control">
                <option value="year" selected="">Tahunan</option>
                <option value="month">Bulanan</option>
            </select>
        </div>
    </div>

      <div class="form-group">
            <label for="">Pilih Periode</label>
            <select name="" id="type" class="form-control">
                <option value="year" selected="">Tahunan</option>
                <option value="month">Bulanan</option>
            </select>

        </div>

