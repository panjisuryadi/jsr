<?php

namespace Modules\Adjustment\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Adjustment\Entities\AdjustmentSetting;

class AdjustmentSettingController extends Controller{


    public function destroy(){
        abort_if(Gate::denies('access_adjustments'), 403);
        $setting = AdjustmentSetting::first();
        $setting->delete();

        return response()->json([
            'message' => 'Adjustment Berhasil dihentikan',
            'redirectRoute' => route('adjustments.index')
        ]);
    }
}