<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">
            <li class="nav-item">
                <a href="{{ route("admin.home") }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt">

                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>


            @if(getSiteID() > 0)
                @can('blog_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.blogs.index") }}" class="nav-link {{ request()->is('admin/blogs') || request()->is('admin/blogs/*') ? 'active' : '' }}">
                            <i class="fa-fw fab fa-blogger-b nav-icon">

                            </i>
                            {{ trans('cruds.blog.title') }}
                        </a>
                    </li>
                @endcan
                @can('category_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.categories.index") }}" class="nav-link {{ request()->is('admin/categories') || request()->is('admin/categories/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs nav-icon">

                            </i>
                            {{ trans('cruds.category.title') }}
                        </a>
                    </li>
                @endcan
                @can('store_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.stores.index") }}" class="nav-link {{ request()->is('admin/stores') || request()->is('admin/stores/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs nav-icon">

                            </i>
                            {{ trans('cruds.store.title') }}
                        </a>
                    </li>
                @endcan
                @can('coupon_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.coupons.index") }}" class="nav-link {{ request()->is('admin/coupons') || request()->is('admin/coupons/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs nav-icon">

                            </i>
                            {{ trans('cruds.coupon.title') }}
                        </a>
                    </li>
                @endcan
                @can('event_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.events.index") }}" class="nav-link {{ request()->is('admin/events') || request()->is('admin/events/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs nav-icon">

                            </i>
                            {{ trans('cruds.event.title') }}
                        </a>
                    </li>
                @endcan
                @can('site_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.sites.index") }}" class="nav-link {{ request()->is('admin/sites') || request()->is('admin/sites/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs nav-icon">

                            </i>
                            {{ trans('cruds.site.title') }}
                        </a>
                    </li>
                @endcan
                @can('page_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.pages.index") }}" class="nav-link {{ request()->is('admin/pages') || request()->is('admin/pages/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs nav-icon">

                            </i>
                            {{ trans('cruds.page.title') }}
                        </a>
                    </li>
                @endcan
                @can('press_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.presses.index") }}" class="nav-link {{ request()->is('admin/presses') || request()->is('admin/presses/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs nav-icon">

                            </i>
                            {{ trans('cruds.press.title') }}
                        </a>
                    </li>
                @endcan
                @can('product_category_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.product-categories.index") }}" class="nav-link {{ request()->is('admin/product-categories') || request()->is('admin/product-categories/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs nav-icon">

                            </i>
                            {{ trans('cruds.productCategory.title') }}
                        </a>
                    </li>
                @endcan
                @can('product_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.products.index") }}" class="nav-link {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs nav-icon">

                            </i>
                            {{ trans('cruds.product.title') }}
                        </a>
                    </li>
                @endcan
                @can('banner_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.banners.index") }}" class="nav-link {{ request()->is('admin/banners') || request()->is('admin/banners/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs nav-icon">

                            </i>
                            {{ trans('cruds.banner.title') }}
                        </a>
                    </li>
                @endcan
                @can('tag_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.tags.index") }}" class="nav-link {{ request()->is('admin/tags') || request()->is('admin/tags/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs nav-icon">

                            </i>
                            {{ trans('cruds.tag.title') }}
                        </a>
                    </li>
                @endcan
                @can('network_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.networks.index") }}" class="nav-link {{ request()->is('admin/networks') || request()->is('admin/networks/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs nav-icon">

                            </i>
                            {{ trans('cruds.network.title') }}
                        </a>
                    </li>
                @endcan
                @can('addspace_store_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.addspace-stores.index") }}" class="nav-link {{ request()->is('admin/addspace-stores') || request()->is('admin/addspace-stores/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs nav-icon">

                            </i>
                            {{ trans('cruds.addspaceStore.title') }}
                        </a>
                    </li>
                @endcan
                @can('add_space_product_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.add-space-products.index") }}" class="nav-link {{ request()->is('admin/add-space-products') || request()->is('admin/add-space-products/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs nav-icon">

                            </i>
                            {{ trans('cruds.addSpaceProduct.title') }}
                        </a>
                    </li>
                @endcan
                @can('audit_log_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.audit-logs.index") }}" class="nav-link {{ request()->is('admin/audit-logs') || request()->is('admin/audit-logs/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-file-alt nav-icon">

                            </i>
                            {{ trans('cruds.auditLog.title') }}
                        </a>
                    </li>
                @endcan
                @can('subscriber_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.subscribers.index") }}" class="nav-link {{ request()->is('admin/subscribers') || request()->is('admin/subscribers/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs nav-icon">

                            </i>
                            {{ trans('cruds.subscriber.title') }}
                        </a>
                    </li>
                @endcan

                <li class="nav-item">
                    <a href="{{ route("admin.contacts.index") }}" class="nav-link {{ request()->is('admin/contacts') || request()->is('admin/contacts/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-cogs nav-icon">

                        </i>
                        Contact Us
                    </a>
                </li>

                @can('user_management_access')
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link  nav-dropdown-toggle" href="#">
                            <i class="fa-fw fas fa-users nav-icon">

                            </i>
                            {{ trans('cruds.userManagement.title') }}
                        </a>
                        <ul class="nav-dropdown-items">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-unlock-alt nav-icon">

                                        </i>
                                        {{ trans('cruds.permission.title') }}
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-briefcase nav-icon">

                                        </i>
                                        {{ trans('cruds.role.title') }}
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-user nav-icon">

                                        </i>
                                        {{ trans('cruds.user.title') }}
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
            @endif

            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>


        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
