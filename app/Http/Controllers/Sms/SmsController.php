<?php

namespace App\Http\Controllers\Sms;

use App\Helpers\SMS;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\SmsTemplate;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    private $paginate = 25;
    public $sender_id, $api_key;

    public function __construct()
    {
        $this->sender_id = env('SMS_SENDER_ID');
        $this->api_key = env('SMS_API_KEY');
    }

    public function groupSms(Request $request)
    {
        $customer_query = Customer::query();
        $supplier_query = Supplier::query();
        $employee_query = Employee::query();
        $type = $request->get('type', 'all'); // default to 'all' if no type is selected

        if ($type == 'customer') {
            $datas = $customer_query
                ->select('customers.name', 'customers.mobile_no', $customer_query->raw('"customer" as type'))
                ->paginate($this->getPerPage($request));
        } elseif ($type == 'supplier') {
            $datas = $supplier_query
                ->select('suppliers.name', 'suppliers.mobile_no', $supplier_query->raw('"supplier" as type'))
                ->paginate($this->getPerPage($request));
        } elseif ($type == 'employee') {
            $datas = $employee_query
                ->select('employees.name', 'employees.mobile', $employee_query->raw('"employee" as type'))
                ->paginate($this->getPerPage($request));
        } else {
            $datas = $customer_query
                ->select('customers.name', 'customers.mobile_no', $customer_query->raw('"customer" as type'))
                ->unionAll(
                    $supplier_query
                        ->select('suppliers.name', 'suppliers.mobile_no', $supplier_query->raw('"supplier" as type'))
                )
                ->unionAll(
                    $employee_query
                        ->select('employees.name', 'employees.mobile', $employee_query->raw('"employee" as type'))
                )
                ->paginate($this->getPerPage($request));
        }
        $route_name = 'sms.group-sms'; // for dynamic search
        $sms_balance = json_decode(SMS::smsCurrentBalance())->balance;
        $total_sms_count = intval($sms_balance / 0.25);
        return view('admin.sms.group-sms',compact('datas', 'route_name', 'type', 'sms_balance', 'total_sms_count'));
    }

    public function groupSmsSend(Request $request)
    {
        // return $request->all();
        $request->validate([
            'message' => 'required|string',
            'mobiles' => 'required|array',
            'mobiles.*' => 'string|size:11|starts_with:01'
        ]);

        $mobiles = join(',', $request->mobiles);
        $message = $request->message . " " . config('sms.regards');
        $response = SMS::groupSmsSend($this->sender_id, $this->api_key, $mobiles, $message); //send sms

        $responseDecode = json_decode($response);

        if ($responseDecode) {
            $smsStatus = $responseDecode->response_code;
            $smsStatusMessage = $this->getSmsStatusMessage($smsStatus);

            if ($smsStatus == 202) {
                $message = "SMS has been sent successfully.";
                return redirect()->route('sms.custom-sms')->withSuccess($message);
            } else {
                $errorMessage = "Failed to send SMS. " . $smsStatusMessage;
            }
        } else {
            $errorMessage = "Failed to send SMS. Please try again later.";
        }

        return back()->withErrors($errorMessage)->withInput();
    }


    public function customSms()
    {
        $sms_balance = json_decode(SMS::smsCurrentBalance())->balance;
        $total_sms_count = intval($sms_balance / 0.25);
        return view('admin.sms.custom-sms',compact('sms_balance', 'total_sms_count'));
    }

    public function customSmsSend(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'mobiles' => 'required|string',
            'mobiles.*' => 'string|size:11|starts_with:01'
        ]);

        $message = $request->message . " " . config('sms.regards');
        $response = SMS::customSmsSend($this->sender_id, $this->api_key, $request->mobiles, $message);
        $responseDecode = json_decode($response);

        if ($responseDecode) {
            $smsStatus = $responseDecode->response_code;
            $smsStatusMessage = $this->getSmsStatusMessage($smsStatus);

            if ($smsStatus == 202) {
                $message = "SMS has been sent successfully.";
                return redirect()->route('sms.custom-sms')->withSuccess($message);
            } else {
                $errorMessage = "Failed to send SMS. " . $smsStatusMessage;
            }
        } else {
            $errorMessage = "Failed to send SMS. Please try again later.";
        }

        return back()->withErrors($errorMessage)->withInput();
    }

    public function templateSms(Request $request)
    {
        $customer_query = Customer::query();
        $supplier_query = Supplier::query();
        $employee_query = Employee::query();
        $type = $request->get('type', 'all'); // default to 'all' if no type is selected

        if ($type == 'customer') {
            $datas = $customer_query
                ->select('customers.name', 'customers.mobile_no', $customer_query->raw('"customer" as type'))
                ->paginate($this->getPerPage($request));
        } elseif ($type == 'supplier') {
            $datas = $supplier_query
                ->select('suppliers.name', 'suppliers.mobile_no', $supplier_query->raw('"supplier" as type'))
                ->paginate($this->getPerPage($request));
        } elseif ($type == 'employee') {
            $datas = $employee_query
                ->select('employees.name', 'employees.mobile', $employee_query->raw('"employee" as type'))
                ->paginate($this->getPerPage($request));
        } else {
            $datas = $customer_query
                ->select('customers.name', 'customers.mobile_no', $customer_query->raw('"customer" as type'))
                ->unionAll(
                    $supplier_query
                        ->select('suppliers.name', 'suppliers.mobile_no', $supplier_query->raw('"supplier" as type'))
                )
                ->unionAll(
                    $employee_query
                        ->select('employees.name', 'employees.mobile', $employee_query->raw('"employee" as type'))
                )
                ->paginate($this->getPerPage($request));
        }
        $route_name = 'sms.template-sms'; // for dynamic search

        $templates = SmsTemplate::all();
        $sms_balance = json_decode(SMS::smsCurrentBalance())->balance;
        $total_sms_count = intval($sms_balance / 0.25);

        return view('admin.sms.template-sms',compact('datas', 'route_name', 'type', 'templates', 'sms_balance', 'total_sms_count'));
    }

    public function templateSmsSend(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'mobiles' => 'required|array',
            'mobiles.*' => 'string|size:11|starts_with:01'
        ]);

        // return $request->all();

        $mobiles = join(',', $request->mobiles);
        $message = $request->message . " " . config('sms.regards');
        $response = SMS::templateSmsSend($this->sender_id, $this->api_key, $mobiles, $message); //send sms
        // $data = json_decode($success, true); //for decode data

        $responseDecode = json_decode($response);

        if ($responseDecode) {
            $smsStatus = $responseDecode->response_code;
            $smsStatusMessage = $this->getSmsStatusMessage($smsStatus);

            if ($smsStatus == 202) {
                $message = "SMS has been sent successfully.";
                return redirect()->route('sms.custom-sms')->withSuccess($message);
            } else {
                $errorMessage = "Failed to send SMS. " . $smsStatusMessage;
            }
        } else {
            $errorMessage = "Failed to send SMS. Please try again later.";
        }

        return back()->withErrors($errorMessage)->withInput();
    }



//Get message from status code
    private function getSmsStatusMessage($smsStatus)
    {
        switch ($smsStatus) {
            case '202':
                return "SMS has been sent successfully.";
            case '1002':
                return "Sender id not correct/sender id is disabled.";
            case '1003':
                return "Please Required all fields/Contact Your System Administrator.";
            case '1005':
                return "Internal Error.";
            case '1006':
                return "Balance Validity Not Available.";
            case '1007':
                return "Balance Insufficient.";
            case '1011':
                return "User Id not found.";
            default:
                return "Failed to send SMS. Please try again later.";
        }
    }

    private function getPerPage(Request $request)
    {
        $perPage = request('perPage', 25);
        if ($perPage === 'all') {
            return PHP_INT_MAX;
        }
        return in_array($perPage, [25, 50, 100, 250]) ? $perPage : 25;
    }

}
