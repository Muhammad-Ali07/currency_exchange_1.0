<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Accounts\ChartOfAccountTreeController;
use App\Http\Controllers\Accounts\ChartOfAccountController;
use App\Http\Controllers\Accounts\BankPaymentController;
use App\Http\Controllers\Accounts\BankReceiveController;
use App\Http\Controllers\Accounts\CashPaymentController;
use App\Http\Controllers\Accounts\CashReceiveController;
use App\Http\Controllers\Accounts\JournalController;
use App\Http\Controllers\Accounts\OpeningBalanceController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Setting\CountryController;
use App\Http\Controllers\Setting\RegionController;
use App\Http\Controllers\Setting\CityController;
use App\Http\Controllers\Setting\CompanyController;
use App\Http\Controllers\Setting\ProjectController;
use App\Http\Controllers\Setting\DepartmentController;
use App\Http\Controllers\Setting\StaffController;
use App\Http\Controllers\Setting\ProfileController;
use App\Http\Controllers\Setting\UserManagementSystemController;
use App\Http\Controllers\Setting\UserController;
use App\Http\Controllers\Purchase\CategoryTypeController;
use App\Http\Controllers\Purchase\CategoryController;
use App\Http\Controllers\Purchase\BrandController;
use App\Http\Controllers\Purchase\ManufacturerController;
use App\Http\Controllers\Purchase\SupplierController;
use App\Http\Controllers\Purchase\InventoryController;
use App\Http\Controllers\Purchase\ProductPropertyController;
use App\Http\Controllers\Purchase\BuyableTypeController;
use App\Http\Controllers\Purchase\ProductVariationController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Sale\BookingTransferController;
use App\Http\Controllers\Sale\DealerController;
use App\Http\Controllers\Sale\CustomerController;
use App\Http\Controllers\Sale\ProductController;
use App\Http\Controllers\Sale\SaleInvoiceController;
use App\Http\Controllers\Setting\BranchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    }else {
        return view('auth.login');
    }
});

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();
Route::prefix('password')->name('password.')->group(function () {
    Route::get('request-email', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('show_form');
    Route::post('email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('email');
    Route::get('reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('forgetPassword');
    Route::post('reset', [ResetPasswordController::class, 'reset'])->name('update');

});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/project-list', [HomeController::class,'projectList'])->name('projectList');
    Route::post('/store-default-project', [HomeController::class,'defaultProjectStore'])->name('defaultProjectStore');
    Route::post('/store-default-branch', [HomeController::class,'defaultBranchStore'])->name('defaultBranchStore');

    // Route::group(['middleware' => ['checkBranch']], function () {

        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::post('/branch', [HomeController::class, 'branchStore'])->name('branchStore');

        Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {
            Route::get('edit', 'edit')->name('edit');
            Route::post('update','update')->name('update');
        });
        Route::prefix('help')->name('help.')->group(function () {
            Route::get('chart/{str?}', [HelpController::class, 'chart'])->name('chart');
            Route::get('customer/{str?}', [HelpController::class, 'customer'])->name('customer');
            Route::get('oldCustomerHelp/{str?}', [HelpController::class, 'oldCustomerHelp'])->name('oldCustomerHelp');
            Route::get('property-product/{str?}', [HelpController::class, 'propertyProduct'])->name('propertyProduct');
            // Route::get('product/{str?}', [HelpController::class, 'product'])->name('product');
            Route::get('productHelp', [HelpController::class, 'productHelp'])->name('product');
            Route::get('toProductHelp', [HelpController::class, 'toProductHelp'])->name('to_product');
            Route::get('transactionTypeHelp', [HelpController::class, 'transactionTypeHelp'])->name('transactionType');

            Route::get('supplier/{str?}', [HelpController::class, 'supplier'])->name('supplier');
            // Route::get('reportChart/{str?}', [HelpController::class, 'reportChart'])->name('reportChart');

            Route::get('currencyChartHelp/{str?}', [HelpController::class, 'currencyChartHelp'])->name('currency');
            Route::get('bankCurrencyChartHelp/{str?}', [HelpController::class, 'bankCurrencyChartHelp'])->name('currency');
            Route::get('bankCurrencyHelp/{str?}', [HelpController::class, 'bankCurrencyHelp'])->name('bankCurrencyHelp');
            Route::get('cashCurrencyHelp/{str?}', [HelpController::class, 'cashCurrencyHelp'])->name('cashCurrencyHelp');
            Route::get('buyCashCurrencyHelp/{str?}', [HelpController::class, 'buyCashCurrencyHelp'])->name('buyCashCurrencyHelp');
            Route::get('chartVoucherHelp/{str?}', [HelpController::class, 'chartVoucherHelp'])->name('chartVoucherHelp');


        });

        Route::prefix('accounts')->name('accounts.')->group(function () {
            //  Route::prefix('chart-of-account-tree')->resource('chart-of-account-tree', ChartOfAccountTreeController::class);
            Route::prefix('chart-of-account-tree')->name('chart-of-account-tree.')->controller(ChartOfAccountTreeController::class)->group(function(){
                Route::get('/', 'index')->name('index');
                Route::get('get-chart-of-account-tree', 'getChartOfAccountTree')->name('getChartOfAccountTree');
            });
            Route::prefix('chart-of-account')->resource('chart-of-account', ChartOfAccountController::class);
            Route::prefix('chart-of-account')->name('chart-of-account.')->controller(ChartOfAccountController::class)->group(function(){
                Route::post('get-parent-coa', 'getParentCoaList')->name('getParentCoaList');
                Route::post('get-code-by-parent-account', 'getChildCodeByParentAccount')->name('getChildCodeByParentAccount');

            });
            Route::prefix('opening-balance')->name('opening-balance.')->controller(OpeningBalanceController::class)->group(function(){
                Route::get('print/{id}', 'printView')->name('print');
                Route::get('revert-list', 'revertList')->name('revertList');
                Route::post('revert/{id}', 'revert')->name('revert');
            });
            Route::prefix('opening-balance')->resource('opening-balance', OpeningBalanceController::class);

            Route::prefix('bank-payment')->name('bank-payment.')->controller(BankPaymentController::class)->group(function(){
                Route::get('print/{id}', 'printView')->name('print');
                Route::get('revert-list', 'revertList')->name('revertList');
                Route::post('revert/{id}', 'revert')->name('revert');
            });
            Route::prefix('bank-payment')->resource('bank-payment', BankPaymentController::class);

            Route::prefix('bank-receive')->name('bank-receive.')->controller(BankReceiveController::class)->group(function(){
                Route::get('print/{id}', 'printView')->name('print');
                Route::get('revert-list', 'revertList')->name('revertList');
                Route::post('revert/{id}', 'revert')->name('revert');
            });
            Route::prefix('bank-receive')->resource('bank-receive', BankReceiveController::class);

            Route::prefix('cash-payment')->name('cash-payment.')->controller(CashPaymentController::class)->group(function(){
                Route::get('print/{id}', 'printView')->name('print');
                Route::get('revert-list', 'revertList')->name('revertList');
                Route::post('revert/{id}', 'revert')->name('revert');
            });
            Route::prefix('cash-payment')->resource('cash-payment', CashPaymentController::class);

            Route::prefix('cash-receive')->name('cash-receive.')->controller(CashReceiveController::class)->group(function(){
                Route::get('print/{id}', 'printView')->name('print');
                Route::get('revert-list', 'revertList')->name('revertList');
                Route::post('revert/{id}', 'revert')->name('revert');
            });
            Route::prefix('cash-receive')->resource('cash-receive', CashReceiveController::class);

            Route::prefix('journal')->name('journal.')->controller(JournalController::class)->group(function(){
                Route::get('print/{id}', 'printView')->name('print');
                Route::get('revert-list', 'revertList')->name('revertList');
                Route::post('revert/{id}', 'revert')->name('revert');
            });
            Route::prefix('journal')->resource('journal', JournalController::class);

        });

        Route::prefix('setting')->name('setting.')->group(function () {
            Route::prefix('region')->name('region.')->controller(RegionController::class)->group(function(){
                Route::post('get-regions-by-country', 'getRegionsByCountry')->name('getRegionsByCountry');
            });
            // Route::prefix('city')->resource('city', CityController::class);
            Route::prefix('city')->name('city.')->controller(CityController::class)->group(function(){
                Route::post('get-city-by-region', 'getCityByRegion')->name('getCityByRegion');
            });
            Route::prefix('company')->resource('company', CompanyController::class);
            Route::prefix('user')->resource('user', UserController::class);
            // Route::prefix('branch')->resource('branch', ProjectController::class);
            Route::prefix('branch')->resource('branch', BranchController::class);


            Route::prefix('user-management')->name('user-management.')->group(function () {
                Route::get('form/{id?}', [UserManagementSystemController::class, 'create'])->name('create');
                Route::post('form/{id?}', [UserManagementSystemController::class, 'store'])->name('store');
            });
        });

        Route::prefix('reports')->name('reports.')->group(function () {
            // customer report
            Route::prefix('customer')->name('customer.')->controller(ReportController::class)->group(function(){
                Route::get('ledger', 'customerLedger')->name('ledger');
                Route::post('cstLedgerReport', 'customerLedgerReport')->name('store');
            });
            // Supplier Ledger
            Route::prefix('supplier')->name('supplier.')->controller(ReportController::class)->group(function(){
                Route::get('ledger', 'supplierLedger')->name('ledger');
                Route::post('spLedgerReport', 'supplierLedgerReport')->name('store');
            });

            // cash currency report
            Route::prefix('currency')->name('currency.')->controller(ReportController::class)->group(function(){
                Route::get('ledger', 'currencyLedger')->name('ledger');
                Route::post('currencyLedgerReport', 'currencyLedgerReport')->name('currencyLedgerReport');
            });
            // bank currency report
            Route::prefix('bank_currency')->name('bank_currency.')->controller(ReportController::class)->group(function(){
                Route::get('ledger', 'bankCurrencyLedger')->name('ledger');
                Route::post('bankCurrencyLedgerReport', 'bankCurrencyLedgerReport')->name('currencyLedgerReport');
            });

            Route::prefix('vouchers')->name('vouchers.')->controller(ReportController::class)->group(function(){
                Route::get('list', 'vouchersList')->name('list');
                Route::post('voucherLedger', 'voucherLedger')->name('voucherLedger');
            });
        });

        Route::prefix('master')->name('master.')->group(function () {
            Route::prefix('product')->resource('product', ProductController::class);
            Route::prefix('customer')->resource('customer', CustomerController::class);
            Route::prefix('supplier')->resource('supplier', SupplierController::class);
            Route::prefix('product-quantity')->resource('product-quantity', ProductPropertyController::class);
        });
        Route::prefix('transaction')->name('transaction.')->group(function () {
            Route::prefix('sale')->resource('sale', SaleInvoiceController::class);
            Route::prefix('cash-chart')->name('cash-chart.')->controller(SaleInvoiceController::class)->group(function(){
                Route::post('get-cash-cash', 'getCashChart')->name('getCashChart');
                Route::post('get-product-detail', 'getProductQtyDtl')->name('getProductQtyDtl');
                // Route::get('print/{id}', 'printView')->name('print');
                // Route::post('get-cash-chart-id', 'getCashChart')->name('getCashChart');
            });
            Route::prefix('utilities')->name('utilities.')->controller(SaleInvoiceController::class)->group(function(){
                Route::post('get-cst-vouchers', 'getCstVouchers')->name('getCstVouchers');
            });

            // Route::prefix('product')->resource('sale', ProductController::class);
            // Route::prefix('customer')->resource('customer', CustomerController::class);
            // Route::prefix('supplier')->resource('supplier', SupplierController::class);
            // Route::prefix('product-quantity')->resource('product-quantity', ProductPropertyController::class);
        });

        Route::prefix('purchase')->name('purchase.')->group(function () {
            // Route::prefix('category_types')->resource('category_types', CategoryTypeController::class);
            // Route::prefix('category')->resource('category', CategoryController::class);
            Route::prefix('category')->name('category.')->controller(CategoryController::class)->group(function(){
                Route::post('get-child-by-parent', 'getChildByParentCategory')->name('getChildByParentCategory');
            });
            // Route::prefix('brand')->resource('brand', BrandController::class);
            // Route::prefix('manufacturer')->resource('manufacturer', ManufacturerController::class);
            // Route::prefix('inventory')->resource('inventory', InventoryController::class);
            // Route::prefix('product-property')->resource('product-property', ProductPropertyController::class);
            // Route::prefix('property-type')->resource('property-type', BuyableTypeController::class);
            // Route::prefix('product-variation')->resource('product-variation', ProductVariationController::class);
            // Route::prefix('product-variation')->name('product-variation.')->controller(ProductVariationController::class)->group(function(){
                //     Route::post('get-product-variation-by-buyable-type', 'getProductVariations')->name('getProductVariations');
                // });

            });

            Route::prefix('invoice')->name('invoice.')->group(function () {
                // Route::prefix('dealer')->resource('dealer', DealerController::class);
                // Route::prefix('product-property')->resource('product-property', ProductPropertyController::class);
                // Route::prefix('sale')->resource('sale', SaleInvoiceController::class);
                // Route::prefix('purchase')->resource('purchase', SaleInvoiceController::class);
                // Route::prefix('return')->resource('return', SaleInvoiceController::class);

            // Route::prefix('booking-transfer')->resource('booking-transfer', BookingTransferController::class);
            // Route::prefix('booking-transfer')->name('booking-transfer.')->controller(BookingTransferController::class)->group(function(){
            //     Route::post('get-customer-list', 'getCustomerList')->name('getCustomerList');
            //     Route::post('get-booking-detail', 'getBookingDtl')->name('getBookingDtl');
            //     Route::get('print/{id}', 'printView')->name('print');
            // });
        });
        Route::prefix('ajax')->name('ajax.')->group(function () {
            Route::get('getCode/{form_type?}', [AjaxController::class, 'getCode'])->name('getCode');

            // Route::prefix('sale-invoice')->name('sale-invoice.')->controller(SaleInvoiceController::class)->group(function(){
            //     Route::post('get-seller-list', 'getSellerList')->name('getSellerList');
            //     Route::post('get-product-detail', 'getProductDetail')->name('getProductDetail');
            //     Route::get('print/{id}', 'printView')->name('print');
            // });
        });
    // });
});
