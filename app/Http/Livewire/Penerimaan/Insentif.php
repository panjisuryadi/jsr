<?php

namespace App\Http\Livewire\Penerimaan;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\PenerimaanBarangLuar\Events\PenerimaanBarangLuarCreated;
use Modules\PenerimaanBarangLuar\Models\PenerimaanBarangLuar;
use Modules\Cabang\Models\Cabang;
use Modules\Status\Models\ProsesStatus;
use Lang;
use Auth;

use Livewire\Component;

class Insentif extends Component
{

    public $products;
    public $categories;
    public $bulan;

    public function render()
    {
        return view('livewire.penerimaan.insentif');
    }

    public function pilihBulan($bulan) {
        $this->bulan = $bulan;
        //$this->resetPage();
    }








}
