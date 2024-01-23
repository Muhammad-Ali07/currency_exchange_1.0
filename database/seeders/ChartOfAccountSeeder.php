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

            [ 'code' => '01-01-0001-0001', 'name' => 'OFFICE EQUIPMENT', 'level' => '4', 'parent_code' => '01-01-0001-0000' ],
            [ 'code' => '01-01-0002-0001', 'name' => 'PROPERTY PLANT & EQUIPMENT', 'level' => '4', 'parent_code' => '01-01-0002-0000' ],

            [ 'code' => '01-02-0001-0000', 'name' => 'CASH & CASH EQUIVALENT', 'level' => '3', 'parent_code' => '01-02-0000-0000' ],
            [ 'code' => '01-02-0001-0001', 'name' => 'MEEZAN BANK #5314-PKR', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0002', 'name' => 'MEEZAN BANK #9227- PKR', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0003', 'name' => 'MEEZAN BANK #6432- PKR', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0004', 'name' => 'MEEZAN BANK #1168- PKR', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0005', 'name' => 'MEEZAN BANK #6696- PKR', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0006', 'name' => 'HBL M BANK #2184-PKR', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0007', 'name' => 'HABIB M BANK #2184-PKR', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0008', 'name' => 'HABIB M BANK #2149-PKR', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0009', 'name' => 'KUVEYT TURK #1300001-TL', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0010', 'name' => 'KUVEYT TURK #4600001-TL', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0011', 'name' => 'KUVEYT TURK # 90600001-TL', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0012', 'name' => 'KUVEYT TURK # 7900001-TL', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0013', 'name' => 'KUVEYT TURK #6800001-TL', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0014', 'name' => 'KUVEYT TURK # 400001-TL', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0015', 'name' => 'IS BANK # 2905263-TL', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0016', 'name' => 'IS BANK  # 2905395-TL', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0017', 'name' => 'IS BANK # 2908564-TL', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0018', 'name' => 'ALBARAKA BANK #5000001-TL', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0019', 'name' => 'KUVEYT TURK #300102-USD', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0020', 'name' => 'KUVEYT TURK #4600101-USD', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0021', 'name' => 'KUVEYT TURK # 600101-USD', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0022', 'name' => 'KUVEYT TURK # 900103-USD', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0023', 'name' => 'KUVEYT TURK #6800101-USD', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0024', 'name' => 'KUVEYT TURK # 400101-USD', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0025', 'name' => 'IS BANK # 366 73-USD', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0026', 'name' => 'IS BANK  # 58920-USD', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0027', 'name' => 'IS BANK # 39768-USD', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0028', 'name' => 'ALBARAKA BANK #00003-USD', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0029', 'name' => 'Kuveyt Turk Bank # 600102', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0030', 'name' => 'ERSTE BANK # 5468-HUF', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0031', 'name' => 'ERSTE BANK # 6139_EUR', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],
            [ 'code' => '01-02-0001-0032', 'name' => 'CASH in HAND', 'level' => '4', 'parent_code' => '01-02-0001-0000' ],

            [ 'code' => '01-02-0002-0000', 'name' => 'CURRENCY EXCHANGE RESERVE', 'level' => '3', 'parent_code' => '01-02-0000-0000' ],
            [ 'code' => '01-02-0002-0001', 'name' => 'PKR  reserve', 'level' => '4', 'parent_code' => '01-02-0002-0000' ],
            [ 'code' => '01-02-0002-0002', 'name' => 'AED reserve', 'level' => '4', 'parent_code' => '01-02-0002-0000' ],
            [ 'code' => '01-02-0002-0003', 'name' => 'EURO reserve', 'level' => '4', 'parent_code' => '01-02-0002-0000' ],
            [ 'code' => '01-02-0002-0004', 'name' => 'Dollar  reserve', 'level' => '4', 'parent_code' => '01-02-0002-0000' ],
            [ 'code' => '01-02-0002-0005', 'name' => 'TRY reserve', 'level' => '4', 'parent_code' => '01-02-0002-0000' ],
            [ 'code' => '01-02-0002-0006', 'name' => 'Pound reserve', 'level' => '4', 'parent_code' => '01-02-0002-0000' ],

            //CUSTOMERS CODE WILL BE UNDER ACCOUNTS RECEIVABLES
            [ 'code' => '01-02-0003-0000', 'name' => 'ACCOUNTS RECEIVABLES', 'level' => '3', 'parent_code' => '01-02-0000-0000' ],

            [ 'code' => '01-02-0004-0000', 'name' => 'PREPAID EXPENSES', 'level' => '3', 'parent_code' => '01-02-0000-0000' ],
            [ 'code' => '01-02-0004-0001', 'name' => 'PREPAID EXPENSES', 'level' => '3', 'parent_code' => '01-02-0004-0000' ],

            [ 'code' => '01-02-0005-0000', 'name' => 'ADVANCE PAYMENT', 'level' => '3', 'parent_code' => '01-02-0000-0000' ],
            [ 'code' => '01-02-0005-0001', 'name' => 'ADVANCE PAYMENT', 'level' => '4', 'parent_code' => '01-02-0005-0000' ],
            //              ::::::::::ASSET SECTION EDNDS::::::::::

            //              ::::::::::LIABILITIES SECTION STARTS::::::::::
            [ 'code' => '02-00-0000-0000', 'name' => 'LIABILITIES', 'level' => '1', 'parent_code' => 'NULL' ],

            [ 'code' => '02-01-0000-0000', 'name' => 'CURRENT LIABILITIES', 'level' => '2', 'parent_code' => '02-00-0000-0000' ],
            [ 'code' => '02-02-0000-0000', 'name' => 'LONG LIABILITIES', 'level' => '2', 'parent_code' => '02-00-0000-0000' ],

            // ACCOUNTS PAYABLE IS USED FOR VENDORS/SUPPLIERS
            [ 'code' => '02-01-0001-0000', 'name' => 'ACCOUNTS PAYABLE', 'level' => '3', 'parent_code' => '02-01-0000-0000' ],

            [ 'code' => '02-01-0002-0000', 'name' => 'SHORT-TERM LOAN', 'level' => '3', 'parent_code' => '02-01-0000-0000' ],
            [ 'code' => '02-01-0002-0001', 'name' => 'HBL Bank # 536603 (Credit AC)', 'level' => '4', 'parent_code' => '02-01-0002-0000' ],

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
            [ 'code' => '03-02-0002-0000', 'name' => 'iNCOME/LOSS', 'level' => '3', 'parent_code' => '03-02-0000-0000' ],
            //              ::::::::::EQUITY SECTION ENDS::::::::::

            //              ::::::::::REVENUE SECTION STARTS::::::::::
            [ 'code' => '04-00-0000-0000', 'name' => 'REVENUE', 'level' => '1', 'parent_code' => 'NULL' ],

            [ 'code' => '04-01-0000-0000', 'name' => 'SALES', 'level' => '2', 'parent_code' => '04-00-0000-0000' ], // CUSTOMERS

            [ 'code' => '04-01-0001-0000', 'name' => 'COMMISSION / EX-GAIN', 'level' => '3', 'parent_code' => '04-01-0000-0000' ],
            [ 'code' => '04-01-0001-0001', 'name' => 'Com/ex gain income-PKR', 'level' => '4', 'parent_code' => '04-01-0001-0000' ],
            [ 'code' => '04-01-0001-0002', 'name' => 'Com/ex gain income-AED', 'level' => '4', 'parent_code' => '04-01-0001-0000' ],
            [ 'code' => '04-01-0001-0003', 'name' => 'Com/ex gain income-EURO', 'level' => '4', 'parent_code' => '04-01-0001-0000' ],
            [ 'code' => '04-01-0001-0004', 'name' => 'Com/ex gain income-Dollar', 'level' => '4', 'parent_code' => '04-01-0001-0000' ],
            [ 'code' => '04-01-0001-0005', 'name' => 'Com/ex gain income-TRY', 'level' => '4', 'parent_code' => '04-01-0001-0000' ],
            [ 'code' => '04-01-0001-0006', 'name' => 'Com/ex gain income-POUND', 'level' => '4', 'parent_code' => '04-01-0001-0000' ],

            [ 'code' => '04-01-0002-0000', 'name' => 'OTHER INCOME', 'level' => '3', 'parent_code' => '04-01-0000-0000' ],
            [ 'code' => '04-01-0002-0001', 'name' => 'CONSULTANCY FEE', 'level' => '4', 'parent_code' => '04-01-0002-0000' ],
            [ 'code' => '04-01-0002-0002', 'name' => 'BANK INTEREST', 'level' => '4', 'parent_code' => '04-01-0002-0000' ],
            [ 'code' => '04-01-0002-0003', 'name' => 'OTHER INCOMES', 'level' => '4', 'parent_code' => '04-01-0002-0000' ],
            [ 'code' => '04-01-0002-0004', 'name' => 'EXCHANGE GAIN', 'level' => '4', 'parent_code' => '04-01-0002-0000' ],
            //              ::::::::::REVENUE SECTION ENDS::::::::::

            //              ::::::::::EXPENSE SECTION STARTS::::::::::
            [ 'code' => '05-00-0000-0000', 'name' => 'EXPENSES', 'level' => '1', 'parent_code' => 'NULL' ],

            [ 'code' => '05-01-0000-0000', 'name' => 'COST OF TRADING', 'level' => '2', 'parent_code' => '05-00-0000-0000' ],

            [ 'code' => '05-01-0001-0000', 'name' => 'PURCHASE', 'level' => '3', 'parent_code' => '05-01-0000-0000' ],
            [ 'code' => '05-01-0001-0001', 'name' => 'PKR', 'level' => '4', 'parent_code' => '05-01-0001-0000' ],
            [ 'code' => '05-01-0001-0002', 'name' => 'AED', 'level' => '4', 'parent_code' => '05-01-0001-0000' ],
            [ 'code' => '05-01-0001-0003', 'name' => 'EURO', 'level' => '4', 'parent_code' => '05-01-0001-0000' ],
            [ 'code' => '05-01-0001-0004', 'name' => 'DOLLAR', 'level' => '4', 'parent_code' => '05-01-0001-0000' ],
            [ 'code' => '05-01-0001-0005', 'name' => 'TRY', 'level' => '4', 'parent_code' => '05-01-0001-0000' ],
            [ 'code' => '05-01-0001-0006', 'name' => 'POUND', 'level' => '4', 'parent_code' => '05-01-0001-0000' ],

            [ 'code' => '05-01-0002-0000', 'name' => 'COMMISSION / CHARGES', 'level' => '3', 'parent_code' => '05-01-0000-0000' ],
            [ 'code' => '05-01-0002-0001', 'name' => 'COMMISSION / CHARGES / EXPENSES', 'level' => '4', 'parent_code' => '05-01-0002-0000' ],
            [ 'code' => '05-01-0002-0002', 'name' => 'MARK UP', 'level' => '4', 'parent_code' => '05-01-0002-0000' ],

            [ 'code' => '05-02-0000-0000', 'name' => 'ADMINISTRATIVE EXPENSES', 'level' => '2', 'parent_code' => '05-00-0000-0000' ],
            [ 'code' => '05-02-0001-0000', 'name' => 'SALARY & WAGES', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0001-0001', 'name' => 'SALARY & WAGES', 'level' => '4', 'parent_code' => '05-02-0001-0000' ],
            [ 'code' => '05-02-0001-0002', 'name' => 'BONUS', 'level' => '4', 'parent_code' => '05-02-0001-0000' ],

            [ 'code' => '05-02-0002-0000', 'name' => 'REMUNERATION', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0002-0001', 'name' => 'HAMID PERSONAL EXPENSES', 'level' => '3', 'parent_code' => '05-02-0002-0000' ],

            [ 'code' => '05-02-0003-0000', 'name' => 'OFFICE RENT', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0003-0001', 'name' => 'OFFICE RENT-TRK', 'level' => '4', 'parent_code' => '05-02-0003-0000' ],

            [ 'code' => '05-02-0004-0000', 'name' => 'HOUSE RENT', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0004-0001', 'name' => 'HOUSE RENT (TRK)', 'level' => '4', 'parent_code' => '05-02-0004-0000' ],
            [ 'code' => '05-02-0004-0002', 'name' => 'HOUSE RENT (HU)', 'level' => '4', 'parent_code' => '05-02-0004-0000' ],

            [ 'code' => '05-02-0005-0000', 'name' => 'WATER BILL', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0005-0001', 'name' => 'WATER BILL (TRK)', 'level' => '4', 'parent_code' => '05-02-0005-0000' ],
            [ 'code' => '05-02-0005-0002', 'name' => 'WATER BILL (HU)', 'level' => '4', 'parent_code' => '05-02-0005-0000' ],
            [ 'code' => '05-02-0005-0003', 'name' => 'OFFICE WATER BILL', 'level' => '4', 'parent_code' => '05-02-0005-0000' ],

            [ 'code' => '05-02-0006-0000', 'name' => 'ELECTRICITY BILL', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0006-0001', 'name' => 'ELECTRICITY BILL (TUK)', 'level' => '4', 'parent_code' => '05-02-0006-0000' ],
            [ 'code' => '05-02-0006-0002', 'name' => 'ELECTRICITY BILL (HU)', 'level' => '4', 'parent_code' => '05-02-0006-0000' ],
            [ 'code' => '05-02-0006-0003', 'name' => 'OFFICE ELECTRICITY BILL', 'level' => '4', 'parent_code' => '05-02-0006-0000' ],

            [ 'code' => '05-02-0007-0000', 'name' => 'UTILITIES', 'level' => '3', 'parent_code' => '05-02-0007-0000' ],
            [ 'code' => '05-02-0007-0001', 'name' => 'UTILITIES-TRK', 'level' => '4', 'parent_code' => '05-02-0007-0000' ],
            [ 'code' => '05-02-0007-0002', 'name' => 'UTILITIES-HUF', 'level' => '4', 'parent_code' => '05-02-0007-0000' ],


            [ 'code' => '05-02-0008-0000', 'name' => 'TRAVELING COST', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0008-0001', 'name' => 'HAMID TRAVEL COST', 'level' => '4', 'parent_code' => '05-02-008-0000' ],
            [ 'code' => '05-02-0008-0002', 'name' => 'EMPLOYEE TRAVEL EXPENSE', 'level' => '4', 'parent_code' => '05-02-0008-0000' ],

            [ 'code' => '05-02-0009-0000', 'name' => 'ENTERTAINMENT', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0009-0001', 'name' => 'OFFICE ENTERTAINMENT', 'level' => '4', 'parent_code' => '05-02-0009-0000' ],
            [ 'code' => '05-02-0009-0002', 'name' => 'CUSTOMER ENTERTAINMENT', 'level' => '4', 'parent_code' => '05-02-0009-0000' ],
            [ 'code' => '05-02-0009-0003', 'name' => 'BUSINESS MEETING', 'level' => '4', 'parent_code' => '05-02-0009-0000' ],

            [ 'code' => '05-02-0010-0000', 'name' => 'MARKETING & ADVERTISEMENT', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0010-0001', 'name' => 'PROMOTIONAL COST', 'level' => '4', 'parent_code' => '05-02-0010-0000' ],
            [ 'code' => '05-02-0010-0002', 'name' => 'ADVERTISEMENT', 'level' => '4', 'parent_code' => '05-02-0010-0000' ],

            [ 'code' => '05-02-0011-0000', 'name' => 'PKR FAMILY SUPPORT EXP', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0011-0001', 'name' => 'PKR FAMILY SUPPORT EXP', 'level' => '4', 'parent_code' => '05-02-0011-0000' ],

            [ 'code' => '05-02-0012-0000', 'name' => 'POSTAGE, PRINTING & STATIONARY', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0012-0001', 'name' => 'POSTAGE, PRINTING & STATIONARY', 'level' => '4', 'parent_code' => '05-02-0012-0000' ],

            [ 'code' => '05-02-0013-0000', 'name' => 'TELEPHONE & MOBILE BILL', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0013-0001', 'name' => 'TELEPHONE & MOBILE BILL', 'level' => '4', 'parent_code' => '05-02-0013-0000' ],

            [ 'code' => '05-02-0014-0000', 'name' => 'CLEANING & WASTE BILL', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0014-0001', 'name' => 'CLEANING & WASTE BILL', 'level' => '4', 'parent_code' => '05-02-0014-0000' ],

            [ 'code' => '05-02-0015-0000', 'name' => 'EDUCATION & TRAINING FEE', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0015-0001', 'name' => 'KIDS EDUCATIONAL FEES', 'level' => '4', 'parent_code' => '05-02-0015-0000' ],
            [ 'code' => '05-02-0015-0002', 'name' => 'OTHER EDUCATIONAL FEES', 'level' => '4', 'parent_code' => '05-02-0015-0000' ],

            [ 'code' => '05-02-0016-0000', 'name' => 'INSURANCE', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0016-0001', 'name' => 'INSURANCE PREMIUM', 'level' => '4', 'parent_code' => '05-02-0016-0000' ],

            [ 'code' => '05-02-0017-0000', 'name' => 'LICENSE & RENEWAL', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0017-0001', 'name' => 'COMPANY LIC & RENEWAL', 'level' => '4', 'parent_code' => '05-02-0017-0000' ],
            [ 'code' => '05-02-0017-0002', 'name' => 'EMP CONTRACT LIC & RENEWAL', 'level' => '4', 'parent_code' => '05-02-0017-0000' ],

            [ 'code' => '05-02-0018-0000', 'name' => 'REPAIR & MAINTENANCE', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0018-0001', 'name' => 'REPAIR & MAINTENANCE', 'level' => '4', 'parent_code' => '05-02-0018-0000' ],

            [ 'code' => '05-02-0019-0000', 'name' => 'EQUIPMENT & TOOL PURCHASE', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0019-0001', 'name' => 'EQUIPMENT & TOOL PURCHASE', 'level' => '4', 'parent_code' => '05-02-0019-0000' ],

            [ 'code' => '05-02-0020-0000', 'name' => 'DEPRICIATION / AMORTIZATION', 'level' => '3', 'parent_code' => '05-02-0000-0000' ],
            [ 'code' => '05-02-0020-0001', 'name' => 'DEPRICIATION / AMORTIZATION', 'level' => '4', 'parent_code' => '05-02-0020-0000' ],


            [ 'code' => '05-03-0000-0000', 'name' => 'FINANCIAL EXPENSES', 'level' => '2', 'parent_code' => '05-00-0000-0000' ],

            [ 'code' => '05-03-0001-0000', 'name' => 'BANK CHARGES', 'level' => '3', 'parent_code' => '05-03-0000-0000' ],
            [ 'code' => '05-03-0001-0001', 'name' => 'BANK CHARGES', 'level' => '4', 'parent_code' => '05-03-0001-0000' ],

            [ 'code' => '05-03-0002-0000', 'name' => 'CREDIT CARD CHARGES', 'level' => '3', 'parent_code' => '05-03-0000-0000' ],
            [ 'code' => '05-03-0002-0001', 'name' => 'CREDIT CARD CHARGES', 'level' => '4', 'parent_code' => '05-03-0002-0000' ],

            [ 'code' => '05-03-0003-0000', 'name' => 'FOREIGN EX ADJ(GAIN/LOSS)', 'level' => '3', 'parent_code' => '05-03-0000-0000' ],
            [ 'code' => '05-03-0003-0001', 'name' => 'FOREIGN EX ADJ(GAIN/LOSS)', 'level' => '4', 'parent_code' => '05-03-0003-0000' ],

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
                    'company_id' => 1,
                    'project_id' => 1,
                    'branch_id' => 1,
                    'user_id' => 1,
                ]);
            }
        }
    }
}
