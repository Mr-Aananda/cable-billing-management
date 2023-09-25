<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Main\CustomerController;
use App\Http\Controllers\Main\CustomerDueManageController;
use App\Http\Controllers\Main\Expense\CategoryController;
use App\Http\Controllers\Main\Expense\ExpenseController;
use App\Http\Controllers\Main\Expense\SubCategoryController;
use App\Http\Controllers\Main\MonthlyRechargeController;
use App\Http\Controllers\Main\Payroll\AdvancedController;
use App\Http\Controllers\Main\Payroll\LoanController;
use App\Http\Controllers\Main\Payroll\LoanInstallmentController;
use App\Http\Controllers\Main\Payroll\SalaryController;
use App\Http\Controllers\Main\PurchaseController;
use App\Http\Controllers\Main\SaleController;
use App\Http\Controllers\Main\StockController;
use App\Http\Controllers\Main\SupplierController;
use App\Http\Controllers\Main\SupplierDueManageController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\Reports\CashBookController;
use App\Http\Controllers\Reports\LedgerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Setting\AreaController;
use App\Http\Controllers\Setting\CashController;
use App\Http\Controllers\Setting\EmployeeController;
use App\Http\Controllers\Setting\PackageController;
use App\Http\Controllers\Setting\ProductController;
use App\Http\Controllers\Setting\SmsTemplateController;
use App\Http\Controllers\Sms\SmsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WelcomeController::class, 'root']);

