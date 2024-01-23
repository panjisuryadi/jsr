<?php

namespace Modules\Sale\Http\Controllers;

use DateTime;
use App\Models\LookUp;
use Illuminate\Http\Request;
use Modules\Cabang\Models\Cabang;
use Illuminate\Routing\Controller;
use Modules\Sale\Entities\Customs;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Category;
use Illuminate\Contracts\Support\Renderable;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\Produksi\Models\DiamondCertificateAttributes;

class CustomController extends Controller
{
    public $dataKategoriProduk = [];
    public $id_kategoriproduk_berlian;
    public $dataCertificateAttribute;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $customs = Customs::get();
        $cabangs = Cabang::get();
        $customsArray = $customs->toArray();

        return view('sale::custom.index', compact('cabangs'))->with(['customs' => $customsArray]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $code = Product::generateCode();
        $hari_ini = new DateTime();
        $hari_ini = $hari_ini->format('Y-m-d');
        $id_kategoriproduk_berlian = LookUp::select('value')->where('kode', 'id_kategoriproduk_berlian')->first();
        $id_kategoriproduk_berlian = !empty($id_kategoriproduk_berlian['value']) ? $id_kategoriproduk_berlian['value'] : 0;
        $dataKategoriProduk = Category::where('kategori_produk_id', $id_kategoriproduk_berlian)->get();
        $this->dataCertificateAttribute = DiamondCertificateAttributes::all();
        return view('sale::custom.create', compact(
            'code',
            'hari_ini',
            'id_kategoriproduk_berlian'
        ))->with([
            'dataKategoriProduk' => $dataKategoriProduk,
            'dataCertificateAttribute' => $this->dataCertificateAttribute
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('sale::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('sale::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
