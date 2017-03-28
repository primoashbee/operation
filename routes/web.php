<?php
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
date_default_timezone_set('Asia/Singapore');
Route::get('/', function () {
    return redirect('/Login');
});


Auth::routes();
Route::get('/Insurance',function(){
    $model = new \App\InsuranceRates;
    $model = $model::all();
    echo '<table border="1">
    <thead>
        <th>Enrolee/s</th>
        <th>Member</th>
        <th>Spouse</th>
        <th>Child</th>
        <th>Parent</th>
        <th>Sibling</th>
        <th>Total</th>
        <th>Mi Fee</th>
        <th>Total MI Premium</th>
    </head>
    <tbody>';
    foreach($model as $x){
        echo '<tr><td>'.$x->description.'</td><td>'.$x->member_payment.'</td><td>'.$x->spouse_payment.'</td><td>'.$x->child_payment.'</td><td>'.$x->parent_paymet.'</td><td>'.$x->sibling_payment.'</td><td>'.$x->total.'</td><td>'.$x->mi_fee.'</td><td>'.$x->total_mi_fee.'</td></tr>';
    }

    echo '</tbody>
    </table>';

});
Route::get('/Auth',function(){
    dd(\Auth::user());
});

Route::get('/Logout',function(){
    \Auth::logout();
    return redirect('/Login');
});


Route::get('/Login','AccountController@index');
Route::post('/Login','AccountController@login');
Route::post('/Register','AccountController@register');

