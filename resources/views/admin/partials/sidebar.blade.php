
<aside :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
    class="sidebar z-9999 fixed left-0 top-0 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 duration-300 ease-linear lg:static lg:translate-x-0"
    @click.outside="sidebarToggle = false">
    <!-- SIDEBAR HEADER -->
    <div :class="sidebarToggle ? 'justify-center' : 'justify-between'"
        class="sidebar-header flex items-center gap-2 pb-7 pt-8">
        <a href="{{ route('home') }}">
            <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
                <img class="" src="{{ asset('images/logo/logo.svg') }}" alt="Logo" />
            </span>

            <img class="logo-icon" :class="sidebarToggle ? 'lg:block' : 'hidden'" src="{{ asset('images/logo/logo-icon.svg') }}"
                alt="Logo" />
        </a>
    </div>
    <!-- SIDEBAR HEADER -->

    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
        <!-- Sidebar Menu -->
        <nav>
            <!-- Menu Group -->
            <div>
                <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
                    <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">
                        MENU
                    </span>

                </h3>

                <ul class="mb-6 flex flex-col gap-4">
                    <!-- Menu Item Dashboard -->
                    <li>
                        <a href="{{ route('admin') }}"
                            class="menu-item group {{ request()->routeIs('admin') ? 'menu-item-active' : 'menu-item-inactive' }}">

                            <i class="fa-solid fa-house"></i>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Dashboard
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('commandes.index') }}"
                            class="menu-item group {{ request()->routeIs('commandes.*') ? 'menu-item-active' : 'menu-item-inactive' }}">

                            <i class="fa-solid fa-cart-shopping"></i>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Commandes
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('paiements.index') }}"
                            class="menu-item group {{ request()->routeIs('paiements.*') ? 'menu-item-active' : 'menu-item-inactive' }}">

                            <i class="fa-solid fa-credit-card"></i>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Paiements
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services.index') }}"
                            class="menu-item group {{ request()->routeIs('services.*') ? 'menu-item-active' : 'menu-item-inactive' }}">

                            <i class="fa-solid fa-spray-can-sparkles"></i>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Services
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('articles.index') }}"
                            class="menu-item group {{ request()->routeIs('articles.*') ? 'menu-item-active' : 'menu-item-inactive' }}">

                            <i class="fa-solid fa-shirt"></i>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Articles
                            </span>
                        </a>
                    </li>
                    @if(auth()->user()->role === 'ADMIN')
                    <li>
                        <a href="{{ route('users.index') }}"
                            class="menu-item group {{ request()->routeIs('users.*') ? 'menu-item-active' : 'menu-item-inactive' }}">

                            <i class="fa-solid fa-user"></i>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Utilisateurs
                            </span>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ route('admin.forfaits.index') }}"
                            class="menu-item group {{ request()->routeIs('admin.forfaits.*') ? 'menu-item-active' : 'menu-item-inactive' }}">

                            <i class="fa-solid fa-tags"></i>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Forfaits
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.abonnements.index') }}"
                            class="menu-item group {{ request()->routeIs('admin.abonnements.*') ? 'menu-item-active' : 'menu-item-inactive' }}">

                            <i class="fa-solid fa-id-card"></i>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Abonnements
                            </span>
                        </a>
                    </li>
                </ul>
            </div>


        </nav>
        <!-- Sidebar Menu -->


    </div>
</aside>


