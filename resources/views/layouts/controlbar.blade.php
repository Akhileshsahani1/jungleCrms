<aside class="control-sidebar control-sidebar-dark">
    <div class="p-3 control-sidebar-content" style="">
        <h5>Profile Options</h5>
        <ul class="navbar-nav ms-auto">
            <!-- Authentication Links -->
            @auth
                @if (Auth::user()->hasRole('administrator'))
                    <div class="d-flex">
                        <li>
                            <a href="{{ route('my-account') }}">
                                {{ __('My Account') }}
                            </a>
                        </li>
                    </div>
                    <div class="d-flex">
                        <li>
                            <a href="{{ route('change-password') }}">
                                {{ __('Change Password') }}
                            </a>
                        </li>
                    </div>
                @endif
                <div class="d-flex">
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </div>
            @endauth
        </ul>
    </div>
</aside>
