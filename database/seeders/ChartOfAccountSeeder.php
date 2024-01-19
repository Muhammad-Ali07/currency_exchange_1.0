<?php

namespace Database\Seeders;


use App\Models\ChartOfAccount;
use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class ChartOfAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $charts = [
            //              ::::::::::ASSET SECTION STARTS::::::::::
            [ 'code' => '01-00-0000-0000', 'name' => 'ASSETS', 'level' => '1', 'parent_code' => 'NULL' ],

            [ 'code' => '01-01-0000-0000', 'name' => 'FIXED ASSET', 'level' => '2', 'parent_code' => '01-00-0000-0000' ],
            [ 'code' => '01-02-0000-0000', 'name' => 'CURRENT ASSET', 'level' => '2', 'parent_code' => '01-00-0000-0000' ],

            [ 'code' => '01-01-0001-0000', 'name' => 'OFFICE EQUIPMENT', 'level' => '3', 'parent_code' => '01-01-0000-0000' ],
            [ 'code' => '01-01-0002-0000', 'name' => 'PROPERTY PLANT & EQUIPMENT', 'level' => '3', 'parent_code' => '01-01-0000-0000' ],

            [ 'code' => '01-02-0001-0000', 'name' => 'CASH & CASH EQUIVALENT', 'level' => '3', 'parent_code' => '01-02-0000-0000' ],
            [ 'code' => '01-02-0002-0000', 'name' => 'ACCOUNTS RECEIVABLE', 'level' => '3', 'parent_code' => '01-02-0000-0000' ],
            [ 'code' => '01-02-0003-0000', 'name' => 'PREPAID EXPENSES', 'level' => '3', 'parent_code' => '01-02-0000-0000' ],
            [ 'code' => '01-02-0004-0000', 'name' => 'ADVANCE PAYMENTS', 'level' => '3', 'parent_code' => '01-02-0000-0000' ],
            //              ::::::::::ASSET SECTION EDNDS::::::::::

            //              ::::::::::LIABILITIES SECTION STARTS::::::::::
            [ 'code' => '02-00-0000-0000', 'name' => 'LIABILITIES', 'level' => '1', 'parent_code' => 'NULL' ],

            [ 'code' => '02-01-0000-0000', 'name' => 'CURRENT LIABILITIES', 'level' => '2', 'parent_code' => '02-00-0000-0000' ],
            [ 'code' => '02-02-0000-0000', 'name' => 'LONG LIABILITIES', 'level' => '2', 'parent_code' => '02-00-0000-0000' ],

            [ 'code' => '02-01-0001-0000', 'name' => 'ACCOUNTS PAYABLE', 'level' => '3', 'parent_code' => '02-01-0000-0000' ],
            [ 'code' => '02-01-0002-0000', 'name' => 'SHORT-TERM LOAN', 'level' => '3', 'parent_code' => '02-01-0000-0000' ],

            [ 'code' => '02-02-0001-0000', 'name' => 'LONG TERM LOAN', 'level' => '3', 'parent_code' => '02-02-0000-0000' ],
            [ 'code' => '02-02-0002-0000', 'name' => 'LEASE', 'level' => '3', 'parent_code' => '02-02-0000-0000' ],
            //              ::::::::::LIABILITIES SECTION ENDS::::::::::

            //              ::::::::::EQUITY SECTION STARTS::::::::::
            [ 'code' => '03-00-0000-0000', 'name' => 'EQUITY', 'level' => '1', 'parent_code' => 'NULL' ],

            [ 'code' => '03-01-0000-0000', 'name' => 'OWNER CAPITAL', 'level' => '2', 'parent_code' => '03-00-0000-0000' ],
            [ 'code' => '03-02-0000-0000', 'name' => 'RETAINED EARNINGS', 'level' => '2', 'parent_code' => '03-00-0000-0000' ],

            [ 'code' => '03-01-0001-0000', 'name' => 'OPENING BALANCE', 'level' => '3', 'parent_code' => '03-01-0000-0000' ],
            [ 'code' => '03-01-0002-0000', 'name' => 'LESS WITHDRAW', 'level' => '3', 'parent_code' => '03-01-0000-0000' ],

            [ 'code' => '03-02-0001-0000', 'name' => 'BALANCE C/F', 'level' => '3', 'parent_code' => '03-02-0000-0000' ],
            [ 'code' => '03-02-0002-0000', 'name' => 'ADD/LESS - INCOME OF CURRENT PERIOD', 'level' => '3', 'parent_code' => '03-02-0000-0000' ],
            //              ::::::::::EQUITY SECTION ENDS::::::::::

            //              ::::::::::REVENUE SECTION STARTS::::::::::
            [ 'code' => '04-00-0000-0000', 'name' => 'REVENUE', 'level' => '1', 'parent_code' => 'NULL' ],

            [ 'code' => '04-01-0000-0000', 'name' => 'DIRECT SALES', 'level' => '2', 'parent_code' => '04-00-0000-0000' ], // CUSTOMERS
            [ 'code' => '04-02-0000-0000', 'name' => 'OTHER', 'level' => '2', 'parent_code' => '04-00-0000-0000' ],

            [ 'code' => '04-01-0001-0000', 'name' => 'PKR SALES', 'level' => '3', 'parent_code' => '04-01-0000-0000' ],
            [ 'code' => '04-01-0002-0000', 'name' => 'AED SALES', 'level' => '3', 'parent_code' => '04-01-0000-0000' ],
            [ 'code' => '04-01-0003-0000', 'name' => 'EURO SALES', 'level' => '3', 'parent_code' => '04-01-0000-0000' ],
            [ 'code' => '04-01-0004-0000', 'name' => 'DOLLAR SALES', 'level' => '3', 'parent_code' => '04-01-0000-0000' ],
            [ 'code' => '04-01-0005-0000', 'name' => 'TRY SALES', 'level' => '3', 'parent_code' => '04-01-0000-0000' ],
            [ 'code' => '04-01-0006-0000', 'name' => 'CUSTOMERS', 'level' => '3', 'parent_code' => '04-01-0000-0000' ],

            [ 'code' => '04-02-0001-0000', 'name' => 'OTHER INCOME', 'level' => '3', 'parent_code' => '04-02-0000-0000' ],
            [ 'code' => '04-02-0002-0000', 'name' => 'COMMISSIONS', 'level' => '3', 'parent_code' => '04-02-0000-0000' ],
            //              ::::::::::REVENUE SECTION ENDS::::::::::

            //              ::::::::::EXPENSE SECTION STARTS::::::::::
            [ 'code' => '05-00-0000-0000', 'name' => 'EXPENSES', 'level' => '1', 'parent_code' => 'NULL' ],

            [ 'code' => '05-01-0000-0000', 'name' => 'COST OF GOOD SOLD', 'level' => '2', 'parent_code' => '05-00-0000-0000' ],
            [ 'code' => '05-02-0000-0000', 'name' => 'ADMINISTRATIVE EXPENSES', 'level' => '2', 'parent_code' => '05-00-0000-0000' ],
            [ 'code' => '05-03-0000-0000', 'name' => 'FINANCIAL EXPENSES', 'level' => '2', 'parent_code' => '05-00-0000-0000' ],

            [ 'code' => '05-01-0001-0000', 'name' => 'OPENING STOCK', 'level' => '3', 'parent_code' => '05-01-0000-0000' ],
            [ 'code' => '05-01-0002-0000', 'name' => 'PURCHASE', 'level' => '3', 'parent_code' => '05-01-0000-0000' ],
            [ 'code' => '05-01-0003-0000', 'name' => 'CLOSING INVENTORY', 'level' => '3', 'parent_code' => '05-01-0000-0000' ],
            [ 'code' => '05-01-0004-0000', 'name' => 'CHARGES', 'level' => '3', 'parent_code' => '05-01-0000-0000' ],

            [ 'code' => '05-02-0001-0000', 'name' => 'SALARY & WAGES', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0002-0000', 'name' => 'REMUNERATION', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0003-0000', 'name' => 'OFFICE RENT', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0004-0000', 'name' => 'HOUSE RENT', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0005-0000', 'name' => 'WATER BILL', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0006-0000', 'name' => 'ELECTRICITY BILL', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0007-0000', 'name' => 'POSTAGE, PRINTING, STATIONARY', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0008-0000', 'name' => 'TELEPHONE/MOBILE BILL', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0009-0000', 'name' => 'CLEANING & WASTE BILL', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0010-0000', 'name' => 'PREOFESSION FEE', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0011-0000', 'name' => 'MARKETING & ADVERTISEMENT', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0012-0000', 'name' => 'INSURANCE PREMIUM', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0013-0000', 'name' => 'LICENSE & RENEWAL', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0014-0000', 'name' => 'REPAIR & MAINTENANCE', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0015-0000', 'name' => 'EQUIPMENT & TOOL PURCHASE', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0016-0000', 'name' => 'DEPRICIATION & AMORTIZATION', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0017-0000', 'name' => 'VENDORS', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],

            [ 'code' => '05-03-0001-0000', 'name' => 'BANK CHARGES', 'level' => '3', 'parent_code' => '05-03-0000-0000' ],
            [ 'code' => '05-03-0002-0000', 'name' => 'CREDIT CARD CHARGES', 'level' => '3', 'parent_code' => '05-03-0000-0000' ],
            [ 'code' => '05-03-0003-0000', 'name' => 'FOREIGN EX ADJ(GAIN/LOSS)', 'level' => '3', 'parent_code' => '05-03-0000-0000' ],
            //              ::::::::::EXPENSE SECTION ENDS::::::::::

            // [ 'code' => '06-00-0000-0000', 'name' => 'INVESTMENTS', 'level' => '1', 'parent_code' => 'NULL' ],
            // [ 'code' => '06-01-0000-0000', 'name' => 'INVESTMENTS', 'level' => '2', 'parent_code' => '05-00-0000-0000' ],
            // [ 'code' => '06-01-0001-0000', 'name' => 'SHARE INVESTMENT A/C', 'level' => '3', 'parent_code' => '05-01-0000-0000' ],
            // [ 'code' => '06-01-0001-0001', 'name' => 'NEW PROJECT - PALM VILLAS', 'level' => '4', 'parent_code' => '05-01-0001-0000' ],
            // [ 'code' => '06-01-0001-0002', 'name' => 'NEW PROJECT - GAWADAR', 'level' => '4', 'parent_code' => '05-01-0001-0000' ],

            // [ 'code' => '07-00-0000-0000', 'name' => 'DIRECT INCOME', 'level' => '1', 'parent_code' => 'NULL' ],
            // [ 'code' => '07-01-0000-0000', 'name' => 'NET SALES', 'level' => '2', 'parent_code' => '07-00-0000-0000' ],
            // [ 'code' => '07-01-0001-0000', 'name' => 'SALES', 'level' => '3', 'parent_code' => '07-01-0000-0000' ],
            // [ 'code' => '07-02-0000-0000', 'name' => 'INDIRECT INCOMES', 'level' => '2', 'parent_code' => '07-00-0000-0000' ],
            // [ 'code' => '07-02-001-0000', 'name' => 'OTHER INCOME', 'level' => '3', 'parent_code' => '07-02-0000-0000' ],
            // [ 'code' => '07-02-0002-0000', 'name' => 'RENT RECEIVED', 'level' => '3', 'parent_code' => '07-02-0000-0000' ],

            // [ 'code' => '08-00-0000-0000', 'name' => 'COST OF GOODS SOLD', 'level' => '1', 'parent_code' => 'NULL' ],
            // [ 'code' => '08-01-0000-0000', 'name' => 'NET PURCHASES', 'level' => '2', 'parent_code' => '08-00-0000-0000' ],
            // [ 'code' => '08-01-0001-0000', 'name' => 'PURCHASES', 'level' => '3', 'parent_code' => '08-01-0000-0000' ],
            // [ 'code' => '08-01-0002-0000', 'name' => 'PURCHASE RETURNS', 'level' => '3', 'parent_code' => '08-01-0000-0000' ],
            // [ 'code' => '08-01-0003-0000', 'name' => 'PURCHASES RELATED EXPENSES', 'level' => '3', 'parent_code' => '08-01-0000-0000' ],
            // [ 'code' => '08-02-0000-0000', 'name' => 'OPENING STOCK', 'level' => '2', 'parent_code' => '08-00-0000-0000' ],
            // [ 'code' => '08-02-0001-0000', 'name' => 'OPENING STOCK', 'level' => '3', 'parent_code' => '08-02-0000-0000' ],

            // [ 'code' => '09-00-0000-0000', 'name' => 'GENERAL & ADMINISTRATIVE EXPENSE', 'level' => '1', 'parent_code' => 'NULL' ],
            // [ 'code' => '09-01-0000-0000', 'name' => 'MARKEETING EXPENSE', 'level' => '2', 'parent_code' => '09-00-0000-0000' ],
            // [ 'code' => '09-01-0001-0000', 'name' => 'ADMINISTRATIVE EXPENSES', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            // [ 'code' => '09-01-0002-0000', 'name' => 'STAFF SALARY', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            // [ 'code' => '09-01-0003-0000', 'name' => 'RENT', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            // [ 'code' => '09-01-0004-0000', 'name' => 'ADVERTISING & SALES PROMOTION', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            // [ 'code' => '09-01-0005-0000', 'name' => 'INSURANCE', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            // [ 'code' => '09-01-0006-0000', 'name' => 'VEHICLE EXPENSES', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            // [ 'code' => '09-01-0007-0000', 'name' => 'REPAIRS & MAINTENANCE', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            // [ 'code' => '09-01-0009-0000', 'name' => 'INTEREST & BANK CHARGES', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            // [ 'code' => '09-01-0011-0000', 'name' => 'ELECTRICITY & WATER', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            // [ 'code' => '09-01-0012-0000', 'name' => 'POST TELEPHONE FAX & INTERNET', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            // [ 'code' => '09-01-0013-0000', 'name' => 'PRINTING AND STATIONARY EXPENSES', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            // [ 'code' => '09-01-0014-0000', 'name' => 'TAX', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
        ];

        $comp = Company::first();
        // $project = Project::first();
        $user = User::first();
        foreach ($charts as $chart){

            if(!ChartOfAccount::where('code',$chart['code'])->exists()){
                $parent_account_id = NULL;
                $parent_account_code = NULL;
                $parent = ChartOfAccount::where('code',$chart['parent_code'])->first();
                if(!empty($parent)){
                    $parent_account_id = $parent->id;
                    $parent_account_code = $parent->code;
                }
                ChartOfAccount::create([
                    'uuid' => Uuid::generate()->string,
                    'name' => ucwords(strtolower(strtoupper($chart['name']))),
                    'code' => $chart['code'],
                    'level' => $chart['level'],
                    'group' => ($chart['level'] == 1)?'G':'D',
                    'parent_account_id' => $parent_account_id,
                    'parent_account_code' => $parent_account_code,
                    'status' => 1,
                    'company_id' => $comp->id,
                    'project_id' => 1,
                    'branch_id' => 1,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
