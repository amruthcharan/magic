<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/mp.png') }}" class="w-100" alt="logo" />
        </a>
    </div>
    <nav class="sidebar-nav">
        <ul>
            <li class="nav-item @if (request()->routeIs('shopify.dashboard')) active @endif">
                <a href="{{ route('shopify.dashboard') }}">
                    <span class="icon">
                      <i class="lni lni-dashboard"></i>
                    </span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <span class="icon">
                      <i class="lni lni-cog"></i>
                    </span>
                    <span class="text">Settings</span>
                </a>
            </li>

            {{-- <li class="nav-item nav-item-has-children">
            <a
              href="#0"
              class="collapsed"
              data-bs-toggle="collapse"
              data-bs-target="#ddmenu_4"
              aria-controls="ddmenu_4"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="icon">
                <svg
                  width="22"
                  height="22"
                  viewBox="0 0 22 22"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M3.66675 4.58325V16.4999H19.2501V4.58325H3.66675ZM5.50008 14.6666V6.41659H8.25008V14.6666H5.50008ZM10.0834 14.6666V11.4583H12.8334V14.6666H10.0834ZM17.4167 14.6666H14.6667V11.4583H17.4167V14.6666ZM10.0834 9.62492V6.41659H17.4167V9.62492H10.0834Z"
                  />
                </svg>
              </span>
              <span class="text">UI Elements </span>
            </a>
            <ul id="ddmenu_4" class="collapse dropdown-nav">
              <li>
                <a href="alerts.html"> Alerts </a>
              </li>
              <li>
                <a href="buttons.html"> Buttons </a>
              </li>
              <li>
                <a href="cards.html"> Cards </a>
              </li>
              <li>
                <a href="typography.html"> Typography </a>
              </li>
            </ul>
          </li> 
          <span class="divider"><hr /></span> --}}
        </ul>
    </nav>
</aside>
<div class="overlay"></div>
