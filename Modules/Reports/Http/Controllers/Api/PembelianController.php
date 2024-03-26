<?php

namespace Modules\Reports\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use DateTime;
use Modules\Sale\Entities\Sale;
use Illuminate\Http\Response;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use Modules\People\Entities\Supplier;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function index(Request $request)
    {
        try {
      
           $year = $request->year;
            if (empty($year)) {
                $year = date('Y'); 
            }
           $goodsreceipt = GoodsReceipt::debts()
                  ->orderBy('date', 'desc');
           $goodsreceipt->orderBy('date', 'desc');
           $listdata = $goodsreceipt->clone()->get();
            $data = $listdata;
            if ($data) {
                return response([
                    'status' => 'success',
                    'data' => $data
                ], 200);
            } else {
                return response([
                    'status' => 'error',
                    'data' => "No record found"
                ], 404);
            }
           }catch (\Exception $exception) {
            return response([
                'status' => 'error',
                'message' => "Failed to get Data, please try again. {$exception->getMessage()}"
            ], 500);
          }
      }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('reports::create');
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
        return view('reports::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('reports::edit');
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
