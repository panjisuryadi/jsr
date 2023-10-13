<?php


namespace Modules\Adjustment\Http\Controllers\GudangOffice;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Adjustment\Entities\AdjustmentSetting;

class AdjustmentController extends Controller {
    

    public function index(){
        abort_if(Gate::denies('access_adjustments'), 403);
        $location = AdjustmentSetting::LOCATION['1'];
        return view('adjustment::gudang-office.index',compact('location'));
    }
}