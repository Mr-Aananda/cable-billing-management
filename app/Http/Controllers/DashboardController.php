<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data = [];

        // check user has permission to see last login history
        if (auth()->user()->can('last_login_history')) {
            $data['users'] = User::query()
                ->get();
        }
        $data['customers'] = Customer::all();
        // $data['active_customers'] = Customer::whereHas('sales', function ($query) {
        //     $query->where('status','active');
        // })->count();
         $data['active_customers'] = Customer::whereHas('sales', function ($query) {
            $query->where('status', 'active');
        })
            ->with(['sales' => function ($query) {
                $query->where('status', 'active');
            }])
            ->get()
            ->reduce(function ($count, $customer) {
                return $count + $customer->sales->count();
            }, 0);

        $data['customer_due'] = Customer::where('balance', '>', 0)->get()->sum('balance');
        $data['suppliers'] = Supplier::all();
        $data['supplier_due'] = Supplier::where('balance', '<', 0)->get()->sum('balance');
        $date = date('Y-m-d');
        $data['total_sale'] = Sale::whereDate('date', $date)->get()->sum('grand_total');
        // $data['total_sale_due'] = Sale::all()->sum('total_due');
        $data['total_purchase'] = Purchase::whereDate('date', $date)->get()->sum('grand_total');
        // $data['total_purchase_due'] = Purchase::all()->sum('total_due');
        $data['total_expense_amount'] = Expense::whereDate('date', $date)->get()->sum('amount');
        // $data['total_expenses'] = $data['total_purchase'] + $data['total_expense_amount'];
        $data['total_cashes'] = Cash::sum('balance');

        $data['purchase_monthly_data'] = $this->getMonthlyPurchaseData();
        $data['sale_monthly_data'] = $this->getMonthlySaleData();
        $data['daily_sale_data'] = $this->getDailySaleData();
        $data['daily_purchase_data'] = $this->getDailyPurchaseData();

        return view('dashboard')->with($data);
    }

    /**
     * get monthly purchase total data
     * @return void
     */
    public function getMonthlyPurchaseData()
    {
        $carbon = $this->getCarbonMonthlyData();
        $purchase_monthly_data = [];

        foreach (Carbon::parse($carbon['startOfYear'])->range($carbon['endOfYear'], $carbon['interval']) as $month) {
            // get every month data
            $purchase_monthly_data[$month->format('M')] = Purchase::whereMonth('date', $month)
                ->get()->sum('grand_total');
        }
        return $purchase_monthly_data;
    }

    /**
     * get monthly sale total data
     * @return void
     */
    public function getMonthlySaleData()
    {
        $carbon = $this->getCarbonMonthlyData();
        $sale_monthly_data = [];

        foreach (Carbon::parse($carbon['startOfYear'])->range($carbon['endOfYear'], $carbon['interval']) as $month) {
            // get every month data
            $sale_monthly_data[$month->format('M')] = sale::whereMonth('date', $month)
                ->get()->sum('grand_total');
        }
        return $sale_monthly_data;
    }

    /**
     * get daily sale data
     * @return array
     */
    public function getDailySaleData(): array
    {
        $carbon = $this->getCarbonDailyData();
        $daily_sale_chart_data = [];

        foreach (Carbon::parse($carbon['start'])->range($carbon['end'], $carbon['interval']) as $date) {
            // get every month data
            $daily_sale_chart_data[$date->format('j')] = sale::whereDate('date', $date)
                ->get()->sum('grand_total');
        }
        return $daily_sale_chart_data;
    }

    /**
     * get daily purchase data
     * @return array
     */
    public function getDailyPurchaseData(): array
    {
        $carbon = $this->getCarbonDailyData();
        $daily_purchase_chart_data = [];

        foreach (Carbon::parse($carbon['start'])->range($carbon['end'], $carbon['interval']) as $date) {
            $daily_purchase_chart_data[$date->format('j')] = Purchase::whereDate('date', $date)
                ->get()->sum('grand_total');
        }
        return $daily_purchase_chart_data;
    }


    /**
     * get carbon data
     * get start of month of a year
     * get end of month of a year
     * get interval between start of year & end of year
     * @return array
     */
    public function getCarbonMonthlyData(): array
    {
        $data = [];
        $now = Carbon::now()->toImmutable();
        $data['startOfYear'] = $now->startOfYear();
        $data['endOfYear'] = $now->endOfYear();
        $data['interval'] = CarbonInterval::months(1);

        return $data;
    }


    /**
     * get carbon daily data
     * @return array
     */
    public function getCarbonDailyData(): array
    {
        $data = [];
        $data['start'] = Carbon::now()->startOfMonth();
        $data['end'] = Carbon::now()->endOfMonth();
        $data['interval'] = CarbonInterval::day(1);

        return $data;
    }
}
