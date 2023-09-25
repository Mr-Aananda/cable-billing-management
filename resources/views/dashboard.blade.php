@section('title', 'Dashboard')

<x-app-layout>
    <x-alert message="You are successfully logged in!" type="success" dismissable/>

     {{-- <div class="text-center">
          <img src="{{vite_asset('resources/template/assets/images/logos/fiber_orbit_trans_logo.png')}}" width="300px"  alt="">
          <img src="{{vite_asset('resources/template/assets/images/logos/logo_with_name.png')}}" width="320px" alt="">
      </div> --}}

     <div class="row g-3">

         <div class="col-md-3">
          <div class="widget summary-warning">
            <div class="widget-body">
              <div class="icon">
                <i class="bi bi-cash"></i>
              </div>
              <div class="text">
                <h5>{{number_format($total_cashes)}} BDT</h5>
                <p>Total Cash</p>
              </div>
            </div>
          </div>
        </div>

         <div class="col-md-3">
          <div class="widget summary-danger">
            <div class="widget-body">
              <div class="icon">
                <i class="bi bi-bag"></i>
              </div>
              <div class="text">
                <h5>{{number_format($total_purchase)}} BDT</h5>
                <p>Today's Purchases</p>
              </div>
            </div>
          </div>
        </div>

         <div class="col-md-3">
          <div class="widget summary-success">
            <div class="widget-body">
              <div class="icon">
                <i class="bi bi-cart2"></i>
              </div>
              <div class="text">
                <h5>{{number_format($total_sale)}} BDT</h5>
                <p>Today's Sales</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="widget summary-danger">
            <div class="widget-body">
              <div class="icon">
                <i class="bi bi-wallet2"></i>
              </div>
              <div class="text">
                <h5>{{number_format($total_expense_amount)}} BDT</h5>
                <p>Today's Expenses</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="widget summary-warning">
            <div class="widget-body">
              <div class="icon">
                <i class="bi bi-people"></i>
              </div>
              <div class="text">
                <h5>{{count($customers)}}</h5>
                <p>Total Customers</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="widget summary">
            <div class="widget-body">
              <div class="icon">
                <i class="bi bi-people"></i>
              </div>
              <div class="text">
                <h5>{{$active_customers}}</h5>
                <p>Active Connections</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="widget summary-success">
            <div class="widget-body">
              <div class="icon">
               <i class="bi bi-currency-dollar"></i>
              </div>
              <div class="text">
                <h5>{{number_format(abs($customer_due))}} BDT</h5>
                <p>Customer Dues</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="widget summary-danger">
            <div class="widget-body">
              <div class="icon">
                <i class="bi bi-currency-dollar"></i>
              </div>
              <div class="text">
                <h5>{{number_format(abs($supplier_due))}} BDT</h5>
                <p>Supplier Dues</p>
              </div>
            </div>
          </div>
        </div>

         {{-- Chart start --}}

        <div class="col-md-6">
          <div class="widget summary-danger">
            <div class="widget-body">
               <canvas id="sale-chart"></canvas>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="widget summary-danger">
            <div class="widget-body">
               <canvas id="purchase-chart"></canvas>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="widget summary-danger">
            <div class="widget-body">
               <canvas id="daily-sale"></canvas>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="widget summary-danger">
            <div class="widget-body">
               <canvas id="daily-purchase"></canvas>
            </div>
          </div>
        </div>
        {{-- Chart end --}}

        {{-- Calender --}}

        {{-- <div class="col-md-4">
          <div class="widget">
            <div class="widget-body" style="height: 365px">

              <h5 class="border-bottom mb-4">Calendar</h5>
              <div class="calendar">
                <button id="btnPrev" class="btn custom icon btn-prev" type="button"><i
                    class="bi bi-chevron-left"></i></button>
                <button id="btnNext" class="btn custom icon btn-next" type="button"><i
                    class="bi bi-chevron-right"></i></button>
                <div id="divCal" class="divCal"></div>
              </div>

            </div>
          </div>
        </div> --}}

        {{-- Calculator --}}

        {{-- <div class="col-md-4">
          <div class="widget">
            <div class="widget-body">

              <h5 class="border-bottom mb-4">calculator</h5>
              <div class="calculator">
                <form name="form">
                  <input type="text" placeholder="0" class="form-control" name="distpay" autofocus>
                  <div class="button-area">
                    <div class="line">
                      <button type="button" value="%" class="btn" onclick="calculator(this.value)">%</button>
                      <button type="button" value="c" class="btn" onclick="distpay.value = null">c</button>
                      <button type="button" value="back" class="btn"
                        onclick="distpay.value = distpay.value.slice(0, -1)"><i class="bi bi-backspace"></i></button>
                      <button type="button" value="/" class="btn" onclick="calculator(this.value)">÷</button>
                    </div>

                    <div class="line">
                      <button type="button" value="7" class="btn" onclick="calculator(this.value)">7</button>
                      <button type="button" value="8" class="btn" onclick="calculator(this.value)">8</button>
                      <button type="button" value="9" class="btn" onclick="calculator(this.value)">9</button>
                      <button type="button" value="*" class="btn" onclick="calculator(this.value)">×</button>
                    </div>

                    <div class="line">
                      <button type="button" value="4" class="btn" onclick="calculator(this.value)">4</button>
                      <button type="button" value="5" class="btn" onclick="calculator(this.value)">5</button>
                      <button type="button" value="6" class="btn" onclick="calculator(this.value)">6</button>
                      <button type="button" value="-" class="btn" onclick="calculator(this.value)">-</button>
                    </div>

                    <div class="line">
                      <button type="button" value="1" class="btn" onclick="calculator(this.value)">1</button>
                      <button type="button" value="2" class="btn" onclick="calculator(this.value)">2</button>
                      <button type="button" value="3" class="btn" onclick="calculator(this.value)">3</button>
                      <button type="button" value="+" class="btn" onclick="calculator(this.value)">+</button>
                    </div>

                    <div class="line">
                      <button type="button" value="0" class="btn" onclick="calculator(this.value)">0</button>
                      <button type="button" value="00" class="btn" onclick="calculator(this.value)">00</button>
                      <button type="button" value="." class="btn" onclick="calculator(this.value)">.</button>
                      <button type="button" value="=" class="btn"
                        onclick="distpay.value = eval(distpay.value)">=</button>
                    </div>
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div> --}}
      </div>


    @push('scripts')
        {{-- <script src="{{vite_asset("resources/template/js/calendar.js")}}"></script>
        <script src="{{vite_asset("resources/template/js/calculator.js")}}"></script> --}}
         <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @endpush

        @push('scripts')
      <script>
        const sale = document.getElementById('sale-chart');

            new Chart(sale, {
              type: 'bar',
              data: {
                labels: {!! json_encode(array_keys($sale_monthly_data)) !!},
                datasets: [{
                  label: 'Sale',
                  backgroundColor: 'rgb(115, 162, 244)',
                  borderColor: 'rgb(115, 162, 244)',
                  data: {!! json_encode(array_values($sale_monthly_data)) !!},
                  borderWidth: 1
                }]
              },
              options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              }
            });

            const purchase = document.getElementById('purchase-chart');

            new Chart(purchase, {
              type: 'bar',
              data: {
                labels: {!! json_encode(array_keys($purchase_monthly_data)) !!},
                datasets: [{
                  label: 'Purchase',
                  backgroundColor: 'rgb(244, 124, 142)',
                  borderColor: 'rgb(244, 124, 142)',
                  data: {!! json_encode(array_values($purchase_monthly_data)) !!},
                  borderWidth: 1
                }]
              },
              options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              }
            });

             // this chart for Daily sale
                let daily_sale = document.getElementById('daily-sale').getContext('2d');
                new Chart(daily_sale, {
                    // The type of chart we want to create
                    type: 'line',

                    // The data for our dataset
                    data: {
                        labels: {!! json_encode(array_keys($daily_sale_data)) !!},
                        datasets: [{
                            label: 'Sale',
                            backgroundColor: 'transparent',
                            borderColor: 'rgb(115, 162, 244)',
                            data: {!! json_encode(array_values($daily_sale_data)) !!},
                        },
                        ]
                    },

                    // Configuration options go here
                    options: {}
                });
                // End Daily sale

                 // this chart for Daily sale
                let daily_purchase = document.getElementById('daily-purchase').getContext('2d');
                new Chart(daily_purchase, {
                    // The type of chart we want to create
                    type: 'line',

                    // The data for our dataset
                    data: {
                        labels: {!! json_encode(array_keys($daily_purchase_data)) !!},
                        datasets: [{
                            label: 'Purchase',
                            backgroundColor: 'transparent',
                            borderColor: 'rgb(244, 124, 142)',
                            data: {!! json_encode(array_values($daily_purchase_data)) !!},
                        },
                        ]
                    },

                    // Configuration options go here
                    options: {}
                });
                // End Daily sale
      </script>
   @endpush

</x-app-layout>
