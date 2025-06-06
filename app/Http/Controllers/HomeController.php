<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Expense\Entities\Expense;
use Modules\Product\Entities\Product;
use Modules\Purchase\Entities\Purchase;
use Modules\Purchase\Entities\PurchasePayment;
use Modules\PurchasesReturn\Entities\PurchaseReturn;
use Modules\PurchasesReturn\Entities\PurchaseReturnPayment;
use Modules\UserLogin\Models\UserLogin;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SalePayment;
use Modules\SalesReturn\Entities\SaleReturn;
use Modules\SalesReturn\Entities\SaleReturnPayment;
use App\Models\ActivityLog;
use Modules\Adjustment\Entities\AdjustmentSetting;
class HomeController extends Controller
{

    public function index(Request $request){

        $paging = $request->get('key') ?? '';
         //dd($paging);
        // activity()->log(' '.auth()->user()->name.'Masuk ke halaman Dashoard ');

      $lastActivity = ActivityLog::latest()->Join('users', 'activity_log.causer_id', '=', 'users.id')
            ->select(['activity_log.id', 'activity_log.description',  'activity_log.log_name',  'activity_log.created_at',
                'users.name', 'activity_log.updated_at'])
                      ->limit(5)
            ->orderBy('activity_log.id', 'DESC')->get();

        $userlogin = UserLogin::latest()
        ->Join('users', 'user_logins.user_id', '=', 'users.id')
        ->select(['user_logins.id',
                'user_logins.ip',
                'user_logins.os',
                'user_logins.browser',
                'users.name',
                'user_logins.location',
                'user_logins.status',
                'user_logins.login_at',
                'user_logins.logout_at',
                'user_logins.created_at',
                'users.name', 'user_logins.updated_at'])
        ->limit(4)->get();
        $sales = Sale::completed()->sum('total_amount');
        $sale_returns = SaleReturn::completed()->sum('total_amount');
        $purchase_returns = PurchaseReturn::completed()->sum('total_amount');
        $product_costs = 0;

        foreach (Sale::completed()->with('saleDetails')->get() as $sale) {
            foreach ($sale->saleDetails??[] as $saleDetail) {
                $product_costs += $saleDetail->product->product_cost ?? 0;
            }
        }

        $revenue = ($sales - $sale_returns) / 100;
        $profit = $revenue - $product_costs;
        $sales = Sale::completed()->sum('total_amount');
        $status = $request->status ?? '';

        return view('home', [
            'paging'     => $paging,
            'userlogin'     => $userlogin,
            'sales'     => $sales,
            'status'     => $status,
            'lastActivity'     => $lastActivity,
            'revenue'          => $revenue,
            'sale_returns'     => $sale_returns / 100,
            'purchase_returns' => $purchase_returns / 100,
            'profit'           => $profit
        ]);
    }




  public function distribusi(Request $request) {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $status = $request->status ?? '';
        $sales = Sale::completed()->sum('total_amount');
        return view('home', [
            'status'           => $status,
            'sales'            => $sales
        ]);
    }

  public function buysbacknota(Request $request) {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $status = $request->status ?? '';
        $sales = Sale::completed()->sum('total_amount');
        return view('partial.pages.buysbacknota.index', [
            'status'           => $status,
            'sales'            => $sales
        ]);
    }








    public function currentMonthChart() {
        abort_if(!request()->ajax(), 404);
        $currentMonthSales = Sale::where('status', 'Completed')->whereMonth('date', date('m'))
                ->whereYear('date', date('Y'))
                ->sum('total_amount') / 100;
        $currentMonthPurchases = Purchase::where('status', 'Completed')->whereMonth('date', date('m'))
                ->whereYear('date', date('Y'))
                ->sum('total_amount') / 100;
        $currentMonthExpenses = Expense::whereMonth('date', date('m'))
                ->whereYear('date', date('Y'))
                ->sum('amount') / 100;

        return response()->json([
            'sales'     => $currentMonthSales,
            'purchases' => $currentMonthPurchases,
            'expenses'  => $currentMonthExpenses
        ]);
    }


    public function salesPurchasesChart() {
        abort_if(!request()->ajax(), 404);
        $sales = $this->salesChartData();
        $purchases = $this->purchasesChartData();
        return response()->json(['sales' => $sales, 'purchases' => $purchases]);
    }


