<?php

namespace App\Http\Controllers\Main;

use App\Helpers\SMS;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Cash;
use App\Models\Customer;
use App\Models\MonthlyRecharge;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class MonthlyRechargeController extends Controller
{
    private $paginate = 25;
    public $sender_id, $api_key;

    public function __construct()
    {
        $this->sender_id = env('SMS_SENDER_ID');
        $this->api_key = env('SMS_API_KEY');
    }
    /**
     * Reachargeable all customers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the selected perPage option (default to 25 if not set or invalid)
        $perPage = in_array(request('perPage'), [25, 50, 100, 250, 'all']) ? request('perPage') : 25;

        $package_customers_query = Sale::query();

        //Search by customer name
        if (request('customer_id')) {
            $package_customers_query->whereHas('customer', function ($query) {
                $query->where('id', 'like', '%' . request('customer_id') . '%');
            });
        }

        //Search by area name
        if (request('area_id')) {
            $package_customers_query->whereHas('customer', function ($query) {
                $query->where('area_id', 'like', '%' . request('area_id') . '%');
            });
        }

        //Search by mobile no
        if (request('mobile_no')) {
            $package_customers_query->whereHas('customer', function ($query) {
                $query->where('mobile_no',  request('mobile_no'));
            });
        }
        // search by cable id
        if (request('cable_id')) {
            $package_customers_query->where('cable_id', 'like', '%' . request('cable_id') . '%');
        }

        // search by status
        if (request('status')) {
            $package_customers_query->where('status',  request('status'));
        }

        if (request()->search) {
            $package_customers_query->where('package_id', '!=', null);
        } else {
            $package_customers_query->where('package_id', '!=', null)->where('expire_date', '<', date('Y-m-d'));
        }

        // apply the perPage option to the package customers query
        if ($perPage == 'all') {
            $package_customers = $package_customers_query->paginate($package_customers_query->count());
        } else {
            $package_customers = $package_customers_query->paginate($perPage);
        }

        $areas = Area::all();
        $customers = Customer::all();
        $cashes = Cash::all();

        return view('admin.monthly-recharge.index', compact('package_customers', 'areas', 'cashes', 'customers'));
    }


    /**
     * deactived to active function.
     *
     * @return \Illuminate\Http\Response
     */
    public function toActive(Request $request, $id)
    {
        try {
            // return $request->all();
            // get the specified resource
            $toActiveCustomer = Sale::findOrFail($id);
            $packagePrice = $toActiveCustomer->package->price;
            // validation
            $request->validate([
                // 'date'                => 'required|date',
                'active_date'         => 'required|date',
                'expire_date'         => 'required|date',
                'cash_id'             => 'required',
            ]);

            DB::transaction(function () use ($request, $toActiveCustomer, $packagePrice) {

                //calculate month and package price
                $date1 = Carbon::parse($request->active_date);
                $date2 = Carbon::parse($request->expire_date);
                $countableMonth = $date2->diffInMonths($date1);
                $totalPackagePrice = $countableMonth > 0 ?  $countableMonth * $packagePrice : 1 * $packagePrice;

                // Conditionally assign the value for the status field
                $status = $request->active_date <= $request->expire_date ? 'active' : 'inactive';

                if (date('Y-m-d') > $request->expire_date) {
                    $status = 'inactive';
                }

                if($date1 >= $date2) {
                    throw new \Exception('An error occurred while given date, Expire date should be bigger then active date.');
                }
                else{
                    $toActiveCustomer->update([
                        'active_date' => $request->active_date,
                        'expire_date' => $request->expire_date,
                        'status'      => $status,
                    ]);

                    $customer_id = $toActiveCustomer->customer_id;

                    MonthlyRecharge::create([
                        'sale_id'   => $toActiveCustomer->id,
                        'customer_id' => $customer_id,
                        'date' => $request->active_date,
                        'expire_date' => $request->expire_date,
                        'amount' => $totalPackagePrice,
                    ]);

                    Cash::findOrFail($request->cash_id)->increment('balance', $totalPackagePrice);
                    $message =
                    "Bill-" . " \n" .
                    " Paid:" . $totalPackagePrice . " \n" .
                    " Due:" . "0.00" . " \n" . " \n" .
                    " ID:" . $toActiveCustomer->cable_id . " \n" .
                    " Exp Date:" . Carbon::createFromFormat('Y-m-d', $request->expire_date)->format("F j, Y") .
                    " \n" . config('sms.regards');

                    SMS::customSmsSend($this->sender_id, $this->api_key, $toActiveCustomer->customer->mobile_no, $message);
                }

            });
            return redirect()->route('monthly-recharge.index')->with('success', 'Monthly recharge have been updated successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Customer rechagre details
     *
     */
    public function details($id)
    {

        $package_customer = Sale::findOrFail($id);
        return view('admin.monthly-recharge.details',compact('package_customer'));
    }

    /**
     * Customer rechagre edit
     *
     */
    public function edit($id)
    {
        $cashes = Cash::all();
        $package_customer = Sale::findOrFail($id);
        return view('admin.monthly-recharge.edit', compact('package_customer', 'cashes'));
    }



    /**
     * Customer rechagre update
     *
     */
    public function update(Request $request ,$id)
    {
        try {
            // return $request->all();
            // get the specified resource
            $toActiveCustomer = Sale::findOrFail($id);
            $packagePrice = $toActiveCustomer->package->price;
            // validation
            $request->validate([
                // 'date'                => 'required|date',
                'active_date'         => 'required|date',
                'expire_date'         => 'required|date',
                'cash_id'             => 'required',
            ]);

            //Last recharge

            $getMonthlyRechargeByCustomerId = MonthlyRecharge::where('customer_id', $toActiveCustomer->customer_id)->get();
            $monthly_recharge = $toActiveCustomer->monthlyRecharges->last();
            //update previous cash
            Cash::findOrFail($request->cash_id)->decrement('balance', $monthly_recharge->amount);

            DB::transaction(function () use ($request, $toActiveCustomer, $packagePrice ,$monthly_recharge, $getMonthlyRechargeByCustomerId) {

                //calculate month and package price
                $date1 = Carbon::parse($request->active_date);
                $date2 = Carbon::parse($request->expire_date);
                $countableMonth = $date2->diffInMonths($date1);
                $totalPackagePrice = $countableMonth > 0 ?  $countableMonth * $packagePrice : 1 * $packagePrice;

                // Conditionally assign the value for the status field
                $status = $request->active_date <= $request->expire_date ? 'active' : 'inactive';

                if (date('Y-m-d') > $request->expire_date) {
                    $status = 'inactive';
                }

                if ($date1 >= $date2) {
                    throw new \Exception('An error occurred while given date, Expire date should be bigger then active date.');
                } else {
                    $toActiveCustomer->update([
                        'active_date' => $request->active_date,
                        'expire_date' => $request->expire_date,
                        'status'      => $status,
                    ]);

                    //update last recharge
                    if ($monthly_recharge) {
                        $monthly_recharge->update([
                            'date' => $request->active_date,
                            'expire_date' => $request->expire_date,
                            'amount' => $totalPackagePrice,
                        ]);
                    }
                    // else{
                    //     $getMonthlyRechargeByCustomerId->update([
                    //         'sale_id'   => $toActiveCustomer->id,
                    //         'date' => $request->active_date,
                    //         'expire_date' => $request->expire_date,
                    //         'amount' => $totalPackagePrice,
                    //     ]);
                    // }

                    Cash::findOrFail($request->cash_id)->increment('balance', $totalPackagePrice);

                    $message =
                        "Bill-" . " \n" .
                        " Paid:" . $totalPackagePrice . " \n" .
                        " Due:" . "0.00" . " \n" . " \n" .
                        " ID:" . $toActiveCustomer->cable_id . " \n" .
                        " Exp Date:" . Carbon::createFromFormat('Y-m-d', $request->expire_date)->format("F j, Y") .
                        " \n" . config('sms.regards');

                    SMS::customSmsSend($this->sender_id, $this->api_key, $toActiveCustomer->customer->mobile_no, $message);
                }
            });
            return redirect()->route('monthly-recharge.index')->with('success', 'Monthly recharge have been updated successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
