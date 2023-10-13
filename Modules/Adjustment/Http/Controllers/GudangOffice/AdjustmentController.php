<?php


namespace Modules\Adjustment\Http\Controllers\GudangOffice;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Adjustment\Entities\Adjustment;
use Modules\Adjustment\Entities\AdjustmentSetting;

class AdjustmentController extends Controller {
    

    public function index(){
        abort_if(Gate::denies('access_adjustments'), 403);
        $location = AdjustmentSetting::LOCATION['1'];
        return view('adjustment::gudang-office.index',compact('location'));
    }

    public function create(){
        abort_if(Gate::denies('create_adjustments'), 403);
        $number = Adjustment::max('id') + 1;
        $reference = make_reference_id('ADJ', $number);
        $setting = AdjustmentSetting::first();
        $active_location = [
            'id' => json_decode($setting->location)[0],
            'label' => AdjustmentSetting::LOCATION[json_decode($setting->location)[0]],
        ];
        return view('adjustment::gudang-office.create',compact('reference','active_location'));
    }
}