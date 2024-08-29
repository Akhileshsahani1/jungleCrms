<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
      <img src="{{ asset('dist/img/logo-small.png') }}" alt="Jungle Safari India" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Jungle Safari India</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('leads.index') }}" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Leads
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('estimates.index') }}" class="nav-link">
              <i class="nav-icon fas fa-calculator"></i>
              <p>
                Estimates
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('bookings.index') }}" class="nav-link">
              <i class="nav-icon fas fa-check-circle"></i>
              <p>
                Bookings
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('customers.index') }}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Customers
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('hotels.index') }}" class="nav-link">
              <i class="nav-icon fas fa-hotel"></i>
              <p>
                Hotels
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Sales
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('companies.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Company</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('invoices.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Invoices</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('reports.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Reports</p>
                  </a>
                </li>
              </ul>
          </li>
          @if (Auth::user()->hasRole('administrator'))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Defaults
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href=".#" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Estimates</p>
                    <i class="right fas fa-angle-left"></i>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{ route('terms.index') }}" class="nav-link">
                        <i class="far fa-dot-circle nav-icon text-warning"></i>
                        <p>Terms & Conditions</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('inclusions.index') }}" class="nav-link">
                        <i class="far fa-dot-circle nav-icon text-warning"></i>
                        <p>Inclusions</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('exclusions.index') }}" class="nav-link">
                        <i class="far fa-dot-circle nav-icon text-warning"></i>
                        <p>Exclusions</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('estimate-destinations.index') }}" class="nav-link">
                        <i class="far fa-dot-circle nav-icon text-warning"></i>
                        <p>Destinations</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="{{ route('invoice.terms.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Invoices</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('voucher.terms.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Vouchers</p>
                  </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('vendor.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon text-success"></i>
                      <p>Vendors</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('permit.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon text-success"></i>
                      <p>Permit Rate</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('local-address.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon text-success"></i>
                      <p>Local Address</p>
                    </a>
                  </li>
                   <li class="nav-item">
                    <a href="{{ route('permit.generate_permits') }}" class="nav-link">
                      <i class="far fa-circle nav-icon text-success"></i>
                      <p>Generate Permits</p>
                    </a>
                    <li class="nav-item">
                      <a href="{{ route('long-weekends.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon text-success"></i>
                        <p>Long Weekends</p>
                      </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('marquees.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon text-success"></i>
                      <p>Marquees</p>
                    </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('terms-and-conditions.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Terms & Conditions</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('chancellation-charges.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Cancellation Charges
                    </p>
                  </a>
                </li>
                
                <li class="nav-item">
                      <a href="{{ url('master-logout') }}" class="nav-link">
                        <i class="far fa-dot-circle nav-icon text-warning"></i>
                        <p>Logout All Users</p>
                      </a>
                    </li>
              </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>
                Payment Modes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('offline-mode.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Offline</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('razorpay-mode.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Razorpay</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('upi-mode.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>UPI</p>
                  </a>
                </li>
              </ul>
          </li>
          @endif
          @if (Auth::user()->hasRole('administrator'))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                User Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('users.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Users</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('online.users') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Online Users</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('roles.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Roles</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('permissions.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Permissions</p>
                  </a>
                </li>
              </ul>
          </li>
          @endif
          @if (Auth::user()->hasRole('administrator'))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('my-account') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>My Account</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('change-password') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Change Password</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('lead-status.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Lead Status</p>
                  </a>
                </li>

              </ul>
          </li>
          @endif
           <li class="nav-item">
            <a href="{{ route('iternary.index') }}" class="nav-link">
              <i class="nav-icon fas fa-calculator"></i>
              <p>
                Iternaries
              </p>
            </a>
          </li>

          @if (Auth::user()->hasRole('administrator'))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('no-of-estimates') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Number of Estimate</p>
                  </a>
                </li>
               <li class="nav-item">
                  <a href="{{ route('no-of-bookings') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Number of Bookings </p>
                  </a>
                </li>

                 <li class="nav-item">
                  <a href="{{ route('no-of-packages') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Number of Package</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('no-of-safari') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Number of Safari Booking</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('total-bookings') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Total Amount of Booking</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('total-unpaid-estimates') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Total Unpaid Estimates</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('total-paid-estimates') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Total Paid Estimates</p>
                  </a>
                </li>

                 <li class="nav-item">
                  <a href="{{ route('total-partial-booking') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Total Partial Bookings</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('total-members-booking') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Total Members Booking</p>
                  </a>
                </li>
                

              </ul>
          </li>
          @endif
           @if (Auth::user()->hasRole('administrator'))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Trash
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('trash-leads') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Leads</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('trash-estimates') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Estimates</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('trash-bookings.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>Bookings</p>
                  </a>
                </li>

              </ul>
          </li>
          @endif

          <li class="nav-item">
            <a href="{{ route('support.index') }}" class="nav-link">
              <i class="nav-icon fas fa-headset"></i>
              <p>
                Support
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('cancellation.requests') }}" class="nav-link">
              <i class="nav-icon fas fa-toggle-on"></i>
              <p>
                Cancellation Requests
              </p>
              @php
                $cancellation_request_count = \App\Models\BookingCancellationRequest::where('seen', false)->count();
              @endphp
              @if($cancellation_request_count > 0)
              <span class="right badge bg-danger">{{ $cancellation_request_count }}</span>
              @endif
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('user-activities.index') }}" class="nav-link">
              <i class="nav-icon fas fa-star"></i>
              <p>
                User Activity
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
