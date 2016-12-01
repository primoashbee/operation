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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/Clients','ClientController@index');

Route::get('/Clients/Create','ClientController@preCreateClient');
Route::post('/Clients/Create','ClientController@postCreateClient');

Route::get('/Clients/Update/{id}','ClientController@getInfoById');
Route::patch('/Clients/Update/{id}','ClientController@updateClient');

Route::get('/Cluster','ClusterController@index');
Route::get('/Cluster/Create','ClusterController@preCreateCluster');
Route::post('/Cluster/Create','ClusterController@postCreateCluster');


Route::get('/Cluster/Update/{id}','ClusterController@getInfoById');
Route::patch('/Cluster/Update/{id}','ClusterController@updateCluster');

Route::get('Cluster/{id}/Members','ClusterController@memberSummary');
Route::post('Cluster/{id}/Members','ClusterController@postAddToCluster');

