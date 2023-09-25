@php
    $currentRouteName = Route::currentRouteName();
    [$currentRoute, $routeName] = explode('.', $currentRouteName);
@endphp

  <!-- Start aside =================================== -->
  <aside id="page-aside">
        <!-- Start aside button bar =================================== -->
        <div class="left-icon-wrap">
            <!-- Start logo =================================== -->
            <a class="navbar-brand" href="{{route('dashboard.index')}}">
                <x-logos.icon-logo />
            </a>
            <!-- End logo =================================== -->

            <!-- Start tad buttons =================================== -->
            <div class="nav nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                <!-- Start page button =================================== -->
                <button class="nav-link {{$currentRoute ? 'active':''}}" title="Pages" id="v-pills-pages-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-pages" type="button" role="tab" aria-controls="v-pills-pages" aria-selected="false">
                <i class="bi bi-display"></i>
                </button>
                <!-- End page button =================================== -->

                <!-- Start component button =================================== -->
                {{-- <button class="nav-link" title="Components" id="v-pills-components-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-components" type="button" role="tab" aria-controls="v-pills-components"
                aria-selected="false">
                <i class="bi bi-code-square"></i>
                </button> --}}
                <!-- End component button =================================== -->
            </div>
            <!-- End tad buttons =================================== -->

            <!-- Start aside Expand & logout button =================================== -->
            <div class="footer-button">
                <button class="button" onclick="expandFunction()">
                    <i class="bi bi-chevron-right"></i>
                </button>
                <button class="button">
                    <i class="bi bi-box-arrow-left"></i>
                </button>
            </div>
            <!-- End aside Expand & logout button =================================== -->
        </div>
    <!-- End aside button bar =================================== -->

        <!-- Start aside menu bar =================================== -->
        <div class="right-menu-wrap">
            <div class="tab-content" id="v-pills-tabContent">
                <!-- Start pages menu list =================================== -->
                <div class="tab-pane fade" id="v-pills-pages" role="tabpanel" aria-labelledby="v-pills-pages-tab">

                    <div class="fixt-title">
                        <p style="letter-spacing: 3px"><span style="color: #1A75BC">F</span><span style="color: #29AAE2">IBER</span> <span style="color: #1A75BC">O</span><span style="color: #29AAE2">RBIT</span></p>
                        {{-- <p class="text-muted">MAXSOP</p> --}}
                    </div>

                    <!-- Start components dropdown menus =================================== -->
                    <ul class="accordion" id="page">
                        <li class="accordion-item">
                            <a href="{{route('dashboard.index')}}" class="sigle-nav-link {{ ($currentRouteName) == 'dashboard.index' ? 'active' : '' }}" >
                                <i class="bi bi-house"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="accordion-item">
                            <span class="accordion-item-title mt-2">Basic</span>
                        </li>

                        <li class="accordion-item">
                            <a href="#"
                            class="accordion-button {{ ($currentRoute == 'customer' || $currentRoute == 'supplier') ? '' : 'collapsed' }}"
                            data-bs-toggle="collapse"
                            data-bs-target="#contact"
                            aria-expanded="{{ ($currentRoute == 'customer' || $currentRoute == 'supplier') ? 'true' : 'false' }}"
                            aria-controls="contact">
                                <i class="bi bi-people"></i>
                                    <span class="me-auto">Contact</span>
                                <i class="bi bi-chevron-left"></i>
                            </a>

                            <ul id="contact"
                                class="accordion-collapse collapse {{ ($currentRoute == 'customer' || $currentRoute == 'supplier') ? 'show' : '' }}"
                                data-bs-parent="#page">
                                <li>
                                    <a href="{{route('customer.index')}}" class="nav-link {{ ($currentRouteName == 'customer.index') ? 'active' : '' }}"><span>Customers</span></a>

                                </li>
                                <li>
                                    <a href="{{route('supplier.index')}}" class="nav-link {{ ($currentRouteName == 'supplier.index') ? 'active' : '' }}"><span>Suppliers</span></a>
                                </li>
                            </ul>
                        </li>

                        <li class="accordion-item">
                            <a
                            href="#"
                            class="accordion-button {{ ($currentRoute == 'purchase') ? '' : 'collapsed' }}"
                            data-bs-toggle="collapse"
                            data-bs-target="#purchase"
                            aria-expanded="{{ ($currentRoute == 'purchase') ? 'true' : 'false' }}"
                            aria-controls="purchase">
                                <i class="bi bi-bag"></i>
                                    <span class="me-auto">Purchase</span>
                                <i class="bi bi-chevron-left"></i>
                            </a>

                            <ul id="purchase"
                                class="accordion-collapse collapse {{ ($currentRoute == 'purchase') ? 'show' : '' }}"
                                data-bs-parent="#page">
                                <li>
                                    <a href="{{route('purchase.index')}}" class="nav-link {{ ($currentRouteName == 'purchase.index') ? 'active' : '' }}"><span>All records</span></a>

                                </li>
                                <li>
                                    <a href="{{route('purchase.create')}}" class="nav-link {{ ($currentRouteName == 'purchase.create') ? 'active' : '' }}"><span>New entry</span></a>
                                </li>
                            </ul>
                        </li>

                        <li class="accordion-item">
                            <a
                            href="#"
                            class="accordion-button {{ ($currentRoute == 'sale') ? '' : 'collapsed' }}"
                            data-bs-toggle="collapse"
                            data-bs-target="#sale"
                            aria-expanded="{{ ($currentRoute == 'sale') ? 'true' : 'false' }}"
                            aria-controls="sale">
                                <i class="bi bi-cart2"></i>
                                    <span class="me-auto">Sale</span>
                                <i class="bi bi-chevron-left"></i>
                            </a>

                        <ul id="sale"
                            class="accordion-collapse collapse {{ ($currentRoute == 'sale') ? 'show' : '' }}"
                            data-bs-parent="#page">
                            <li>
                                <a href="{{route('sale.index')}}" class="nav-link {{ ($currentRouteName == 'sale.index') ? 'active' : '' }}"><span>All records</span></a>

                            </li>
                            <li>
                                <a href="{{route('sale.create')}}" class="nav-link {{ ($currentRouteName == 'sale.create') ? 'active' : '' }}"><span>New entry</span></a>
                            </li>
                        </ul>
                        </li>

                        {{-- Stock  --}}
                        <li class="accordion-item">
                            <a href="{{route('stock.index')}}" class="sigle-nav-link {{ ($currentRouteName) == 'stock.index' ? 'active' : '' }}" >
                                <i class="bi bi-box2"></i>
                                <span>Stock</span>
                            </a>
                        </li>

                        <li class="accordion-item">
                            <a href="#"
                            class="accordion-button {{ ($currentRoute == 'customer-due-manage' || $currentRoute == 'supplier-due-manage') ? '' : 'collapsed' }}"
                            data-bs-toggle="collapse"
                            data-bs-target="#due_manage"
                            aria-expanded="{{ ($currentRoute == 'customer-due-manage' || $currentRoute == 'supplier-due-manage') ? 'true' : 'false' }}"
                            aria-controls="due_manage">
                                <i class="bi bi-wallet2"></i>
                                    <span class="me-auto">Due Manage</span>
                                <i class="bi bi-chevron-left"></i>
                            </a>

                            <ul id="due_manage"
                                class="accordion-collapse collapse {{ ($currentRoute == 'customer-due-manage' || $currentRoute == 'supplier-due-manage') ? 'show' : '' }}"
                                data-bs-parent="#page">
                                <li>
                                    <a href="{{route('customer-due-manage.index')}}" class="nav-link {{ ($currentRouteName == 'customer-due-manage.index') ? 'active' : '' }}"><span>Customers</span></a>

                                </li>
                                <li>
                                    <a href="{{route('supplier-due-manage.index')}}" class="nav-link {{ ($currentRouteName == 'supplier-due-manage.index') ? 'active' : '' }}"><span>Suppliers</span></a>
                                </li>
                            </ul>
                        </li>

                        <li class="accordion-item">
                            <a href="#"
                            class="accordion-button {{ ($currentRoute == 'expense-category' || $currentRoute ==  'expense-subcategory' || $currentRoute ==  'expense') ? '' : 'collapsed' }}"
                            data-bs-toggle="collapse"
                            data-bs-target="#expense"
                            aria-expanded="{{ ($currentRoute == 'expense-category' || $currentRoute ==  'expense-subcategory' || $currentRoute ==  'expense') ? 'true' : 'false' }}"
                            aria-controls="expense">
                                <i class="bi bi-credit-card-2-front"></i>
                                    <span class="me-auto">Expense</span>
                                <i class="bi bi-chevron-left"></i>
                            </a>

                        <ul id="expense"
                            class="accordion-collapse collapse {{ ($currentRoute == 'expense-category' || $currentRoute ==  'expense-subcategory' || $currentRoute ==  'expense') ? 'show' : '' }}"
                            data-bs-parent="#page">

                            <li>
                                <a href="{{route('expense.index')}}" class="nav-link {{ ($currentRouteName == 'expense.index') ? 'active' : '' }}">
                                    <span>All expense</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('expense.create')}}" class="nav-link {{ ($currentRouteName == 'expense.create') ? 'active' : '' }}">
                                    <span>New entry</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('expense-category.index')}}" class="nav-link {{ ($currentRouteName == 'expense-category.index') ? 'active' : '' }}">
                                    <span>Category</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('expense-subcategory.index')}}" class="nav-link {{ ($currentRouteName == 'expense-subcategory.index') ? 'active' : '' }}">
                                    <span>Subcategory</span>
                                </a>
                            </li>
                        </ul>
                        </li>
                        {{-- Monthly recharge start  --}}
                        <li class="accordion-item">
                            <a href="{{route('monthly-recharge.index')}}" class="sigle-nav-link {{ ($currentRouteName) == 'monthly-recharge.index' ? 'active' : '' }}" >
                                <i class="bi bi-calendar"></i>
                                <span>Monthly Recharge</span>
                            </a>
                        </li>
                        {{-- Monthly recharge end  --}}

                        <li class="accordion-item">
                            <a href="#"
                            class="accordion-button {{ ($currentRoute == 'payroll-advanced' || $currentRoute ==  'payroll-loan' || $currentRoute ==  'payroll-salary') ? '' : 'collapsed' }}"
                            data-bs-toggle="collapse"
                            data-bs-target="#payroll"
                            aria-expanded="{{ ($currentRoute == 'payroll-advanced' || $currentRoute ==  'payroll-loan' || $currentRoute ==  'payroll-salary') ? 'true' : 'false' }}"
                            aria-controls="payroll">
                                <i class="bi bi-credit-card-2-back"></i>
                                    <span class="me-auto">Payroll</span>
                                <i class="bi bi-chevron-left"></i>
                            </a>

                            <ul id="payroll"
                                class="accordion-collapse collapse {{ ($currentRoute == 'payroll-advanced' || $currentRoute ==  'payroll-loan' || $currentRoute ==  'payroll-salary') ? 'show' : '' }}"
                                data-bs-parent="#page">

                                <li>
                                    <a href="{{route('payroll-advanced.index')}}" class="nav-link {{ ($currentRouteName == 'payroll-advanced.index') ? 'active' : '' }}">
                                        <span>Advanced</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('payroll-loan.index')}}" class="nav-link {{ ($currentRouteName == 'payroll-loan.index') ? 'active' : '' }}">
                                        <span>Loan</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('payroll-salary.index')}}" class="nav-link {{ ($currentRouteName == 'payroll-salary.index') ? 'active' : '' }}">
                                        <span>All salary</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('payroll-salary.create')}}" class="nav-link {{ ($currentRouteName == 'payroll-salary.create') ? 'active' : '' }}">
                                        <span>New salary</span>
                                    </a>
                                </li>


                            </ul>
                        </li>

                        <!--==========Report Part start=========== -->
                        <li class="accordion-item">
                                <span class="accordion-item-title mt-2">Reports</span>
                            </li>

                            <li class="accordion-item">
                                <a href="{{route('report.cash-book')}}" class="sigle-nav-link {{ ($currentRouteName) == 'report.cash-book' ? 'active' : '' }}" >
                                    <i class="bi bi-book"></i>
                                    <span>Cash Book</span>
                                </a>
                            </li>

                            <li class="accordion-item">
                                <a
                                href="#"
                                class="accordion-button {{ ($currentRoute == 'ledger') ? '' : 'collapsed' }}"
                                data-bs-toggle="collapse"
                                data-bs-target="#ledger"
                                aria-expanded="{{ ($currentRoute == 'ledger') ? 'true' : 'false' }}"
                                aria-controls="ledger">
                                    <i class="bi bi-calendar"></i>
                                        <span class="me-auto">Ledger</span>
                                    <i class="bi bi-chevron-left"></i>
                                </a>

                                <ul id="ledger"
                                    class="accordion-collapse collapse {{ ($currentRoute == 'ledger') ? 'show' : '' }}"
                                    data-bs-parent="#report">
                                    <li>
                                        <a href="{{route('ledger.customer-ledger')}}" class="nav-link {{ ($currentRouteName == 'ledger.customer-ledger') ? 'active' : '' }}"><span>Customer ledger</span></a>

                                    </li>
                                    <li>
                                        <a href="{{route('ledger.supplier-ledger')}}" class="nav-link {{ ($currentRouteName == 'ledger.supplier-ledger') ? 'active' : '' }}"><span>Supplier ledger</span></a>

                                    </li>
                                </ul>
                            </li>

                     <!--==========Report Part end=========== -->

                    <!--==========Settings Part start=========== -->
                            <li class="accordion-item">
                                <span class="accordion-item-title mt-2">Settings</span>
                            </li>

                            <li class="accordion-item">
                                <a href="#"
                                    class="accordion-button {{ ($currentRoute == 'product') ? '' : 'collapsed' }}"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#product"
                                    aria-expanded="{{ ($currentRoute == 'product') ? 'true' : 'false' }}"
                                    aria-controls="product">
                                        <i class="bi bi-file-ppt"></i>
                                            <span class="me-auto">Product</span>
                                        <i class="bi bi-chevron-left"></i>
                                </a>

                                <ul id="product"
                                    class="accordion-collapse collapse {{ ($currentRoute == 'product') ? 'show' : '' }}"
                                    data-bs-parent="#component">
                                    <li>
                                        <a href="{{route('product.index')}}" class="nav-link {{ ($currentRouteName == 'product.index') ? 'active' : '' }}"><span>All records</span></a>

                                    </li>
                                    <li>
                                        <a href="{{route('product.create')}}" class="nav-link {{ ($currentRouteName == 'product.create') ? 'active' : '' }}"><span>New entry</span></a>
                                    </li>
                                </ul>
                            </li>


                            <li class="accordion-item">
                                <a href="#"
                                    class="accordion-button {{ ($currentRoute == 'area') ? '' : 'collapsed' }}"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#area"
                                    aria-expanded="{{ ($currentRoute == 'area') ? 'true' : 'false' }}"
                                    aria-controls="area">
                                        <i class="bi bi-geo-alt"></i>
                                            <span class="me-auto">Area</span>
                                        <i class="bi bi-chevron-left"></i>
                                </a>

                                <ul id="area"
                                    class="accordion-collapse collapse {{ ($currentRoute == 'area') ? 'show' : '' }}"
                                    data-bs-parent="#component">
                                    <li>
                                        <a href="{{route('area.index')}}" class="nav-link {{ ($currentRouteName == 'area.index') ? 'active' : '' }}"><span>All records</span></a>

                                    </li>
                                    <li>
                                        <a href="{{route('area.create')}}" class="nav-link {{ ($currentRouteName == 'area.create') ? 'active' : '' }}"><span>New entry</span></a>
                                    </li>
                                </ul>
                            </li>

                            <li class="accordion-item">
                                <a href="#"
                                    class="accordion-button {{ ($currentRoute == 'package') ? '' : 'collapsed' }}"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#package"
                                    aria-expanded="{{ ($currentRoute == 'package') ? 'true' : 'false' }}"
                                    aria-controls="package">
                                        <i class="bi bi-journal-text"></i>
                                            <span class="me-auto">Package</span>
                                        <i class="bi bi-chevron-left"></i>
                                </a>

                                <ul id="package"
                                    class="accordion-collapse collapse {{ ($currentRoute == 'package') ? 'show' : '' }}"
                                    data-bs-parent="#component">
                                    <li>
                                        <a href="{{route('package.index')}}" class="nav-link {{ ($currentRouteName == 'package.index') ? 'active' : '' }}"><span>All records</span></a>

                                    </li>
                                    <li>
                                        <a href="{{route('package.create')}}" class="nav-link {{ ($currentRouteName == 'package.create') ? 'active' : '' }}"><span>New entry</span></a>
                                    </li>
                                </ul>
                            </li>

                            <li class="accordion-item">
                                <a href="#"
                                    class="accordion-button {{ ($currentRoute == 'employee') ? '' : 'collapsed' }}"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#employee"
                                    aria-expanded="{{ ($currentRoute == 'employee') ? 'true' : 'false' }}"
                                    aria-controls="employee">
                                    <i class="bi bi-person-badge"></i>
                                            <span class="me-auto">Employee</span>
                                        <i class="bi bi-chevron-left"></i>
                                </a>

                                <ul id="employee"
                                    class="accordion-collapse collapse {{ ($currentRoute == 'employee') ? 'show' : '' }}"
                                    data-bs-parent="#page">
                                    <li>
                                        <a href="{{route('employee.index')}}" class="nav-link {{ ($currentRouteName == 'employee.index') ? 'active' : '' }}">
                                            <span>All records</span>
                                        </a>

                                    </li>
                                    <li>
                                        <a href="{{route('employee.create')}}" class="nav-link {{ ($currentRouteName == 'employee.create') ? 'active' : '' }}">
                                            <span>New entry</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="accordion-item">
                                <a href="#"
                                    class="accordion-button {{ ($currentRoute == 'cash') ? '' : 'collapsed' }}"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#cash"
                                    aria-expanded="{{ ($currentRoute == 'cash') ? 'true' : 'false' }}"
                                    aria-controls="cash">
                                        <i class="bi bi-cash"></i>
                                            <span class="me-auto">Cash</span>
                                        <i class="bi bi-chevron-left"></i>
                                </a>

                                <ul id="cash"
                                    class="accordion-collapse collapse {{ ($currentRoute == 'cash') ? 'show' : '' }}"
                                    data-bs-parent="#component">
                                    <li>
                                        <a href="{{route('cash.index')}}" class="nav-link {{ ($currentRouteName == 'cash.index') ? 'active' : '' }}"><span>All records</span></a>

                                    </li>
                                    <li>
                                        <a href="{{route('cash.create')}}" class="nav-link {{ ($currentRouteName == 'cash.create') ? 'active' : '' }}"><span>New entry</span></a>
                                    </li>
                                </ul>
                            </li>
                         <!--==========Settings Part end=========== -->
                         <!--==========SMS Part start=========== -->
                            <li class="accordion-item">
                                    <span class="accordion-item-title mt-2">SMS</span>
                            </li>

                            <li class="accordion-item">
                                <a
                                href="#"
                                class="accordion-button {{ ($currentRoute == 'sms') ? '' : 'collapsed' }}"
                                data-bs-toggle="collapse"
                                data-bs-target="#sms"
                                aria-expanded="{{ ($currentRoute == 'sms') ? 'true' : 'false' }}"
                                aria-controls="sms">
                                    <i class="bi bi-chat-left-dots"></i>
                                        <span class="me-auto">SMS</span>
                                    <i class="bi bi-chevron-left"></i>
                                </a>

                                <ul id="sms"
                                    class="accordion-collapse collapse {{ ($currentRoute == 'sms') ? 'show' : '' }}"
                                    data-bs-parent="#page">
                                    <li>
                                        <a href="{{route('sms.group-sms')}}" class="nav-link {{ ($currentRouteName == 'sms.group-sms') ? 'active' : '' }}"><span>Group SMS</span></a>

                                    </li>
                                    <li>
                                        <a href="{{route('sms.custom-sms')}}" class="nav-link {{ ($currentRouteName == 'sms.custom-sms') ? 'active' : '' }}"><span>Custom SMS</span></a>
                                    </li>
                                    <li>
                                        <a href="{{route('sms.template-sms')}}" class="nav-link {{ ($currentRouteName == 'sms.template-sms') ? 'active' : '' }}"><span>Template SMS</span></a>
                                    </li>
                                </ul>
                            </li>

                            <li class="accordion-item">
                                <a href="#"
                                    class="accordion-button {{ ($currentRoute == 'sms-template') ? '' : 'collapsed' }}"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#sms_template"
                                    aria-expanded="{{ ($currentRoute == 'sms-template') ? 'true' : 'false' }}"
                                    aria-controls="sms_template">
                                        <i class="bi bi-chat-square-text"></i>
                                            <span class="me-auto">SMS Template</span>
                                        <i class="bi bi-chevron-left"></i>
                                </a>

                                <ul id="sms_template"
                                    class="accordion-collapse collapse {{ ($currentRoute == 'sms-template') ? 'show' : '' }}"
                                    data-bs-parent="#page">
                                    <li>
                                        <a href="{{route('sms-template.index')}}" class="nav-link {{ ($currentRouteName == 'sms-template.index') ? 'active' : '' }}">
                                            <span>All records</span>
                                        </a>

                                    </li>
                                    <li>
                                        <a href="{{route('sms-template.create')}}" class="nav-link {{ ($currentRouteName == 'sms-template.create') ? 'active' : '' }}">
                                            <span>New entry</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                             <!--==========SMS Part end=========== -->
                    </ul>

                </div>
                <!-- End pages menu list =================================== -->

                <!-- Start components menu list =================================== -->
                {{-- <div class="tab-pane fade" id="v-pills-components" role="tabpanel" aria-labelledby="v-pills-components-tab">

                    <!-- Start fixt title =================================== -->
                    <div class="fixt-title">
                        <p>Components</p>
                    </div>
                    <!-- End fixt title =================================== -->


                    <!-- Start menus =================================== -->
                    <ul class="accordion" id="component">

                    </ul>
                    <!-- End menus =================================== -->


                </div> --}}
                <!-- End components menu list =================================== -->

            </div>
        </div>
        <!-- End aside menu bar =================================== -->

  </aside>
  <!-- End aside =================================== -->


  <!-- Start aside background Shadow =================================== -->
  <div id="aside-layer" onclick="expandFunction()"></div>
  <!-- End aside background Shadow =================================== -->
