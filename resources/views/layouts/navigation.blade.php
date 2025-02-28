<aside class="aside is-placed-left is-expanded">
  <div class="aside-tools">
    <div>
      Admin <b class="font-black">One</b>
    </div>
  </div>
  <div class="menu is-menu-main">
    <p class="menu-label text-white">General</p>
    <ul class="menu-list">
      @if (Auth::user()->role !== 'agent')
        <li class="--set-active-dashboard">
          <a href="{{ route('dashboard') }}" class="text-white hover:text-gray-200">
            <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
            <span class="menu-item-label">Dashboard</span>
          </a>
        </li>
      @endif
    </ul>
    <p class="menu-label text-white">Navigation</p>
    <ul class="menu-list">
      @if (Auth::user()->role !== 'admin')
      <li>
        <a href="{{ route('home') }}" class="text-white hover:text-gray-200">
          <span class="icon"><i class="mdi mdi-home"></i></span>
          <span class="menu-item-label">Home</span>
        </a>
      </li>
      @endif
      <li>
        <a href="{{ route('clients.index') }}" class="text-white hover:text-gray-200">
          <span class="icon"><i class="mdi mdi-account-group"></i></span>
          <span class="menu-item-label">Clients</span>
        </a>
      </li>
      <li>
        <a href="{{ route('products.index') }}" class="text-white hover:text-gray-200">
          <span class="icon"><i class="mdi mdi-package-variant"></i></span>
          <span class="menu-item-label">Products</span>
        </a>
      </li>
      @if (Auth::user()->role !== 'agent')
      <li>
        <a href="{{ route('mediaBuyers.index') }}" class="text-white hover:text-gray-200">
          <span class="icon"><i class="mdi mdi-shopping"></i></span>
          <span class="menu-item-label">Media Buyers</span>
        </a>
      </li>
      @endif
      <li>
        <a href="{{ route('leads.index') }}" class="text-white hover:text-gray-200">
          <span class="icon"><i class="mdi mdi-chart-line"></i></span>
          <span class="menu-item-label">Leads</span>
        </a>
      </li>
      @if (Auth::user()->role !== 'agent')
      <li>
        <a href="{{ route('agents.index') }}" class="text-white hover:text-gray-200">
          <span class="icon"><i class="mdi mdi-account-tie"></i></span>
          <span class="menu-item-label">Agents</span>
        </a>
      </li>
      @endif
      <li>
        <a href="{{ route('agents.stats', ['agentId' => Auth::user()->id]) }}" class="text-white hover:text-gray-200">
          <span class="icon"><i class="mdi mdi-chart-bar"></i></span>
          <span class="menu-item-label">Agent Stats</span>
        </a>
      </li>
    </ul>
    <p class="menu-label text-white">User</p>
    <ul class="menu-list">
      @if (Auth::check())
        <li>
          <a href="#" class="text-white">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            <span class="menu-item-label">{{ Auth::user()->name }}</span>
          </a>
        </li>
        <li>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-white hover:text-gray-200 w-full text-left">
              <span class="icon"><i class="mdi mdi-logout"></i></span>
              <span class="menu-item-label">Log Out</span>
            </button>
          </form>
        </li>
      @else
        <li>
          <a href="{{ route('login') }}" class="text-white hover:text-gray-200">
            <span class="icon"><i class="mdi mdi-login"></i></span>
            <span class="menu-item-label">Log In</span>
          </a>
        </li>
      @endif
    </ul>
  </div>
</aside>
