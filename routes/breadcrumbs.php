<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.

use App\Models\Advance;
use App\Models\Area;
use App\Models\Cash;
use App\Models\Customer;
use App\Models\CustomerDueManage;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubcategory;
use App\Models\Loan;
use App\Models\Package;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SmsTemplate;
use App\Models\Supplier;
use App\Models\SupplierDueManage;
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard.index'));
});

//Customer start
// All records
Breadcrumbs::for('all customers', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All customers', route('customer.index'));
});

// Create
Breadcrumbs::for('customer create', function (BreadcrumbTrail $trail) {
    $trail->parent('all customers');
    $trail->push('Create', route('customer.create'));
});

// Show
Breadcrumbs::for('customer details', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('all customers');
    $trail->push('Details', route('customer.show',$customer));
});

// Edit
Breadcrumbs::for('customer edit', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('all customers');
    $trail->push('Edit', route('customer.edit',$customer));
});

// Trash
Breadcrumbs::for('customer trash', function (BreadcrumbTrail $trail) {
    $trail->parent('all customers');
    $trail->push('Trashes', route('customer.trash'));
});
//Customer end

//Supplier start
// All records
Breadcrumbs::for('all suppliers', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All suppliers', route('supplier.index'));
});

// Create
Breadcrumbs::for('supplier create', function (BreadcrumbTrail $trail) {
    $trail->parent('all suppliers');
    $trail->push('Create', route('supplier.create'));
});

// Show
Breadcrumbs::for('supplier details', function (BreadcrumbTrail $trail, Supplier $supplier) {
    $trail->parent('all suppliers');
    $trail->push('Details', route('supplier.show', $supplier));
});

// Edit
Breadcrumbs::for('supplier edit', function (BreadcrumbTrail $trail, Supplier $supplier) {
    $trail->parent('all suppliers');
    $trail->push('Edit', route('supplier.edit', $supplier));
});

// Trash
Breadcrumbs::for('suppliers trash', function (BreadcrumbTrail $trail) {
    $trail->parent('all suppliers');
    $trail->push('Trashes', route('supplier.trash'));
});
//Customer end

//Purchase start
// All records
Breadcrumbs::for('all purchases', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All purchases', route('purchase.index'));
});

// Create
Breadcrumbs::for('purchase create', function (BreadcrumbTrail $trail) {
    $trail->parent('all purchases');
    $trail->push('Create', route('purchase.create'));
});

// Show
Breadcrumbs::for('purchase details', function (BreadcrumbTrail $trail, Purchase $purchase) {
    $trail->parent('all purchases');
    $trail->push('Details', route('purchase.show', $purchase));
});

// Edit
Breadcrumbs::for('purchase edit', function (BreadcrumbTrail $trail, Purchase $purchase) {
    $trail->parent('all purchases');
    $trail->push('Edit', route('purchase.edit', $purchase));
});
//Purchase end

//Sale start
// All records
Breadcrumbs::for('all sales', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All sales', route('sale.index'));
});

// Create
Breadcrumbs::for('sale create', function (BreadcrumbTrail $trail) {
    $trail->parent('all sales');
    $trail->push('Create', route('sale.create'));
});

// Show
Breadcrumbs::for('sale details', function (BreadcrumbTrail $trail, Sale $sale) {
    $trail->parent('all sales');
    $trail->push('Details', route('sale.show', $sale));
});

// Edit
Breadcrumbs::for('sale edit', function (BreadcrumbTrail $trail, Sale $sale) {
    $trail->parent('all sales');
    $trail->push('Edit', route('sale.edit', $sale));
});

// Trash
Breadcrumbs::for('sale trash', function (BreadcrumbTrail $trail) {
    $trail->parent('all sales');
    $trail->push('Trashes', route('sale.trash'));
});
//Sale end


//Expense start
// All records
Breadcrumbs::for('all expenses', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All expenses', route('expense.index'));
});

// Create
Breadcrumbs::for('expense create', function (BreadcrumbTrail $trail) {
    $trail->parent('all expenses');
    $trail->push('Create', route('expense.create'));
});

// Show
Breadcrumbs::for('expense details', function (BreadcrumbTrail $trail, Expense $expense) {
    $trail->parent('all expenses');
    $trail->push('Details', route('expense.show', $expense));
});

// Edit
Breadcrumbs::for('expense edit', function (BreadcrumbTrail $trail, Expense $expense) {
    $trail->parent('all expenses');
    $trail->push('Edit', route('expense.edit', $expense));
});

// Trash
Breadcrumbs::for('expense trash', function (BreadcrumbTrail $trail) {
    $trail->parent('all expenses');
    $trail->push('Trashes', route('expense.trash'));
});
//Expense end

//Expense category start
// All records
Breadcrumbs::for('all categories', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All categories', route('expense-category.index'));
});

// Create
Breadcrumbs::for('category create', function (BreadcrumbTrail $trail) {
    $trail->parent('all categories');
    $trail->push('Create', route('expense-category.create'));
});

// Edit
Breadcrumbs::for('category edit', function (BreadcrumbTrail $trail, ExpenseCategory $category) {
    $trail->parent('all categories');
    $trail->push('Edit', route('expense-category.edit', $category));
});

