<aside class="aside is-placed-left is-expanded">
  <div class="aside-tools">
    <div>
      @if (Auth::user()->role === 'admin')
        Admin <b class="font-black">One</b>
      @elseif (Auth::user()->role === 'agent')
        Agent <b class="font-black">One</b>
      @endif
    </div>
  </div>
  <div class="menu is-menu-main">
    <p class="menu-label text-white">General</p>
    <ul class="menu-list">
      @if (Auth::user()->role !== 'agent')
        <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
          <a href="{{ route('dashboard') }}" class="text-white hover:text-gray-200 {{ request()->routeIs('dashboard') ? 'bg-blue-600' : '' }}">
            <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
            <span class="menu-item-label">Dashboard</span>
          </a>
        </li>
      @endif
    </ul>
    <p class="menu-label text-white">Navigation</p>
    <ul class="menu-list">
      @if (Auth::user()->role !== 'admin')
      <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
        <a href="{{ route('home') }}" class="text-white hover:text-gray-200 {{ request()->routeIs('home') ? 'bg-blue-600' : '' }}">
          <span class="icon"><i class="mdi mdi-home"></i></span>
          <span class="menu-item-label">Home</span>
        </a>
      </li>
      @endif
      <li class="{{ request()->routeIs('clients.index') ? 'active' : '' }}">
        <a href="{{ route('clients.index') }}" class="text-white hover:text-gray-200 {{ request()->routeIs('clients.index') ? 'bg-blue-600' : '' }}">
          <span class="icon"><i class="mdi mdi-account-group"></i></span>
          <span class="menu-item-label">Clients</span>
        </a>
      </li>
      <li class="{{ request()->routeIs('products.index') ? 'active' : '' }}">
        <a href="{{ route('products.index') }}" class="text-white hover:text-gray-200 {{ request()->routeIs('products.index') ? 'bg-blue-600' : '' }}">
          <span class="icon"><i class="mdi mdi-package-variant"></i></span>
          <span class="menu-item-label">Products</span>
        </a>
      </li>
      @if (Auth::user()->role !== 'agent')
      <li class="{{ request()->routeIs('mediaBuyers.index') ? 'active' : '' }}">
        <a href="{{ route('mediaBuyers.index') }}" class="text-white hover:text-gray-200 {{ request()->routeIs('mediaBuyers.index') ? 'bg-blue-600' : '' }}">
          <span class="icon"><i class="mdi mdi-shopping"></i></span>
          <span class="menu-item-label">Media Buyers</span>
        </a>
      </li>
      @endif
      <li class="{{ request()->routeIs('leads.index') ? 'active' : '' }}">
        <a href="{{ route('leads.index') }}" class="text-white hover:text-gray-200 {{ request()->routeIs('leads.index') ? 'bg-blue-600' : '' }}">
          <span class="icon"><i class="mdi mdi-chart-line"></i></span>
          <span class="menu-item-label">Leads</span>
        </a>
      </li>
      @if (Auth::user()->role !== 'agent')
      <li class="{{ request()->routeIs('agents.index') ? 'active' : '' }}">
        <a href="{{ route('agents.index') }}" class="text-white hover:text-gray-200 {{ request()->routeIs('agents.index') ? 'bg-blue-600' : '' }}">
          <span class="icon"><i class="mdi mdi-account-tie"></i></span>
          <span class="menu-item-label">Agents</span>
        </a>
      </li>
      @endif
      <li class="{{ request()->routeIs('agents.stats') ? 'active' : '' }}">
        <a href="{{ route('agents.stats', ['agentId' => Auth::user()->id]) }}" class="text-white hover:text-gray-200 {{ request()->routeIs('agents.stats') ? 'bg-blue-600' : '' }}">
          <span class="icon"><i class="mdi mdi-chart-bar"></i></span>
          <span class="menu-item-label">Agent Stats</span>
        </a>
      </li>
    </ul>
    <p class="menu-label text-white">User</p>
    <ul class="menu-list">
      @if (Auth::check())
        <li class="relative user-dropdown">
          <a href="#" class="text-white hover:text-gray-200 flex items-center justify-between" onclick="toggleDropdown(event)">
            <div>
              <span class="icon"><i class="mdi mdi-account"></i></span>
              <span class="menu-item-label">{{ Auth::user()->name }}</span>
            </div>
            <span class="icon"><i class="mdi mdi-chevron-down"></i></span>
          </a>
          <div id="userDropdown" class="hidden absolute left-0 mt-2 w-full bg-gray-700 rounded shadow-lg z-10">
            <form method="POST" action="{{ route('logout') }}" class="py-1">
              @csrf
              <button type="submit" class="text-white hover:bg-gray-600 w-full text-left px-4 py-2 flex items-center">
                <span class="icon mr-2"><i class="mdi mdi-logout"></i></span>
                <span>Log Out</span>
              </button>
            </form>
          </div>
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

<style>
/* You can add these styles to your CSS file */
.menu-list li.active a {
  font-weight: bold;
  border-left: 4px solid #3b82f6;
  padding-left: calc(0.75rem - 4px);
}
</style>

<script>
function toggleDropdown(event) {
  event.preventDefault();
  const dropdown = document.getElementById('userDropdown');
  dropdown.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
  const dropdown = document.getElementById('userDropdown');
  const userDropdown = document.querySelector('.user-dropdown');
  
  if (!userDropdown.contains(event.target) && !dropdown.classList.contains('hidden')) {
    dropdown.classList.add('hidden');
  }
});
</script>