    public function paymentChart() {
        abort_if(!request()->ajax(), 404);

        $dates = collect();
        foreach (range(-11, 0) as $i) {
            $date = Carbon::now()->addMonths($i)->format('m-Y');
            $dates->put($date, 0);
        }

        $date_range = Carbon::today()->subYear()->format('Y-m-d');

        $sale_payments = SalePayment::where('date', '>=', $date_range)
            ->select([
                DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                DB::raw("SUM(amount) as amount")
            ])
            ->groupBy('month')->orderBy('month')
            ->get()->pluck('amount', 'month');

        $sale_return_payments = SaleReturnPayment::where('date', '>=', $date_range)
            ->select([
                DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                DB::raw("SUM(amount) as amount")
            ])
            ->groupBy('month')->orderBy('month')
            ->get()->pluck('amount', 'month');

        $purchase_payments = PurchasePayment::where('date', '>=', $date_range)
            ->select([
                DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                DB::raw("SUM(amount) as amount")
            ])
            ->groupBy('month')->orderBy('month')
            ->get()->pluck('amount', 'month');

        $purchase_return_payments = PurchaseReturnPayment::where('date', '>=', $date_range)
            ->select([
                DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                DB::raw("SUM(amount) as amount")
            ])
            ->groupBy('month')->orderBy('month')
            ->get()->pluck('amount', 'month');

        $expenses = Expense::where('date', '>=', $date_range)
            ->select([
                DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                DB::raw("SUM(amount) as amount")
            ])
            ->groupBy('month')->orderBy('month')
            ->get()->pluck('amount', 'month');

        $payment_received = array_merge_numeric_values($sale_payments, $purchase_return_payments);
        $payment_sent = array_merge_numeric_values($purchase_payments, $sale_return_payments, $expenses);

        $dates_received = $dates->merge($payment_received);
        $dates_sent = $dates->merge($payment_sent);

        $received_payments = [];
        $sent_payments = [];
        $months = [];

        foreach ($dates_received as $key => $value) {
            $received_payments[] = $value;
            $months[] = $key;
        }

        foreach ($dates_sent as $key => $value) {
            $sent_payments[] = $value;
        }

        return response()->json([
            'payment_sent' => $sent_payments,
            'payment_received' => $received_payments,
            'months' => $months,
        ]);
    }

    public function salesChartData() {
        $dates = collect();
        foreach (range(-6, 0) as $i) {
            $date = Carbon::now()->addDays($i)->format('d-m-y');
            $dates->put($date, 0);
        }

        $date_range = Carbon::today()->subDays(6);

        $sales = Sale::where('status', 'Completed')
            ->where('date', '>=', $date_range)
            ->groupBy(DB::raw("DATE_FORMAT(date,'%d-%m-%y')"))
            ->orderBy('date')
            ->get([
                DB::raw(DB::raw("DATE_FORMAT(date,'%d-%m-%y') as date")),
                DB::raw('SUM(total_amount) AS count'),
            ])
            ->pluck('count', 'date');

        $dates = $dates->merge($sales);

        $data = [];
        $days = [];
        foreach ($dates as $key => $value) {
            $data[] = $value / 100;
            $days[] = $key;
        }

        return response()->json(['data' => $data, 'days' => $days]);
    }


    public function purchasesChartData() {
        $dates = collect();
        foreach (range(-6, 0) as $i) {
            $date = Carbon::now()->addDays($i)->format('d-m-y');
            $dates->put($date, 0);
        }

        $date_range = Carbon::today()->subDays(6);

        $purchases = Purchase::where('status', 'Completed')
            ->where('date', '>=', $date_range)
            ->groupBy(DB::raw("DATE_FORMAT(date,'%d-%m-%y')"))
            ->orderBy('date')
            ->get([
                DB::raw(DB::raw("DATE_FORMAT(date,'%d-%m-%y') as date")),
                DB::raw('SUM(total_amount) AS count'),
            ])
            ->pluck('count', 'date');

        $dates = $dates->merge($purchases);

        $data = [];
        $days = [];
        foreach ($dates as $key => $value) {
            $data[] = $value / 100;
            $days[] = $key;
        }

        return response()->json(['data' => $data, 'days' => $days]);

    }


}