// Trash
Breadcrumbs::for('category trash', function (BreadcrumbTrail $trail) {
    $trail->parent('all categories');
    $trail->push('Trashes', route('expense-category.trash'));
});
//Expense category end

//Expense Subcategory start
// All records
Breadcrumbs::for('all subcategories', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All subcategories', route('expense-subcategory.index'));
});

// Create
Breadcrumbs::for('subcategory create', function (BreadcrumbTrail $trail) {
    $trail->parent('all subcategories');
    $trail->push('Create', route('expense-subcategory.create'));
});


// Edit
Breadcrumbs::for('subcategory edit', function (BreadcrumbTrail $trail, ExpenseSubcategory $subcategory) {
    $trail->parent('all subcategories');
    $trail->push('Edit', route('expense-subcategory.edit', $subcategory));
});

// Trash
Breadcrumbs::for('subcategory trash', function (BreadcrumbTrail $trail) {
    $trail->parent('all subcategories');
    $trail->push('Trashes', route('expense-subcategory.trash'));
});
//Expense category end


//Product start
// All records
Breadcrumbs::for('all products', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All products', route('product.index'));
});

// Create
Breadcrumbs::for('product create', function (BreadcrumbTrail $trail) {
    $trail->parent('all products');
    $trail->push('Create', route('product.create'));
});

// Show
Breadcrumbs::for('product details', function (BreadcrumbTrail $trail, Product $product) {
    $trail->parent('all products');
    $trail->push('Details', route('product.show', $product));
});

// Edit
Breadcrumbs::for('product edit', function (BreadcrumbTrail $trail, Product $product) {
    $trail->parent('all products');
    $trail->push('Edit', route('product.edit', $product));
});

// Trash
Breadcrumbs::for('product trash', function (BreadcrumbTrail $trail) {
    $trail->parent('all products');
    $trail->push('Trashes', route('product.trash'));
});
//Product end

//Area start
// All records
Breadcrumbs::for('all areas', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All areas', route('area.index'));
});

// Create
Breadcrumbs::for('area create', function (BreadcrumbTrail $trail) {
    $trail->parent('all areas');
    $trail->push('Create', route('area.create'));
});

// Edit
Breadcrumbs::for('area edit', function (BreadcrumbTrail $trail, Area $area) {
    $trail->parent('all areas');
    $trail->push('Edit', route('area.edit', $area));
});

// Trash
Breadcrumbs::for('area trash', function (BreadcrumbTrail $trail) {
    $trail->parent('all areas');
    $trail->push('Trashes', route('area.trash'));
});
//Area end


//Package start
// All records
Breadcrumbs::for('all packages', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All packages', route('package.index'));
});

// Create
Breadcrumbs::for('package create', function (BreadcrumbTrail $trail) {
    $trail->parent('all packages');
    $trail->push('Create', route('package.create'));
});

// Edit
Breadcrumbs::for('package edit', function (BreadcrumbTrail $trail, Package $package) {
    $trail->parent('all packages');
    $trail->push('Edit', route('package.edit', $package));
});

// Trash
Breadcrumbs::for('package trash', function (BreadcrumbTrail $trail) {
    $trail->parent('all packages');
    $trail->push('Trashes', route('package.trash'));
});
//Package end

//Employee start
// All records
Breadcrumbs::for('all employees', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All employees', route('employee.index'));
});

// Create
Breadcrumbs::for('employee create', function (BreadcrumbTrail $trail) {
    $trail->parent('all employees');
    $trail->push('Create', route('employee.create'));
});

// Show
Breadcrumbs::for('employee details', function (BreadcrumbTrail $trail, Employee $employee) {
    $trail->parent('all employees');
    $trail->push('Details', route('employee.show', $employee));
});

// Edit
Breadcrumbs::for('employee edit', function (BreadcrumbTrail $trail, Employee $employee) {
    $trail->parent('all employees');
    $trail->push('Edit', route('employee.edit', $employee));
});

// Trash
Breadcrumbs::for('employee trash', function (BreadcrumbTrail $trail) {
    $trail->parent('all employees');
    $trail->push('Trashes', route('employee.trash'));
});
//Employee end



//Cash start
// All records
Breadcrumbs::for('all cashes', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All cashes', route('cash.index'));
});

// Create
Breadcrumbs::for('cash create', function (BreadcrumbTrail $trail) {
    $trail->parent('all cashes');
    $trail->push('Create', route('cash.create'));
});

// Edit
Breadcrumbs::for('cash edit', function (BreadcrumbTrail $trail, Cash $cash) {
    $trail->parent('all cashes');
    $trail->push('Edit', route('cash.edit', $cash));
});

// Trash
Breadcrumbs::for('cash trash', function (BreadcrumbTrail $trail) {
    $trail->parent('all cashes');
    $trail->push('Trashes', route('cash.trash'));
});
//Cash end

