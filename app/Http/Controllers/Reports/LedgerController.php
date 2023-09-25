<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerDueManage;
use App\Models\MonthlyRecharge;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\SupplierDueManage;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class LedgerController extends Controller
{
    // private $paginate = 25;
    public $data = [];
    /**
     * customer ledger details
     *
     */
    public function customerLedger()
    {
        $this->data['customers'] = Customer::all();
        $customer = '';
        $total_debit = 0;
        $total_credit = 0;
        $customer_balance = 0;

        if (request()->search) {
            $customer = Customer::where('id', request()->customer_id)->first();
            $customer_balance = $customer->balance ?? 0;

             $sale_query = Sale::query()
                ->with('productSales')
                ->where('customer_id', request()->customer_id)
                ->selectRaw("*, 'sale' as 'type'");

            $customer_due_management_query = CustomerDueManage::query()
                ->where('customer_id', request()->customer_id)
                ->selectRaw("*, 'due_manage' as 'type'");

            $monthly_recharge_query = MonthlyRecharge::query()
                ->where('customer_id', request()->customer_id)
                ->selectRaw("*, 'monthly_recharge' as 'type'");

            if (\request('form_date')) {
                $sale_query->whereDate('date', '>=', \request('form_date'));
                $customer_due_management_query->whereDate('date', '>=', \request('form_date'));
                $monthly_recharge_query->whereDate('date', '>=', \request('form_date'));
            }

            if (\request('to_date')) {
                $sale_query->whereDate('date', '<=', \request('to_date'));
                $customer_due_management_query->whereDate('date', '<=', \request('to_date'));
                $monthly_recharge_query->whereDate('date', '>=', \request('form_date'));
            }

            $this->data['customer_ledgers'] =
            Search::add($sale_query)
                ->orderBy('date')
                ->add($customer_due_management_query)
                ->orderBy('date')
                ->add($monthly_recharge_query)
                ->orderBy('date')
                ->search();


            foreach ($this->data['customer_ledgers'] as $ledger) {
                $total_debit += $ledger->grand_total;
                $total_credit += $ledger->total_paid;
                if ($ledger->type == 'due_manage') {
                    if ($ledger->amount <= 0) {
                        $total_debit += $ledger->amount;
                    } else {
                        $total_credit += $ledger->amount;
                    }
                }

                if ($ledger->type == 'monthly_recharge') {
                    $total_debit += $ledger->amount;
                    $total_credit += $ledger->amount;
                }
            }

        }
        return view('admin.reports.ledger.customer-ledger', compact('customer', 'total_debit', 'customer_balance', 'total_credit'))->with($this->data);
    }


    /**
     * supplier ledger details
     *
     */
    public function supplierLedger()
    {
        $this->data['suppliers'] = Supplier::all();
        $supplier = '';
        $total_debit = 0;
        $total_credit = 0;
        $supplier_balance = 0;

        if (request()->search) {
            $supplier = Supplier::where('id', request()->supplier_id)->first();
            $supplier_balance = $supplier->balance ?? 0;

             $purchase_query = Purchase::query()
                ->with('productPurchases')
                ->where('supplier_id', request()->supplier_id)
                ->selectRaw("*, 'purchase' as 'type'");

            $supplier_due_management_query = SupplierDueManage::query()
                ->where('supplier_id', request()->supplier_id)
                ->selectRaw("*, 'due_manage' as 'type'");

            if (\request('form_date')) {
                $purchase_query->whereDate('date', '>=', \request('form_date'));
                $supplier_due_management_query->whereDate('date', '>=', \request('form_date'));
            }

            if (\request('to_date')) {
                $purchase_query->whereDate('date', '<=', \request('to_date'));
                $supplier_due_management_query->whereDate('date', '<=', \request('to_date'));
            }

             $this->data['supplier_ledgers'] =
            Search::add($purchase_query)
                ->orderBy('date')
                ->add($supplier_due_management_query)
                ->orderBy('date')
                ->search();

            foreach ($this->data['supplier_ledgers'] as $ledger) {
                $total_debit += $ledger->grand_total;
                $total_credit += $ledger->total_paid;
                if ($ledger->type == 'due_manage') {
                    if ($ledger->amount <= 0) {
                        $total_debit += $ledger->amount;
                    } else {
                        $total_credit += $ledger->amount;
                    }
                }
            }
        }
        return view('admin.reports.ledger.supplier-ledger', compact('supplier', 'total_debit', 'supplier_balance', 'total_credit'))->with($this->data);

    }
}
