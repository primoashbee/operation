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



Route::get('/Loans/Disbursement/{id}','DisbursementController@preDisbursement');
Route::post('/Loans/Disbursement/{id}','DisbursementController@postDisbursement');
Route::get('/Loans/Collection','CollectionController@index');
Route::get('/Loans/Collection/{id}','CollectionController@getCollectionValues');


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
    echo \Request::get('from');
});

