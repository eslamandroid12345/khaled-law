<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('/') }}" class="brand-link">
        {{--        <img src="{{asset("logo.png")}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
        <span class="brand-text font-weight-light">@lang('dashboard.khaled')</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ auth()->user()->image ? asset(auth()->user()->image) : asset('img/user2-160x160.jpg') }}"
                     class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{route('settings.edit',auth()->id())}}" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item  {{ in_array(request()->route()->getName(),['/'])? 'menu-open': '' }}">
                    <a href="{{ url('/') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            @lang('dashboard.Home')
                        </p>
                    </a>
                </li>
                @permission('users-read')
                <li class="nav-item  {{ in_array(request()->route()->getName(),['users.index', 'users.create', 'users.edit', 'users.show'])? 'menu-open': '' }}">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            @lang('dashboard.users')
                        </p>
                    </a>
                </li>
                @endpermission
                @permission('lawyers-read')
                <li class="nav-item  {{ in_array(request()->route()->getName(),['lawyers.index', 'lawyers.create', 'lawyers.edit', 'lawyers.show'])? 'menu-open': '' }}">
                    <a href="{{ route('lawyers.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-balance-scale"></i>
                        <p>
                            @lang('dashboard.lawyers')
                        </p>
                    </a>
                </li>
                @endpermission
                @permission('categories-read')
                <li class="nav-item  {{ in_array(request()->route()->getName(),['categories.index', 'categories.create', 'categories.edit', 'categories.show'])? 'menu-open': '' }}">
                    <a href="{{ route('categories.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                            @lang('dashboard.categories')
                        </p>
                    </a>
                </li>
                @endpermission
                @permission('services-read')
                <li class="nav-item  {{ in_array(request()->route()->getName(),['services.index', 'services.create', 'services.edit', 'services.show'])? 'menu-open': '' }}">
                    <a href="{{ route('services.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-hands-helping"></i>
                        <p>
                            @lang('dashboard.services')
                        </p>
                    </a>
                </li>
                @endpermission
                @permission('orders-read')
                <li class="nav-item  {{ in_array(request()->route()->getName(),['orders.index', 'orders.show'])? 'menu-open': '' }}">
                    <a href="{{ route('orders.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            @lang('dashboard.orders')
                        </p>
                    </a>
                </li>
                @endpermission
                @permission('transaction-read')
                <li class="nav-item  {{ in_array(request()->route()->getName(),['transactions.index', 'transactions.show'])? 'menu-open': '' }}">
                    <a href="{{ route('transactions.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p>
                            @lang('dashboard.transactions')
                        </p>
                    </a>
                </li>
                @endpermission
                @permission('legalforms-read')
                <li class="nav-item  {{ in_array(request()->route()->getName(),['legal-forms.index', 'legal-forms.create', 'legal-forms.edit', 'legal-forms.show'])? 'menu-open': '' }}">
                    <a href="{{ route('legal-forms.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-contract"></i>
                        <p>
                            @lang('dashboard.legalforms')
                        </p>
                    </a>
                </li>
                @endpermission
                @permission('consultations-read')
                <li class="nav-item  {{ in_array(request()->route()->getName(),['consultations.index', 'consultations.show'])? 'menu-open': '' }}">
                    <a href="{{ route('consultations.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>
                            @lang('dashboard.consultations')
                        </p>
                    </a>
                </li>
                @endpermission
                @permission('customer-review-read')
                <li class="nav-item  {{ in_array(request()->route()->getName(),['customer-reviews.index', 'customer-reviews.create', 'customer-reviews.edit', 'customer-reviews.show'])? 'menu-open': '' }}">
                    <a href="{{ route('customer-reviews.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-star-half-alt"></i>
                        <p>
                            @lang('dashboard.customer-review')
                        </p>
                    </a>
                </li>
                @endpermission
                @permission('roles-read')
                    <li class="nav-item  {{ in_array(request()->route()->getName(),['roles.index','roles.create','roles.edit','roles.mangers','managers.create','managers.edit'])? 'menu-open': '' }}">
                        <a href="{{ route('roles.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-key"></i>
                            <p>
                                @lang('dashboard.roles_and_permissions')
                            </p>
                        </a>
                    </li>
                @endpermission
                @permission('times-read')
                <li class="nav-item  {{ in_array(request()->route()->getName(),['time.index','time.edit'])? 'menu-open': '' }}">
                    <a href="{{ route('time.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>
                            @lang('dashboard.times')
                        </p>
                    </a>
                </li>
                @endpermission
                @permission('uses-read')
                <li class="nav-item  {{ in_array(request()->route()->getName(),['uses.index', 'uses.create', 'uses.edit', 'uses.show'])? 'menu-open': '' }}">
                    <a href="{{ route('uses.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <p>
                            @lang('dashboard.uses')
                        </p>
                    </a>
                </li>
                @endpermission

                @permission('setting-read')
                <li
                    class="nav-item  {{ in_array(request()->route()->getName(),['settings.edit'])? 'menu-open': '' }} {{ Route::currentRouteName()=='settings.edit'?'activeNav':'' }}">
                    <a href="{{ route('settings.edit', auth()->user()->id) }}" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            @lang('dashboard.Settings')
                        </p>
                    </a>
                </li>
                @endpermission
                @permission('info-read')
                <li class="nav-item  {{ in_array(request()->route()->getName(),['infos.edit'])? 'menu-open': '' }} {{ Route::currentRouteName()=='infos.edit'?'activeNav':'' }}">
                    <a href="{{ route('infos.edit',auth('web')->user()->id) }}" class="nav-link">
                        <i class="nav-icon fas fa-globe"></i>
                        <p>
                            @lang('dashboard.infos')
                        </p>
                    </a>
                </li>
                @endpermission
                @permission('structure-update')
                <li
                    class="nav-item {{in_array(request()->route()->getName(),[''])?'menu-open':''}}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>
                            @lang('dashboard.structure')
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('home-content.index') }}"
                               class="nav-link {{ in_array(request()->route()->getName(),['home-content.index'])? 'active': '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('dashboard.home_page')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('header-footer.index') }}"
                               class="nav-link {{ in_array(request()->route()->getName(),['header-footer.index'])? 'active': '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('dashboard.header_footer')</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endpermission

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
