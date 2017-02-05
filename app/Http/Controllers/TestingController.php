<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestingController extends Controller
{
    public function printExcel(){
        $data = new \App\Amortization;
        $data = $data->todayCCR('1','2017-02-22');  
        //dd($data);
		\Excel::create('CCR for', function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
				//$sheet->loadView('mocks.excel');
	        });
        })->download('xlsx');

    }
    public function preUpload(){
        return view('mocks.excel');
    }
    public function postUpload(Request $request){
            
          
            $rules = ['fileUpload'=>'mimes:xlsx,xls | required'];
            $msg = ['fileUpload.mimes'=>'Invalid File Type(.xlxs only)','fileUpload.required'=>'File upload is required'];
           
            $validator = \Validator::make($request->all(),$rules,$msg);
            if($validator->fails()){
                
                foreach ($validator->errors()->all() as $error){
                     echo $error;
                }
                 
                
            }else{
                $isError = false;
                //$file = $request->fileUpload;
                $file = $request->fileUpload->getRealPath();
                //dd($request);
                //dd($file);
                $data =\Excel::load($file,function($reader){
                //  $firstrow = $reader->first()->array();
                    
                })->get();
                //value is an object
                //key => objec
               
            }
    } 
}
