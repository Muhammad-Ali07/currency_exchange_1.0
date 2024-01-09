<!-- BEGIN: Main Menu-->
@php
        $prefix = Request::route()->getprefix();
        $route = \Illuminate\Support\Facades\Route::current()->getName();

        $path =  \Illuminate\Support\Facades\Request::path();
        $path =  explode("/",$path);
        $path1 = isset($path[0])?$path[0]:"";
        $path2 = isset($path[1])?$path[1]:"";
        $path = $path1.'/'.$path2;

@endphp
<style>
    #accounts_nav_ul a,
    #crm_nav_ul a,
    #purchase_nav_ul a,
    #sale_nav_ul a,
    #hr_nav_ul a,
    #report_nav_ul a,
    #setting_nav_ul a
    {
        padding-left: 50px;
    }
</style>
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto"><a class="navbar-brand" href="javascript:;"><span class="brand-logo">
                            <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
                                <defs>
                                    <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                                        <stop stop-color="#000000" offset="0%"></stop>
                                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                                    </lineargradient>
                                    <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                                        <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                                    </lineargradient>
                                </defs>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                        <g id="Group" transform="translate(400.000000, 178.000000)">
                                            <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill:currentColor"></path>
                                            <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                                            <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                                            <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                                            <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                                        </g>
                                    </g>
                                </g>
                            </svg></span>
                    <h2 class="brand-text">HZ Traders</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    @php
        $sidebar_menu = '-sidebar-menu';
    @endphp
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @permission('home'.$sidebar_menu)
            <li class="nav-item {{ ($route == 'home')?'active':''}} ">
                <a class="d-flex align-items-center" href="{{ route('home') }}">
                    <i data-feather="home"></i>
                    <span class="menu-title text-truncate" data-i18n="Dashboards">Home</span>
                </a>
            </li>
            @endpermission
            @permission('company'.$sidebar_menu)
            <li class="nav-item {{ ($path == 'setting/company')?'active':'' }}">
                <a class="d-flex align-items-center" href="{{ route('setting.company.index') }}">
                    <i data-feather='briefcase'></i>
                    <span class="menu-item text-truncate">Company</span>
                </a>
            </li>
            @endpermission
            @permission('project'.$sidebar_menu)
            <li class="nav-item {{ ($path == 'setting/project')?'active':'' }}">
                <a class="d-flex align-items-center" href="{{ route('setting.project.index') }}">
                    <i data-feather='aperture'></i>
                    <span class="menu-item text-truncate">Project</span>
                </a>
            </li>
            @endpermission
            <li id="accounts_nav" class="nav-item has-sub {{ ($prefix == '/accounts')?'open':'' }}">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='book-open'></i>
                    <span class="menu-title text-truncate">Accounts</span>
                </a>
                <ul class="menu-content" id="accounts_nav_ul">
                    @permission('chart-of-account-tree'.$sidebar_menu)
                    <li class="{{ ($path == 'accounts/chart-of-account-tree')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('accounts.chart-of-account-tree.index') }}">
                            <span class="menu-item text-truncate">Chart of Account Tree</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('chart-of-account'.$sidebar_menu)
                    <li class="{{ ($path == 'accounts/chart-of-account')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('accounts.chart-of-account.index') }}">
                            <span class="menu-item text-truncate">Chart of Account</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('bank-payment'.$sidebar_menu)
                    <li class="{{ ($path == 'accounts/bank-payment')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('accounts.bank-payment.index') }}">
                            <span class="menu-item text-truncate">Bank Payment</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('bank-receive'.$sidebar_menu)
                    <li class="{{ ($path == 'accounts/bank-receive')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('accounts.bank-receive.index') }}">
                            <span class="menu-item text-truncate">Bank Receive</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('cash-payment'.$sidebar_menu)
                    <li class="{{ ($path == 'accounts/cash-payment')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('accounts.cash-payment.index') }}">
                            <span class="menu-item text-truncate">Cash Payment</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('cash-receive'.$sidebar_menu)
                    <li class="{{ ($path == 'accounts/cash-receive')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('accounts.cash-receive.index') }}">
                            <span class="menu-item text-truncate">Cash Receive</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('journal'.$sidebar_menu)
                    <li class="{{ ($path == 'accounts/journal')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('accounts.journal.index') }}">
                            <span class="menu-item text-truncate">Journal</span>
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>
            <li id="crm_nav" class="nav-item has-sub {{ ($prefix == '/crm')?'open':'' }}">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='codesandbox'></i>
                    <span class="menu-title text-truncate">CRM</span>
                </a>
                <ul class="menu-content" id="crm_nav_ul">
                    @permission('inventory'.$sidebar_menu)
                    <li class="{{ ($path == 'purchase/inventory')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('purchase.inventory.index') }}">
                            <span class="menu-item text-truncate">Inventory</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('product'.$sidebar_menu)
                    <li class="{{ ($path == 'purchase/product-property')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('purchase.product-property.index') }}">
                            <span class="menu-item text-truncate">Product Inventory</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('customer'.$sidebar_menu)
                    <li class="{{ ($path == 'sale/customer')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('sale.customer.index') }}">
                            <span class="menu-item text-truncate">Customer</span>
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>
            <li id="purchase_nav" class="nav-item has-sub {{ ($prefix == '/purchase')?'open':'' }}">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='shopping-bag'></i>
                    <span class="menu-title text-truncate">Purchase</span>
                </a>
                <ul class="menu-content" id="purchase_nav_ul">
                    @permission('category-type'.$sidebar_menu)
                    <li class="{{ ($path == 'purchase/category_types')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('purchase.category_types.index') }}">
                            <span class="menu-item text-truncate">Category Type</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('category'.$sidebar_menu)
                    <li class="{{ ($path == 'purchase/category')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('purchase.category.index') }}">
                            <span class="menu-item text-truncate">Category</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('brand'.$sidebar_menu)
                    <li class="{{ ($path == 'purchase/brand')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('purchase.brand.index') }}">
                            <span class="menu-item text-truncate">Brand</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('supplier'.$sidebar_menu)
                    <li class="{{ ($path == 'purchase/supplier')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('purchase.supplier.index') }}">
                            <span class="menu-item text-truncate">Supplier</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('manufacturer'.$sidebar_menu)
                    <li class="{{ ($path == 'purchase/manufacturer')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('purchase.manufacturer.index') }}">
                            <span class="menu-item text-truncate">Manufacturer</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('property-type'.$sidebar_menu)
                    <li class="{{ ($path == 'purchase/property-type')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('purchase.property-type.index') }}">
                            <span class="menu-item text-truncate">Property Type</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('product-variation'.$sidebar_menu)
                    <li class="{{ ($path == 'purchase/product-variation')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('purchase.product-variation.index') }}">
                            <span class="menu-item text-truncate">Product Variation</span>
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>
            <li id="sale_nav" class="nav-item has-sub {{ ($prefix == '/sale')?'open':'' }}">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='shopping-cart'></i>
                    <span class="menu-title text-truncate">Sale</span>
                </a>
                <ul class="menu-content" id="sale_nav_ul">
                    @permission('dealer'.$sidebar_menu)
                    <li class="{{ ($path == 'sale/dealer')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('sale.dealer.index') }}">
                            <span class="menu-item text-truncate">Dealer</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('sale-invoice'.$sidebar_menu)
                    <li class="{{ ($path == 'sale/sale-invoice')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('sale.sale-invoice.index') }}">
                            <span class="menu-item text-truncate">Booking</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('booking-transfer'.$sidebar_menu)
                    <li class="{{ ($path == 'sale/booking-transfer')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('sale.booking-transfer.index') }}">
                            <span class="menu-item text-truncate">Booking Transfer</span>
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>
            <li id="hr_nav" class="nav-item has-sub {{ ($prefix == '/hr')?'open':'' }}">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='users'></i>
                    <span class="menu-title text-truncate">HR</span>
                </a>
                <ul class="menu-content" id="hr_nav_ul">
                    @permission('department'.$sidebar_menu)
                    <li class="{{ ($path == 'setting/department')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('setting.department.index') }}">
                            <span class="menu-item text-truncate">Department</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('staff'.$sidebar_menu)
                    <li class="{{ ($path == 'setting/staff')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('setting.staff.index') }}">
                            <span class="menu-item text-truncate">Staff</span>
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>
            <li id="report_nav" class="nav-item has-sub {{ ($prefix == '/hr')?'open':'' }}">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='clipboard'></i>
                    <span class="menu-title text-truncate">Report</span>
                </a>
                <ul class="menu-content" id="report_nav_ul">
                    @permission('department'.$sidebar_menu)
                    <li class="{{ ($path == 'reports/Listing')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('setting.department.index') }}">
                            <span class="menu-item text-truncate">Lisitng Report</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('staff'.$sidebar_menu)
                    <li class="{{ ($path == 'reports/Inventory')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('setting.staff.index') }}">
                            <span class="menu-item text-truncate">Inventory Report</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('staff'.$sidebar_menu)
                    <li class="{{ ($path == 'reports/Purchase')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('setting.staff.index') }}">
                            <span class="menu-item text-truncate">Purchase Report</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('staff'.$sidebar_menu)
                    <li class="{{ ($path == 'reports/Sale')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('setting.staff.index') }}">
                            <span class="menu-item text-truncate">Sale Report</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('staff'.$sidebar_menu)
                    <li class="{{ ($path == 'reports/Listing')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('setting.staff.index') }}">
                            <span class="menu-item text-truncate">Accounts Report</span>
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>
            <li id="setting_nav" class="nav-item has-sub {{ ($prefix == '/setting')?'open':'' }}">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="settings"></i>
                    <span class="menu-title text-truncate">Setting</span>
                </a>
                <ul class="menu-content" id="setting_nav_ul">
                    @permission('user'.$sidebar_menu)
                    <li class="{{ ($path == 'setting/user')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('setting.user.index') }}">
                            <span class="menu-item text-truncate">User</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('country'.$sidebar_menu)
                    <li class="{{ ($path == 'setting/country')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('setting.country.index') }}">
                            <span class="menu-item text-truncate">Country</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('region'.$sidebar_menu)
                    <li class="{{ ($path == 'setting/region')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('setting.region.index') }}">
                            <span class="menu-item text-truncate">Region</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('city'.$sidebar_menu)
                    <li class="{{ ($path == 'setting/city')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('setting.city.index') }}">
                            <span class="menu-item text-truncate">City</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('user-management'.$sidebar_menu)
                    <li class="{{ ($path == 'setting/user-management')?'active':'' }}">
                        <a class="d-flex align-items-center" href="{{ route('setting.user-management.create') }}">
                            <span class="menu-item text-truncate">User Permission</span>
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>
        </ul>
    </div>
    <script>
        var main_nav_ids = [
            {
                'id':'accounts_nav',
                'nav_ul':'accounts_nav_ul',
            },
            {
                'id':'purchase_nav',
                'nav_ul':'purchase_nav_ul',
            },
            {
                'id':'sale_nav',
                'nav_ul':'sale_nav_ul',
            },
            {
                'id':'setting_nav',
                'nav_ul':'setting_nav_ul',
            },
            {
                'id':'hr_nav',
                'nav_ul':'hr_nav_ul',
            },
            {
                'id':'report_nav',
                'nav_ul':'report_nav_ul',
            },
            {
                'id':'crm_nav',
                'nav_ul':'crm_nav_ul',
            }
        ];
        main_nav_ids.forEach(function(item){
            var d = document.getElementById(item['nav_ul']).getElementsByTagName("li").length
            if(d == 0){
                document.getElementById(item['id']).remove()
            }else{
                document.getElementById(item['id']).style.display = "block";
            }
        })
    </script>
</div>
<!-- END: Main Menu-->
