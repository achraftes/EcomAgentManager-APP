<aside class="aside is-placed-left is-expanded bg-gray-900 text-white h-screen">
    <div class="aside-tools p-4 border-b border-gray-700">
        <div class="text-lg font-bold">
            Admin <b class="text-purple-500">One</b>
        </div>
    </div>
    <div class="menu is-menu-main">
        <p class="menu-label text-gray-400 px-4">General</p>
        <ul class="menu-list">
            <li class="{{ request()->routeIs('dashboard') ? 'bg-gray-800' : '' }}">
                <a href="{{ route('dashboard') }}" class="flex items-center p-3 hover:bg-gray-800">
                    <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
                    <span class="menu-item-label ml-2">Dashboard</span>
                </a>
            </li>
        </ul>

        <p class="menu-label text-gray-400 px-4 mt-4">Examples</p>
        <ul class="menu-list">
            <li class="{{ request()->routeIs('clients.index') ? 'bg-gray-800' : '' }}">
                <a href="{{ route('clients.index') }}" class="flex items-center p-3 hover:bg-gray-800">
                    <span class="icon"><i class="mdi mdi-account-circle"></i></span>
                    <span class="menu-item-label ml-2">Clients</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('products.index') ? 'bg-gray-800' : '' }}">
                <a href="{{ route('products.index') }}" class="flex items-center p-3 hover:bg-gray-800">
                    <span class="icon"><i class="mdi mdi-table"></i></span>
                    <span class="menu-item-label ml-2">Products</span>
                </a>
            </li>
            @if(Auth::user()->role !== 'agent')
            <li class="{{ request()->routeIs('mediaBuyers.index') ? 'bg-gray-800' : '' }}">
                <a href="{{ route('mediaBuyers.index') }}" class="flex items-center p-3 hover:bg-gray-800">
                    <span class="icon"><i class="mdi mdi-view-list"></i></span>
                    <span class="menu-item-label ml-2">Media Buyer</span>
                </a>
            </li>
            @endif
            <li class="{{ request()->routeIs('leads.index') ? 'bg-gray-800' : '' }}">
                <a href="{{ route('leads.index') }}" class="flex items-center p-3 hover:bg-gray-800">
                    <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
                    <span class="menu-item-label ml-2">Leads</span>
                </a>
            </li>
            @if (Auth::user()->role !== 'agent')
            <li class="{{ request()->routeIs('agents.index') ? 'bg-gray-800' : '' }}">
                <a href="{{ route('agents.index') }}" class="flex items-center p-3 hover:bg-gray-800">
                    <span class="icon"><i class="mdi mdi-account-tie"></i></span>
                    <span class="menu-item-label ml-2">Agents</span>
                </a>
            </li>
            @endif
            <li class="{{ request()->routeIs('agents.stats') ? 'bg-gray-800' : '' }}">
                <a href="{{ route('agents.stats', ['agentId' => Auth::user()->id]) }}" class="flex items-center p-3 hover:bg-gray-800">
                    <span class="icon"><i class="mdi mdi-chart-line"></i></span>
                    <span class="menu-item-label ml-2">Agent Stats</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-3 hover:bg-gray-800">
                    <span class="icon"><i class="mdi mdi-lock"></i></span>
                    <span class="menu-item-label ml-2">Login</span>
                </a>
            </li>
        </ul>

        
    </div>
</aside>
