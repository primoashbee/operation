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
    return view('welcome');
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



Route::get('/Loans/Disbursement/{id}','DisbursementController@preDisbursement');
Route::post('/Loans/Disbursement/{id}','DisbursementController@postDisbursement');
Route::get('/Loans/Collection','CollectionController@index');
Route::get('/Loans/Collection/{id}/{date}','CollectionController@getCollectionValues');
Route::post('/Loans/Collection/{id}/{date}','CollectionController@readCollectionValues');
Route::get('/Loans/Collection/{id}/{date}/Save','CollectionController@saveCollectionValues');


Route::get('/Collected','CollectionController@collectedIndex');
Route::get('/Collected/{id}','CollectionController@viewCollected');

//Route::get('/Loans/Application', 'LoanController@index');



//Api
Route::get('/Api/Loans/Analysis', 'LoanController@getAnalysisById');
Route::get('/Api/Amortization', 'LoanController@getAnalysisById');
Route::get('/Api/Loans/Information/{id}', 'LoanController@getLoanById');
Route::get('/Api/Loans/CheckCoMaker', 'LoanController@checkCoMaker');
Route::post('/Api/Loans/Analysis/{id}', 'LoanController@createLoan');
Route::get('/Api/Scheduling/{amt}','CollectionController@createAmortScheduling');
Route::get('/Api/GetSchedule/{disbursment_id}/{client_id}','CollectionController@retreiveAmortByDisburseAndClientId');
Route::get('/Api/Date/Amortization/',function(){
    $from = \Request::get('from');
    
    //dd(is_weekend($from));

    $daystosum = 24 * 7; 
    $datesum = date('Y-m-d', strtotime($from.' + '.$daystosum.' days'));
    $day = date('l', strtotime($from.' + '.$daystosum.' days'));
    $x = date('W', strtotime($from.' + '.$daystosum.' days'));
    
    if(is_weekend($from)){
        return response()->json(['code'=>0,'msg'=>'Weekdays only','day'=>$day]);
    }else{
        return response()->json(['code'=>1,'msg'=>$datesum,'day'=>$day]);        
    }
});
Route::get('/test',function(){
    $from = \Request::get('from');
    dd(add_seven_days($from));
});
Route::get('/excel','TestingController@printExcel');

//Downloads
Route::get('/Downloads/Collection/CCRDownload/{d_id}/{date}','DownloadController@downloadCCRThisDay');
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


