<aside class="control-sidebar control-sidebar-dark">
    <div class="p-3 control-sidebar-content" style="">
        <h5>Profile Options</h5>
        <ul class="navbar-nav ms-auto">
            <!-- Authentication Links -->
            @auth
                <div class="d-flex">
                    <li>
                        <a href="{{ route('dashboard.my-account') }}">
                            {{ __('My Account') }}
                        </a>
                    </li>
                </div>               
                <div class="d-flex">
                    <li>
                        <a href="{{ route('dashboard.logout') }}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form"
                            action="{{ 'App\Models\Customer' == Auth::getProvider()->getModel() ? route('dashboard.logout') : route('dashboard.logout') }}"
                            method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </div>
            @endauth
        </ul>
    </div>
</aside>