Route::get('/customers',function(){
  $faker = \Faker\Factory::create();
        for($x=0;$x<=25;$x++){
            $id = DB::table('clients')->insertGetId([
                'lastname'=>$faker->lastname,
                'firstname'=>$faker->firstname,
                'middlename'=>$faker->lastname,
                'branch_id'=>\Auth::user()->id,
                'client_code'=>generateClientCode(),
                'suffix'=>$faker->suffix,
                'nickname'=>substr($faker->firstname,0,5),
                'mother_name'=>$faker->firstNameFemale.' '.$faker->lastname,
                'spouse_name'=>$faker->firstNameFemale.' '.$faker->lastname,
                'TIN'=>rand(100000000,999999999),
                'birthday'=>$faker->dateTimeThisCentury->format('Y-m-d'),
                'home_address'=>$faker->address,
                'home_year'=>$faker->year($max='now'),
                'business_address'=>$faker->address,
                'business_year'=>$faker->year($max='now'),
                'mobile_number'=>'09'.str_random(9),
                'telephone_number'=>'222'.str_random(4),
                'civil_status'=> 'Single',
                'sex'=> 'Male',
                'education'=> 'Elementary',
                'house_type'=>'Rented'
            ]);

            DB::table('client_incomes')->insert([
                'client_id'=>$id,
                'member_lastname'=>$faker->lastname,
                'member_firstname'=>$faker->firstname,
                'member_middlename'=>$faker->firstname,
                'member_suffix'=>$faker->suffix,
                'member_age'=>rand(18,99),
                'member_relationship'=>'cousin',
                'member_occupation'=>$faker->jobTitle,
                'member_occupation_years'=>rand(1,30),
                'member_monthly_income'=>rand(10000,100000),
                'member_address'=>$faker->address
            ]);
            DB::table('client_businesses')->insert([
                'client_id'=>$id,
                'main_business'=>$faker->jobTitle,
                'secondary_business'=>str_random(10),
                'main_business_years'=>rand(1990,2016),
                'number_of_paid_employees'=>rand(0,100),
                'business_place_characteristic'=>'Owned',
            ]);
        }

        echo 'Success!';
});
Route::group(['middleware' => 'auth'], function() {
    Route::get('/Auth/Info',function(){
        return json_encode(\Auth::user()->id);
    });
    Route::get('/Clients','ClientController@index');
    Route::get('/Clients/Create','ClientController@preCreateClient');
    Route::post('/Clients/Create','ClientController@postCreateClient');

    Route::get('/Clients/Credit/{id}','CreditController@preCredit');
    Route::post('/Clients/Credit/{id}','CreditController@postCredit');

    Route::get('/Clients/Update/{id}','ClientController@getInfoById');
    Route::patch('/Clients/Update/{id}','ClientController@updateClient');

    Route::get('/Cluster','ClusterController@index');

    Route::get('/Cluster/Create','ClusterController@preCreateCluster');
    Route::post('/Cluster/Create','ClusterController@postCreateCluster');


    Route::get('/Cluster/Update/{id}','ClusterController@getInfoById');
    Route::patch('/Cluster/Update/{id}','ClusterController@updateCluster');

    Route::get('Cluster/{id}/Members','ClusterController@memberSummary');
    Route::post('Cluster/{id}/Members','ClusterController@postAddToCluster');
    Route::get('Cluster/{cluster_id}/Members/Remove/{client_id}','ClusterController@removeToCluster');


    Route::get('/Loans/Application', 'LoanController@index');
    Route::get('/Loans/Applied', 'LoanController@appliedLoans');
    Route::get('/Loans/Applied/{id}', 'LoanController@appliedLoanInfo');
    Route::get('/Loans/Applied/{id}/Schedule', 'CollectionController@getCollectionThisDay');
    
    Route::get('/Loans/Applied/{id}/Insurance', 'InsuranceController@summaryPerDisbursementID');



    Route::get('/Loans/Disbursement/{id}','DisbursementController@preDisbursement');
    Route::post('/Loans/Disbursement/{id}','DisbursementController@postDisbursement');
    Route::get('/Loans/Disbursement/Delete/{id}','DisbursementController@deleteDisbursement');
    Route::get('/Loans/Collection','CollectionController@index');
    Route::get('/Loans/Collection/{id}/{date}','CollectionController@getCollectionValues');
    Route::post('/Loans/Collection/{id}/{date}','CollectionController@readCollectionValues');
    Route::get('/Loans/Collection/{id}/{date}/Save','CollectionController@saveCollectionValues');


    Route::get('/Collected','CollectionController@collectedIndex');
    Route::get('/Collected/{id}','CollectionController@viewCollected');
    Route::get('/Collected/Cbu/{id}','CBUController@byDisbursementID');

    //Route::get('/Loans/Application', 'LoanController@index');



    //Api
    Route::post('/Api/CheckClient', 'ClientController@checkClient');
    Route::get('/Api/Loans/Analysis', 'LoanController@getAnalysisById');
    Route::get('/Api/Amortization', 'LoanController@getAnalysisById');
    Route::get('/Api/Loans/Information/{id}', 'LoanController@getLoanById');
    Route::get('/Api/Loans/CheckCoMaker', 'LoanController@checkCoMaker');
    Route::post('/Api/Loans/Analysis/{id}', 'LoanController@createLoan');
    Route::get('/Api/Scheduling/{amt}','CollectionController@createAmortScheduling');
    Route::get('/Api/GetSchedule/{disbursment_id}/{client_id}','CollectionController@retreiveAmortByDisburseAndClientId');
    Route::get('/Api/Date/Amortization/',function(){
        $input = \Request::get('from');
        
        $calendar = new \App\CalendarYear;
        $start = \Carbon\Carbon::parse($input);
        $mDate = $start->copy()->addMonthNoOverflow(6);
        $day_name = $start->copy()->format('l');
        $info =array (
            'start_date'=>$start,
            'day'=>$day_name,
            'weeks_diff' =>$mDate->diffInWeeks($start),
            'end_date'=>$mDate
        );
     
        
        $hit_dates = $calendar->checkHitDates($info);
        $week = 7;
        $first_payment = date('Y-m-d', strtotime($input.' + '.$week.' days'));
        $str = 'last '.$day_name.' of '.$info['end_date']->copy()->format('F').' '.$info['end_date']->year;
        
        
        $new = (new \Carbon\Carbon($str)); //Get Last Day [from input] to end_date month
        //dd($info['end_date']->day - $new->day);
        //dd($new->day);
        /*
        if(($info['end_date']->day - $new->day)<0){ //Get End Date Added sixmonth no overflow  - get last day of end month
            dd('Mag mamanius tayo');
        }else{ 
            dd('WAlang Minus');
        }
        dd($last->toDateString(). ' - '.$info['end_date']->toDateString());
        */
        $fp = new \Carbon\Carbon($first_payment);
        $lp = $fp->addWeeks(24)->toDatestring();
        $info =array(
            'start_date'=>$start->toDateString(),
            'first_payment'=>$first_payment,
            'day'=>$day_name,
            'weeks_diff' =>$mDate->diffInWeeks($start),
            'end_date'=>$mDate->toDateString(),
            'hit_dates_count'=>$hit_dates->count(),
            'hit_dates'=>$hit_dates,
            'last_payment'=>$lp
        );
     
        
        
        //June 1  = Dec 1
        
        $daystosum = 24 * 7; 
        $datesum = date('Y-m-d', strtotime($input.' + '.$daystosum.' days'));
        $day = date('l', strtotime($input.' + '.$daystosum.' days'));
        $x = date('W', strtotime($input.' + '.$daystosum.' days'));
        
        //  return response()->json($res);
       
        if(is_weekend($input)){
            return response()->json(['code'=>0,'maturity_date'=>'Weekdays only','day'=>$day,'first_payment'=>'']);
        }else{
            //return response()->json(['code'=>1,'maturity_date'=>$datesum,'day'=>$day,'first_payment'=>$first_payment,'res'=>$info]);        
            return response()->json(['code'=>1,'input'=>$start->toDateString(),'day'=>$day,'res'=>$info]);        
        }
    });
    Route::get('/Api/Insurance/Compute',function(){
        $amt = 0;
        if(\Request::get('amt')){
            $amt =   \Request::get('amt');
        }
        $insurance = new \App\LoanInsurance;
        $data = $insurance->compute($amt);
        return response()->json($data);
    });
    Route::get('/test',function(){
        $from = \Request::get('from');
        dd(add_seven_days($from));
    });
    Route::get('/excel','TestingController@printExcel');

    //Downloads
    Route::get('/Downloads/Collection/CCRDownload/{d_id}/{date}','DownloadController@downloadCCRThisDay'); //Download CCR for Certain Date
    Route::get('/Downloads/Collected/{payment_summary_id}','DownloadController@paymentSummaryID');

    Route::get('/haha',function(){
        $x = new \App\Amortization;
        
        $amortz = $x->where('disbursement_id','=','1')->where('collection_date','=','2017-02-08')->get();
            $return=[];
            dd($amortz);
            foreach($amortz as $x){
                $return[] = array(
                    'amort_id'=>$x->id,
                    'client_name'=>$x->clientInfo->firstname.' '.$x->clientInfo->lastname,
                    'principal_this_week'=>$x->principal_this_week,
                    'interest_this_week'=>$x->interest_this_week,
                    'principal_with_interest'=>$x->principal_with_interest,
                    'principal_balance'=>$x->principal_balance,
                    'interest_balance'=>$x->interest_balance,
                    'collection_date'=>$x->collection_date
                );
            }
            dd($return);
    });

    Route::get('/Upload','TestingController@preUpload');
    Route::post('/Upload','TestingController@postUpload');
   //
});


Route::get('/Testing',function(){
    $cluster = new \App\Cluster_Information;
    $cluster = $cluster::paginate(15);
    return view('pages2.apply-loan',['clusters'=>$cluster]);
});
