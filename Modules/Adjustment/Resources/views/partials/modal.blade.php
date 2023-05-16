<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Detail Stock</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table">
                <tr>
                    <th>
                        Nama Product
                    </th>
                    <td>
                        <span id="product_name"></span>
                    </td>
                </tr>
                <tr>
                    <th>
                        Jenis
                    </th>
                    <td>
                        <span id="type_name"></span>
                    </td>
                </tr>
                <tr>
                    <th>
                        Stock
                    </th>
                    <td>
                        <span id="stock_name"></span>
                    </td>
                </tr>
                <tr>
                    <th>
                        Location
                    </th>
                    <td>
                        <span id="location_name"></span>
                    </td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmmodal" tabindex="-1" role="dialog" aria-labelledby="confirmmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="confirmmodalLabel">Pilih Lokasi</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <h2>
                Bila anda menjalankan Stock Opname, Feature Pembelian, POS dan Penjualan akan dikunci.
            </h2>
            <form action="">
                <div class="row pt-2">
                    <div class="col-12 form-group">
                            <label for="">Pilih Lokasi Stock Opname</label> <br>
                        <button class="btn btn-success btn-sm" type="button" id="checkAllBtn">Semua Lokasi</button>
                        @foreach ($location as $location)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{$location->location_id}}" id="">
                            <label class="form-check-label">
                                {{$location->location->name}} ({{$location->count}} Produk)
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary" onclick="runningadjustment()">
                @lang('Run Adjustment') 
            </button>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailmodal" tabindex="-1" role="dialog" aria-labelledby="detailmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="detailmodalLabel">Detail</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div id="modal-content">

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
        </div>
    </div>
</div>