//Monthly recharge start
// All records
Breadcrumbs::for('all inactive customers', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All Inactive Customers', route('monthly-recharge.index'));
});
// Show
Breadcrumbs::for('customer recharge details', function (BreadcrumbTrail $trail, Sale $package_customer) {
    $trail->parent('all inactive customers');
    $trail->push('Details', route('monthly-recharge.details', $package_customer));
});

//Monthly recharge end


//Payroll start
//Advanced
// All records
Breadcrumbs::for('all advanced', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All Advanced', route('payroll-advanced.index'));
});

// Create
Breadcrumbs::for('advanced create', function (BreadcrumbTrail $trail) {
    $trail->parent('all advanced');
    $trail->push('Create', route('payroll-advanced.create'));
});

// Show
Breadcrumbs::for('advanced details', function (BreadcrumbTrail $trail, Advance $advanced_for_breadcrump) {
    $trail->parent('all advanced');
    $trail->push('Advanced Details', route('payroll-advanced.show', $advanced_for_breadcrump));
});

// Edit
// Breadcrumbs::for('advanced edit', function (BreadcrumbTrail $trail) {
//     $trail->parent('all advanced');
//     $trail->push('Advanced Edit', route('payroll-advanced.edit'));
// });


//Loan
// All records
Breadcrumbs::for('all loan', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All Loans', route('payroll-loan.index'));
});

// Create
Breadcrumbs::for('loan create', function (BreadcrumbTrail $trail) {
    $trail->parent('all loan');
    $trail->push('Create', route('payroll-loan.create'));
});

// Show
Breadcrumbs::for('loan details', function (BreadcrumbTrail $trail, Loan $loan) {
    $trail->parent('all loan');
    $trail->push('Loan Details', route('payroll-loan.show', $loan));
});

//Edit
Breadcrumbs::for('loan edit', function (BreadcrumbTrail $trail, Loan $loan) {
    $trail->parent('all loan');
    $trail->push('Loan Edit', route('payroll-loan.edit',$loan));
});

//Salary
// All records
Breadcrumbs::for('all salary', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All Salary', route('payroll-salary.index'));
});

// Create
Breadcrumbs::for('salary create', function (BreadcrumbTrail $trail) {
    $trail->parent('all salary');
    $trail->push('Create', route('payroll-salary.create'));
});

//Payroll end


//Stock
// All records
Breadcrumbs::for('stock', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Stock', route('stock.index'));
});


//Supplier due manage
// All records
Breadcrumbs::for('all suppliers due payment', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All payments', route('supplier-due-manage.index'));
});

// Create
Breadcrumbs::for('supplier due payment create', function (BreadcrumbTrail $trail) {
    $trail->parent('all suppliers due payment');
    $trail->push('Create', route('supplier-due-manage.create'));
});

// Show
Breadcrumbs::for('supplier payment details', function (BreadcrumbTrail $trail, SupplierDueManage $supplierDue) {
    $trail->parent('all suppliers due payment');
    $trail->push('Details', route('supplier-due-manage.show', $supplierDue));
});

// Edit
Breadcrumbs::for('supplier payment edit', function (BreadcrumbTrail $trail, SupplierDueManage $supplierDue) {
    $trail->parent('all suppliers due payment');
    $trail->push('Edit', route('supplier-due-manage.edit', $supplierDue));
});

//Supplier due manage end


//Customer due manage
// All records
Breadcrumbs::for('all customers due payment', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All payments', route('customer-due-manage.index'));
});

// Create
Breadcrumbs::for('customer due payment create', function (BreadcrumbTrail $trail) {
    $trail->parent('all customers due payment');
    $trail->push('Create', route('customer-due-manage.create'));
});

// Show
Breadcrumbs::for('customer payment details', function (BreadcrumbTrail $trail, CustomerDueManage $customerDue) {
    $trail->parent('all customers due payment');
    $trail->push('Details', route('customer-due-manage.show', $customerDue));
});

// Edit
Breadcrumbs::for('customer payment edit', function (BreadcrumbTrail $trail, CustomerDueManage $customerDue) {
    $trail->parent('all customers due payment');
    $trail->push('Edit', route('customer-due-manage.edit', $customerDue));
});

//Customer due manage end

//SMS start
// Group sms
Breadcrumbs::for('group sms', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Group sms', route('sms.group-sms'));
});

// Custom sms
Breadcrumbs::for('custom sms', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Custom sms', route('sms.custom-sms'));
});

// Template sms
Breadcrumbs::for('template sms', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Template sms', route('sms.template-sms'));
});

//Sms template start
// All records
Breadcrumbs::for('all templates', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All templates', route('sms-template.index'));
});

// Create
Breadcrumbs::for('template create', function (BreadcrumbTrail $trail) {
    $trail->parent('all templates');
    $trail->push('Create', route('sms-template.create'));
});

// Edit
Breadcrumbs::for('template edit', function (BreadcrumbTrail $trail, SmsTemplate $template) {
    $trail->parent('all templates');
    $trail->push('Edit', route('sms-template.edit', $template));
});

// Trash
Breadcrumbs::for('template trash', function (BreadcrumbTrail $trail) {
    $trail->parent('all templates');
    $trail->push('Trashes', route('sms-template.trash'));
});
//Sms template end