Route::prefix('dashboard')
    ->middleware('auth', 'permission.add')
    ->group(function () {
        // dashboard
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard.index')
            ->middleware('permission.remove'); // remove permission to access dashboard

        // Change password
        Route::prefix('change-password')
            ->middleware('permission.remove')
            ->controller(PasswordChangeController::class)
            ->group(function () {
                // show change password form
                Route::get('/', 'showChangePasswordForm')->name('password.change');

                // update password
                Route::post('/', 'updatePassword');
            });

        // users
        Route::prefix('user')
            ->name('user.')
            ->group(function () {
                // custom user routes
            });
        // user resource controller
        Route::resource('user', UserController::class);

        // roles
        Route::prefix('role')
            ->name('role.')
            ->group(function () {
                // custom role routes
            });
        // role resource controller
        Route::resource('role', RoleController::class);

        Route::prefix('cabletv')->group(function(){
         //All Settings Route Start
        //Area route start
        Route::resource('area', AreaController::class); //Resource controller
        Route::get('/area-trash', [AreaController::class, 'trash'])->name('area.trash');
        Route::post('/area-trash', [AreaController::class, 'restoreOrDelete'])->name('area.trash');
        Route::get('/area-restore/{id}', [AreaController::class, 'restore'])->name('area.restore');
        Route::get('/area-permanentDelete/{id}', [AreaController::class, 'permanentDelete'])->name('area.permanentDelete');
        //Area route end

        //Package route start
        Route::resource('package', PackageController::class); //Resource controller
        Route::get('/package-trash', [PackageController::class, 'trash'])->name('package.trash');
        Route::post('/package-trash', [PackageController::class, 'restoreOrDelete'])->name('package.trash');
        Route::get('/package-restore/{id}', [PackageController::class, 'restore'])->name('package.restore');
        Route::get('/package-permanentDelete/{id}', [PackageController::class, 'permanentDelete'])->name('package.permanentDelete');
        //Package route end

        //Product route start
        Route::resource('product', ProductController::class); //Resource controller
        Route::get('/product-trash', [ProductController::class, 'trash'])->name('product.trash');
        Route::post('/product-trash', [ProductController::class, 'restoreOrDelete'])->name('product.trash');
        Route::get('/product-restore/{id}', [ProductController::class, 'restore'])->name('product.restore');
        Route::get('/product-permanentDelete/{id}', [ProductController::class, 'permanentDelete'])->name('product.permanentDelete');
        //Product route end

        //Employee route
        Route::resource('employee', EmployeeController::class); //Resource controller
        Route::get('/employee-trash', [EmployeeController::class, 'trash'])->name('employee.trash');
        Route::post('/employee-trash', [EmployeeController::class, 'restoreOrDelete'])->name('employee.trash');
        Route::get('/employee-restore/{id}', [EmployeeController::class, 'restore'])->name('employee.restore');
        Route::get('/employee-permanentDelete/{id}', [EmployeeController::class, 'permanentDelete'])->name('employee.permanentDelete');
       //Employee route

        //Area route start
        Route::resource('cash', CashController::class); //Resource controller
        Route::get('/cash-trash', [CashController::class, 'trash'])->name('cash.trash');
        Route::post('/cash-trash', [CashController::class, 'restoreOrDelete'])->name('cash.trash');
        Route::get('/cash-restore/{id}', [CashController::class, 'restore'])->name('cash.restore');
        Route::get('/cash-permanentDelete/{id}', [CashController::class, 'permanentDelete'])->name('cash.permanentDelete');
        //Area route end
        //All Settings Route End

        //All Main Route Start

        //Customer route start
        Route::resource('customer', CustomerController::class); //Resource controller
        Route::get('/customer-trash', [CustomerController::class, 'trash'])->name('customer.trash');
        Route::post('/customer-trash', [CustomerController::class, 'restoreOrDelete'])->name('customer.trash');
        Route::get('/customer-restore/{id}', [CustomerController::class, 'restore'])->name('customer.restore');
        Route::get('/customer-permanentDelete/{id}', [CustomerController::class, 'permanentDelete'])->name('customer.permanentDelete');
        //Customer route end

        //Supplier route start
        Route::resource('supplier', SupplierController::class); //Resource controller
        Route::get('/supplier-trash', [SupplierController::class, 'trash'])->name('supplier.trash');
        Route::post('/supplier-trash', [SupplierController::class, 'restoreOrDelete'])->name('supplier.trash');
        Route::get('/supplier-restore/{id}', [SupplierController::class, 'restore'])->name('supplier.restore');
        Route::get('/supplier-permanentDelete/{id}', [SupplierController::class, 'permanentDelete'])->name('supplier.permanentDelete');
        //Supplier route end

        //Purchase route start
        Route::resource('purchase', PurchaseController::class); //Resource controller
        Route::get('/purchase-trash', [PurchaseController::class, 'trash'])->name('purchase.trash');
        Route::post('/purchase-trash', [PurchaseController::class, 'restoreOrDelete'])->name('purchase.trash');
        Route::get('/purchase-restore/{id}', [PurchaseController::class, 'restore'])->name('purchase.restore');
        Route::get('/purchase-permanentDelete/{id}', [PurchaseController::class, 'permanentDelete'])->name('purchase.permanentDelete');
        //Purchase route end

        //Sale route start
        Route::resource('sale', SaleController::class); //Resource controller
        Route::get('/sale-trash', [SaleController::class, 'trash'])->name('sale.trash');
        Route::post('/sale-trash', [SaleController::class, 'restoreOrDelete'])->name('sale.trash');
        Route::get('/sale-restore/{id}', [SaleController::class, 'restore'])->name('sale.restore');
        Route::get('/sale-permanentDelete/{id}', [SaleController::class, 'permanentDelete'])->name('sale.permanentDelete');
        //Sale route end

        //Expense category route start
        Route::resource('expense-category', CategoryController::class); //Resource controller
        Route::get('/category-trash', [CategoryController::class, 'trash'])->name('expense-category.trash');
        Route::post('/category-trash', [CategoryController::class, 'restoreOrDelete'])->name('expense-category.trash');
        Route::get('/category-restore/{id}', [CategoryController::class, 'restore'])->name('expense-category.restore');
        Route::get('/category-permanentDelete/{id}', [CategoryController::class, 'permanentDelete'])->name('expense-category.permanentDelete');
        //Expense category route end

        //SubCategory route start
        Route::resource('expense-subcategory', SubCategoryController::class); //Resource controller
        Route::get('/subcategory-trash', [SubCategoryController::class, 'trash'])->name('expense-subcategory.trash');
        Route::post('/subcategory-trash', [SubCategoryController::class, 'restoreOrDelete'])->name('expense-subcategory.trash');
        Route::get('/subcategory-restore/{id}', [SubCategoryController::class, 'restore'])->name('expense-subcategory.restore');
        Route::get('/subcategory-permanentDelete/{id}', [SubCategoryController::class, 'permanentDelete'])->name('expense-subcategory.permanentDelete');
        //SubCategory route end

        //Expense route start
        Route::resource('expense', ExpenseController::class); //Resource controller
        Route::get('/expense-trash', [ExpenseController::class, 'trash'])->name('expense.trash');
        Route::post('/expense-trash', [ExpenseController::class, 'restoreOrDelete'])->name('expense.trash');
        Route::get('/expense-restore/{id}', [ExpenseController::class, 'restore'])->name('expense.restore');
        Route::get('/expense-permanentDelete/{id}', [ExpenseController::class, 'permanentDelete'])->name('expense.permanentDelete');
        //Expense route end

        //Monthly recharge route start
        Route::get('/monthly-recharge',[MonthlyRechargeController::class, 'index'])->name('monthly-recharge.index');
        Route::post('/monthly-recharge/{id}',[MonthlyRechargeController::class, 'toActive'])->name('monthly-recharge.active');
        Route::get('/monthly-recharge-details/{id}',[MonthlyRechargeController::class, 'details'])->name('monthly-recharge.details');
        Route::get('/monthly-recharge-edit/{id}',[MonthlyRechargeController::class, 'edit'])->name('monthly-recharge.edit');
        Route::patch('/monthly-recharge/{id}', [MonthlyRechargeController::class, 'update'])->name('monthly-recharge.update');
        //Monthly recharge route end

        //Payroll route start
        //Advance Salary
        Route::resource('payroll-advanced', AdvancedController::class); //Resource controller
        Route::get('/payroll-advanced-trash', [AdvancedController::class, 'trash'])->name('advanced.trash');
        Route::post('/payroll-advanced-trash', [AdvancedController::class, 'restoreOrDelete'])->name('advanced.trash');
        Route::get('/payroll-advanced-restore/{id}', [AdvancedController::class, 'restore'])->name('advanced.restore');
        Route::get('/payroll-advanced-permanentDelete/{id}', [AdvancedController::class, 'permanentDelete'])->name('advanced.permanentDelete');

        //Loan Salary
        Route::resource('payroll-loan', LoanController::class); //Resource controller
        Route::get('loan-paid/{id}', [LoanController::class, 'loanPaid'])->name('loan.paid');
        Route::get('/payroll-loan-trash', [LoanController::class, 'trash'])->name('loan.trash');
        Route::post('/payroll-loan-trash', [LoanController::class, 'restoreOrDelete'])->name('loan.trash');
        Route::get('/payroll-loan-restore/{id}', [LoanController::class, 'restore'])->name('loan.restore');
        Route::get('/payroll-loan-permanentDelete/{id}', [LoanController::class, 'permanentDelete'])->name('loan.permanentDelete');

        //Salary
        Route::resource('payroll-salary', SalaryController::class); //Resource controller
        Route::get('/payroll-salary-trash', [SalaryController::class, 'trash'])->name('salary.trash');
        Route::post('/payroll-salary-trash', [SalaryController::class, 'restoreOrDelete'])->name('salary.trash');
        Route::get('/payroll-salary-restore/{id}', [SalaryController::class, 'restore'])->name('salary.restore');
        Route::get('/payroll-salary-permanentDelete/{id}', [SalaryController::class, 'permanentDelete'])->name('salary.permanentDelete');

        Route::get('salaryPay/{id}', [SalaryController::class, 'salaryPay'])->name('payroll-salary.salaryPay');

        //Loan installment routes
        Route::resource('loan-installment', LoanInstallmentController::class); //Resource controller
        Route::get('/installment-trash', [LoanInstallmentController::class, 'trash'])->name('installment.trash');
        Route::post('/installment-trash', [LoanInstallmentController::class, 'restoreOrDelete'])->name('installment.trash');
        Route::get('/installment-restore/{id}', [LoanInstallmentController::class, 'restore'])->name('installment.restore');
        Route::get('/installment-permanentDelete/{id}', [LoanInstallmentController::class, 'permanentDelete'])->name('installment.permanentDelete');
        //Payroll route end


        //Stock route start
        Route::resource('stock', StockController::class); //Resource controller
        //Stock route end

        //Supplier due manage route start
        Route::resource('supplier-due-manage', SupplierDueManageController::class); //Resource controller
        //Supplier due manage route end

        //Customer due manage route start
        Route::resource('customer-due-manage', CustomerDueManageController::class); //Resource controller
        //Customer due manage route end

        //All report routes
        //Cash book route
        // Route::get('/report-cashbook', [CashBookController::class, 'index'])->name('report.cashbook');
        // Route::get('/report-customer-ledger', [LedgerController::class, 'index'])->name('report.cashbook');

        Route::prefix('report')->group(function () {
            Route::get('cash-book', [CashBookController::class, 'index'])->name('report.cash-book');
            Route::get('cash-book-date-data', [CashBookController::class, 'cashBookDateData'])->name('report.cash-book-date-data');
            Route::post('closing-balance-store', [CashBookController::class, 'closingBalanceStore'])->name('report.closing-balance-store');

            Route::get('customer-ledger', [LedgerController::class, 'customerLedger'])->name('ledger.customer-ledger');

            Route::get('supplier-ledger', [LedgerController::class, 'supplierLedger'])->name('ledger.supplier-ledger');

        });

        //SMS routes
        Route::get('/group-sms', [SmsController::class, 'groupSms'])->name('sms.group-sms');
        Route::post('/group-sms', [SmsController::class, 'groupSmsSend']);

        Route::get('/custom-sms', [SmsController::class, 'customSms'])->name('sms.custom-sms');
        Route::post('/custom-sms', [SmsController::class, 'customSmsSend']);

        Route::get('/template-sms', [SmsController::class, 'templateSms'])->name('sms.template-sms');
        Route::post('/template-sms', [SmsController::class, 'templateSmsSend']);

        //Sms template controller
        Route::resource('sms-template', SmsTemplateController::class);

        //All Main Route End

        });

    // axios route
    Route::prefix('axios')->group(function () {
        // expense
        Route::post('/getSubcategoriesById', [SubCategoryController::class, 'getSubcategoriesById']);

    });
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    return "Storage link create successfully";
});

require __DIR__ . '/auth.php';
