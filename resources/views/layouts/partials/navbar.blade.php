 <nav class="navbar bg-color">
    <div class="container-fluid">
        <!-- Aside expand button -->
        <div class="expand-button">
            <button class="btn btn-primary" onclick="expandFunction()">
                <i class="bi bi-list-nested"></i>
            </button>
        </div>
        <!-- End aside expand button -->
        <ul class="navbar-wrap ms-auto mb-2 mb-lg-0">

          <!-- Start notification =================================== -->
            <li class="nav-item notification dropdown">

                <!-- Start notification button =================================== -->
                <a class="nav-link" href="#" id="notification-dropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false"><i class="bi bi-bell"></i>
                <!-- badge -->
                <span class="badge badge-counter">{{count($package_inactive_customers)}}</span>
                </a>
                <!-- End notification button =================================== -->

                <!-- Start notification Dropdoun memu =================================== -->
                <ul class="dropdown-menu" aria-labelledby="notification-dropdown">
                @forelse ($package_inactive_customers as $package_inactive_customer)
                    <li>
                    <a class="dropdown-item isseen" href="{{route('monthly-recharge.index')}}">
                    <img src="{{vite_asset("resources/template/assets/icons/notification.svg")}}" alt="baky">
                    <div>
                        <p><strong>{{$package_inactive_customer->customer->name ?? "deleted customer"}} ({{$package_inactive_customer->customer->mobile_no ?? "deleted customer"}}) </strong></p>
                        <p><small>(Last Activated- {{$package_inactive_customer->active_date->format('d M , Y') }}) <span class="badge bg-danger"> Inactive</span></small></p>
                    </div>
                    </a>
                </li>

                @empty

                @endforelse
                </ul>
                <!-- End notification Dropdoun memu =================================== -->
            </li>
          <!-- End notification =================================== -->


          <!-- Start user  =================================== -->
          <li class="nav-item user dropdown">

            <!-- Start user dropdown button  =================================== -->
            <a class="nav-link dropdown-toggl" href="#" id="user-dropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              <img src="{{vite_asset("resources/template/assets/images/user/user.png")}}" alt="">

              <!-- badge-circle Active-->
              <span class="badge-circle active"></span>
            </a>
            <!-- End user dropdown button  =================================== -->

            <!-- Start user dropdown menu  =================================== -->
            <ul class="dropdown-menu" aria-labelledby="user-dropdown">
              <li>
                <a class="dropdown-item profile" href="#">
                  <img src="{{vite_asset("resources/template/assets/images/user/user.png")}}" alt="">
                  <div>
                    <h5>{{ auth()->user()->name }}</h5>
                    <p>Admin</p>
                  </div>
                </a>
              </li>

              <li>
                @can('user.index')
                 <a class="dropdown-item" href="{{ route('user.index') }}">
                  <i class="bi bi-person"></i>
                  <span>user</span>
                </a>
                @endcan
              </li>

              <li>
                @can('role.index')
                  <a class="dropdown-item" href="{{ route('role.index') }}">
                  <i class="bi bi-chevron-expand"></i>
                  <span>Role</span>
                </a>
                @endcan
              </li>

              <li>
                <a class="dropdown-item" href="{{ route('password.change') }}">
                  <i class="bi bi-key"></i>
                  <span>Change password</span>
                </a>
              </li>

              <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="bi bi-box-arrow-left"></i>
                  <span>Logout</span>
                </a>
                <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
              </li>
            </ul>
            <!-- End user dropdown menu  =================================== -->

          </li>
          <!-- End user  =================================== -->

        </ul>

        <!-- Start search-bar =================================== -->
        <div class="search-bar" id="search-bar">
          <form class="h-100">
            <input class="form-control" id="search-input" type="text" placeholder="Search">
            <button type="button" class="close-button" onclick="shearchFunction()"><i class="bi bi-x-lg"></i></button>
          </form>
        </div>
        <!-- End search-bar =================================== -->
      </div>
    </nav>
