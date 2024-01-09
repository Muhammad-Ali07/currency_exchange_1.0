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
            [ 'code' => '01-00-0000-0000', 'name' => 'CAPITAL & RESERVES', 'level' => '1', 'parent_code' => 'NULL' ],
            [ 'code' => '01-01-0000-0000', 'name' => 'CAPITAL GROUP A/C', 'level' => '2', 'parent_code' => '01-00-0000-0000' ],
            [ 'code' => '01-01-0001-0000', 'name' => 'ABDULLAH GROUP', 'level' => '3', 'parent_code' => '01-01-0000-0000' ],
            [ 'code' => '01-01-0002-0000', 'name' => 'RE PURCHASE SHARE', 'level' => '3', 'parent_code' => '01-01-0000-0000' ],
            [ 'code' => '01-02-0000-0000', 'name' => 'LOANS', 'level' => '2', 'parent_code' => '01-00-0000-0000' ],
            [ 'code' => '01-02-0001-0000', 'name' => 'LOANS', 'level' => '3', 'parent_code' => '01-02-0000-0000' ],
            [ 'code' => '01-03-0000-0000', 'name' => 'CASH CAPITAL', 'level' => '2', 'parent_code' => '01-00-0000-0000' ],
            [ 'code' => '01-03-0001-0000', 'name' => 'CASH CAPITAL', 'level' => '3', 'parent_code' => '01-03-0000-0000' ],
            [ 'code' => '02-00-0000-0000', 'name' => 'LONG TERMS LIABILITIES', 'level' => '1', 'parent_code' => 'NULL' ],
            [ 'code' => '03-00-0000-0000', 'name' => 'CURRENT LIABILITIES', 'level' => '1', 'parent_code' => 'NULL' ],
            [ 'code' => '03-01-0000-0000', 'name' => 'SUPPLIERS', 'level' => '2', 'parent_code' => '03-00-0000-0000' ],
            [ 'code' => '03-01-0001-0000', 'name' => 'SUPPLIERS', 'level' => '3', 'parent_code' => '03-01-0000-0000' ],
            [ 'code' => '03-02-0000-0000', 'name' => 'OTHER PAYABLE', 'level' => '2', 'parent_code' => '03-00-0000-0000' ],
            [ 'code' => '03-02-0001-0000', 'name' => 'BILLS PAYABLE', 'level' => '3', 'parent_code' => '03-02-0000-0000' ],
            [ 'code' => '03-02-0002-0000', 'name' => 'ACCOUNTS PAYABLE', 'level' => '3', 'parent_code' => '03-02-0000-0000' ],
            [ 'code' => '03-02-0003-0000', 'name' => 'PROVISION FOR STAFF BENEFITS', 'level' => '3', 'parent_code' => '03-02-0000-0000' ],
            [ 'code' => '03-02-0004-0000', 'name' => 'CAPITAL RESERVE', 'level' => '3', 'parent_code' => '03-02-0000-0000' ],
            [ 'code' => '03-02-0005-0000', 'name' => 'PROVISION FOR TAXATION', 'level' => '3', 'parent_code' => '03-02-0000-0000' ],
            [ 'code' => '03-02-0006-0000', 'name' => 'RETAINED EARNINGS', 'level' => '3', 'parent_code' => '03-02-0000-0000' ],
            [ 'code' => '03-02-0007-0000', 'name' => 'PAYABLE TAX', 'level' => '3', 'parent_code' => '03-02-0000-0000' ],
            [ 'code' => '03-03-0000-0000', 'name' => 'DEALER', 'level' => '2', 'parent_code' => '03-00-0000-0000' ],
            [ 'code' => '03-03-0001-0000', 'name' => 'DEALER', 'level' => '3', 'parent_code' => '03-03-0000-0000' ],
            [ 'code' => '03-04-0000-0000', 'name' => 'STAFF', 'level' => '2', 'parent_code' => '03-00-0000-0000' ],
            [ 'code' => '03-04-0001-0000', 'name' => 'STAFF', 'level' => '3', 'parent_code' => '03-04-0000-0000' ],
            [ 'code' => '04-00-0000-0000', 'name' => 'ASSETS', 'level' => '1', 'parent_code' => 'NULL' ],
            [ 'code' => '04-01-0000-0000', 'name' => 'FIXED ASSETS', 'level' => '2', 'parent_code' => '04-00-0000-0000' ],
            [ 'code' => '04-01-0001-0000', 'name' => 'BUILDING A/C', 'level' => '3', 'parent_code' => '04-01-0000-0000' ],
            [ 'code' => '04-01-0002-0000', 'name' => 'VEHICLE A/C', 'level' => '3', 'parent_code' => '04-01-0000-0000' ],
            [ 'code' => '04-01-0003-0000', 'name' => 'COLD STORAGE A/C', 'level' => '3', 'parent_code' => '04-01-0000-0000' ],
            [ 'code' => '04-01-0004-0000', 'name' => 'OFFICE EQUIPMENT A/C', 'level' => '3', 'parent_code' => '04-01-0000-0000' ],
            [ 'code' => '04-01-0005-0000', 'name' => 'FURNITURE & FITTINGS A/C', 'level' => '3', 'parent_code' => '04-01-0000-0000' ],
            [ 'code' => '04-01-0006-0000', 'name' => 'LAND', 'level' => '3', 'parent_code' => '04-01-0000-0000' ],
            [ 'code' => '05-00-0000-0000', 'name' => 'INVESTMENTS', 'level' => '1', 'parent_code' => 'NULL' ],
            [ 'code' => '05-01-0000-0000', 'name' => 'INVESTMENTS', 'level' => '2', 'parent_code' => '05-00-0000-0000' ],
            [ 'code' => '05-01-0001-0000', 'name' => 'SHARE INVESTMENT A/C', 'level' => '3', 'parent_code' => '05-01-0000-0000' ],
            [ 'code' => '05-01-0001-0001', 'name' => 'NEW PROJECT - PALM VILLAS', 'level' => '4', 'parent_code' => '05-01-0001-0000' ],
            [ 'code' => '05-01-0001-0002', 'name' => 'NEW PROJECT - GAWADAR', 'level' => '4', 'parent_code' => '05-01-0001-0000' ],
            [ 'code' => '06-00-0000-0000', 'name' => 'CURRENT ASSETS', 'level' => '1', 'parent_code' => 'NULL' ],
            [ 'code' => '06-01-0000-0000', 'name' => 'STOCK', 'level' => '2', 'parent_code' => '06-00-0000-0000' ],
            [ 'code' => '06-01-0001-0000', 'name' => 'STOCK A/C', 'level' => '3', 'parent_code' => '06-01-0000-0000' ],
            [ 'code' => '06-03-0000-0000', 'name' => 'TRADE RECEIVABLES', 'level' => '2', 'parent_code' => '06-00-0000-0000' ],
            [ 'code' => '06-03-0001-0000', 'name' => 'PALM VILAS CUSTOMERS', 'level' => '3', 'parent_code' => '06-03-0000-0000' ],
            [ 'code' => '06-03-0002-0000', 'name' => 'GAWADAR CUSTOMERS', 'level' => '3', 'parent_code' => '06-03-0000-0000' ],
            [ 'code' => '06-03-0003-0000', 'name' => 'RENTAL PARTIES', 'level' => '3', 'parent_code' => '06-03-0000-0000' ],
            [ 'code' => '06-06-0000-0000', 'name' => 'CASH AND BANK GROUP A/C', 'level' => '2', 'parent_code' => '06-00-0000-0000' ],
            [ 'code' => '06-06-0001-0000', 'name' => 'CASH GROUP A/C', 'level' => '3', 'parent_code' => '06-06-0000-0000' ],
            [ 'code' => '06-06-0002-0000', 'name' => 'BANK GROUP A/C', 'level' => '3', 'parent_code' => '06-06-0000-0000' ],
            [ 'code' => '06-07-0000-0000', 'name' => 'RECEIVABLES TAXES', 'level' => '2', 'parent_code' => '06-00-0000-0000' ],
            [ 'code' => '06-07-0001-0000', 'name' => 'RECEIVABLES TAXES', 'level' => '3', 'parent_code' => '06-07-0000-0000' ],
            [ 'code' => '07-00-0000-0000', 'name' => 'DIRECT INCOME', 'level' => '1', 'parent_code' => 'NULL' ],
            [ 'code' => '07-01-0000-0000', 'name' => 'NET SALES', 'level' => '2', 'parent_code' => '07-00-0000-0000' ],
            [ 'code' => '07-01-0001-0000', 'name' => 'SALES', 'level' => '3', 'parent_code' => '07-01-0000-0000' ],
            [ 'code' => '07-02-0000-0000', 'name' => 'INDIRECT INCOMES', 'level' => '2', 'parent_code' => '07-00-0000-0000' ],
            [ 'code' => '07-02-001-0000', 'name' => 'OTHER INCOME', 'level' => '3', 'parent_code' => '07-02-0000-0000' ],
            [ 'code' => '07-02-0002-0000', 'name' => 'RENT RECEIVED', 'level' => '3', 'parent_code' => '07-02-0000-0000' ],
            [ 'code' => '08-00-0000-0000', 'name' => 'COST OF GOODS SOLD', 'level' => '1', 'parent_code' => 'NULL' ],
            [ 'code' => '08-01-0000-0000', 'name' => 'NET PURCHASES', 'level' => '2', 'parent_code' => '08-00-0000-0000' ],
            [ 'code' => '08-01-0001-0000', 'name' => 'PURCHASES', 'level' => '3', 'parent_code' => '08-01-0000-0000' ],
            [ 'code' => '08-01-0002-0000', 'name' => 'PURCHASE RETURNS', 'level' => '3', 'parent_code' => '08-01-0000-0000' ],
            [ 'code' => '08-01-0003-0000', 'name' => 'PURCHASES RELATED EXPENSES', 'level' => '3', 'parent_code' => '08-01-0000-0000' ],
            [ 'code' => '08-02-0000-0000', 'name' => 'OPENING STOCK', 'level' => '2', 'parent_code' => '08-00-0000-0000' ],
            [ 'code' => '08-02-0001-0000', 'name' => 'OPENING STOCK', 'level' => '3', 'parent_code' => '08-02-0000-0000' ],
            [ 'code' => '09-00-0000-0000', 'name' => 'GENERAL & ADMINISTRATIVE EXPENSE', 'level' => '1', 'parent_code' => 'NULL' ],
            [ 'code' => '09-01-0000-0000', 'name' => 'MARKEETING EXPENSE', 'level' => '2', 'parent_code' => '09-00-0000-0000' ],
            [ 'code' => '09-01-0001-0000', 'name' => 'ADMINISTRATIVE EXPENSES', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            [ 'code' => '09-01-0002-0000', 'name' => 'STAFF SALARY', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            [ 'code' => '09-01-0003-0000', 'name' => 'RENT', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            [ 'code' => '09-01-0004-0000', 'name' => 'ADVERTISING & SALES PROMOTION', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            [ 'code' => '09-01-0005-0000', 'name' => 'INSURANCE', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            [ 'code' => '09-01-0006-0000', 'name' => 'VEHICLE EXPENSES', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            [ 'code' => '09-01-0007-0000', 'name' => 'REPAIRS & MAINTENANCE', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            [ 'code' => '09-01-0009-0000', 'name' => 'INTEREST & BANK CHARGES', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            [ 'code' => '09-01-0011-0000', 'name' => 'ELECTRICITY & WATER', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            [ 'code' => '09-01-0012-0000', 'name' => 'POST TELEPHONE FAX & INTERNET', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            [ 'code' => '09-01-0013-0000', 'name' => 'PRINTING AND STATIONARY EXPENSES', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
            [ 'code' => '09-01-0014-0000', 'name' => 'TAX', 'level' => '3', 'parent_code' => '09-01-0000-0000' ],
        ];

        $comp = Company::first();
        $project = Project::first();
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
                    'project_id' => $project->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
