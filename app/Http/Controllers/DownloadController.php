<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function downloadCCRThisDay($d_id,$date){
        $ps = new \App\Payment_Summary;
        $payment = new \App\Payment_Summary;
        $payment = $payment::where('disbursement_id','=',$d_id);
        $dif = new \App\Disbursement_Information;
        $dif = $dif::find($d_id);
        
        if($dif->branchCode() != \Auth::user()->branch_code){
            return 'cross downloading of documents';
        }
        if($ps::where('disbursement_id','=',$d_id)->where('collection_date','=',$date)->count() > 0){
            echo 'Already Collected For this Date <br>';
            echo 'Click <a href="'.url()->previous().'"> Here </a> to go back';
            return;  
        }
        $data = new \App\Amortization;
        $data = $data->todayCCR($d_id,$date);
        
        if(env('dev_mode')){
                $cluster = new \App\Disbursement_Information;
                $cluster = $cluster::find($d_id);
                $cluster = $cluster->clusterInfo()->first()->code;
                $d_id = $d_id;  

                \Session::set('ccr',$d_id);
            \Excel::create('CCR for '.$cluster.' ('.$date.')', function($excel) use ($data) {
                
                $excel->sheet(\Session::get('ccr'), function($sheet) use ($data){  

                    $sheet->fromArray($data,null,'A1',true);
                    //dd($sheet->cells('A1:B1'));
                    $sheet->cells('A1:P1', function($cells) {
                        $cells->setBackground('#FFFF00');
                        $cells->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '12',
                            'bold'       =>  true
                        ));
                    });

                    $sheet->getColumnDimension('A')->setVisible(false);
                    $sheet->getColumnDimension('B')->setVisible(false);
                    $sheet->getColumnDimension('E')->setVisible(false);
                    $sheet->getColumnDimension('F')->setVisible(false);
                    $sheet->getColumnDimension('G')->setVisible(false);
                    $sheet->getColumnDimension('H')->setVisible(false);
                    $sheet->getColumnDimension('I')->setVisible(false);
                   
                    $sheet->getColumnDimension('L')->setVisible(false);
                    $sheet->getColumnDimension('K')->setVisible(false);
                    $row_count = count($data)+1;


                    //principal + interest based on amortization
                    $sheet->cells('J2:J'.$row_count, function($cells) {
                        $cells->setBackground('#7d7de3');
                        $cells->setBorder('A1', 'thin');
                    });

                    $sheet->setBorder('M2:P'.$row_count, 'thin'); //Past Due To CBU
                    $sheet->setBorder('J2:P'.$row_count, 'thin'); //amortization schedule
                    
                
                    //Payment
                    $sheet->cells('O2:O'.$row_count, function($cells) {
                        $cells->setBackground('#00B0F0');
                    
                    });

                    //Past Due Total
                    $sheet->cells('M2:M'.$row_count, function($cells) {
                        $cells->setBackground('#d9534f');
                    });


                    //total_amount_due
                    $sheet->cells('N2:N'.$row_count, function($cells) {
                        $cells->setBackground('#FABF93'); //pink
                    });

                    //Payment
                    $sheet->cells('O2:O'.$row_count, function($cells) {
                        $cells->setBackground('#ffa500'); //orange
                       
                    });
                    //CBU
                    $sheet->cells('P2:P'.$row_count, function($cells) {
                        $cells->setBackground('#ffa500'); //orange
                    });
                


                    $sheet->setColumnFormat(array(
                        'O'=>'0',
                        'P'=>'0'
                    ));
                    
                    $sheet->getProtection()->setSheet(true);
                    $sheet->getStyle('O2:P'.$row_count)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                    $sheet->getStyle('P2:P'.$row_count)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                           
                    
                });

                $excel->sheet('INSTRUCTIONS', function($sheet) use ($data){  
                    $instructions = array(
                        'INSTRUCTION1'=>'FILL UP ONLY FIELDS WITH RED BACKGROUND COLOR THANKS',
                        'INSTRUCTION2'=>'IF THERE IS NO AMOUNT PAID FOR THE CURRENT COLLECTION, ENCODE "0"',
                        'INSTRUCTION3'=>'ONLY ENCODE AND DO NOT DELETE ANY ROW,COLUMN,CELL OR ANYTHING');
                    $sheet->fromArray($instructions);
                    
                });
                $excel->setCreator(env('Author'))->setCompany('LIGHT Microfinance Inc.');
                $excel->setSubject('CCR Collection');
                
                
            })->download('xlsx');
        
        }else{
            if($date!=\Carbon\Carbon::now()->toDateString()){
                echo 'Date Error: CCR downloading is only Available in its collection day <br> ';
                echo 'Click <a href="'.url()->previous().'"> Here to go back';
            }else{
                $cluster = new \App\Disbursement_Information;
                $cluster = $cluster::find($d_id);
                $cluster = $cluster->clusterInfo()->first()->code;
                $d_id = $d_id;  
                \Session::set('ccr',$d_id);
                //dd($data);
                //dd($data);
            for ($x=0;$x<=count($data)-1;$x++){
                $pastdue = 0;
                $data[$x] = array_add($data[$x],'past_due',$pastdue);
                $data[$x] = array_add($data[$x],'total_amount_due',$data[$x]['principal_with_interest']+$pastdue);
                $data[$x] = array_add($data[$x],'amount_paid','');
                
                $data[$x] = array_add($data[$x],'cbu','');


                
            }
        
            \Excel::create('CCR for '.$cluster.' ('.$date.')', function($excel) use ($data) {
                
                $excel->sheet(\Session::get('ccr'), function($sheet) use ($data){  

                    $sheet->fromArray($data,null,'A1',true);
                
                
                    
                
                    //dd($sheet->cells('A1:B1'));
                    $sheet->cells('A1:N1', function($cells) {
                        $cells->setBackground('#FFFF00');
                        $cells->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '12',
                            'bold'       =>  true
                        ));
                    });

                    $sheet->getColumnDimension('A')->setVisible(false);
                    $sheet->getColumnDimension('B')->setVisible(false);
                    $row_count = count($data)+1;

                    //Payment
                    $sheet->cells('J2:J'.$row_count, function($cells) {
                        $cells->setBackground('#00B0F0');
                    
                    });
                    $sheet->cells('K2:K'.$row_count, function($cells) {
                        $cells->setBackground('#ff0000');
                    });



                    $sheet->cells('L2:L'.$row_count, function($cells) {
                        $cells->setBackground('#FABF93');
                    });
                    $sheet->cells('M2:M'.$row_count, function($cells) {
                        $cells->setBackground('#ffa500');
                    });
                    $sheet->cells('N2:N'.$row_count, function($cells) {
                        $cells->setBackground('#ffa500');
                    });
                


                    
                    $sheet->protect('ashbee');
                    $sheet->getProtection()->setSheet(true);
                    $sheet->getStyle('M2:M'.$row_count)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                    $sheet->getStyle('N2:N'.$row_count)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

                });

                $excel->sheet('INSTRUCTIONS', function($sheet) use ($data){  
                    $instructions = array(
                        'INSTRUCTION1'=>'FILL UP ONLY FIELDS WITH RED BACKGROUND COLOR THANKS',
                        'INSTRUCTION2'=>'IF THERE IS NO AMOUNT PAID FOR THE CURRENT COLLECTION, ENCODE "0"',
                        'INSTRUCTION3'=>'ONLY ENCODE AND DO NOT DELETE ANY ROW,COLUMN,CELL OR ANYTHING');
                    $sheet->fromArray($instructions);
                    
                });
                $excel->setCreator(env('Author'))->setCompany('LIGHT Microfinance Inc.');
                $excel->setSubject('CCR Collection');
                
                
            })->download('xlsx');
        
            }
        }
    }
    public function paymentSummaryID($payment_summary_id){
        $payment = new \App\Payment_Summary;
        $payment=$payment::find($payment_summary_id);
        if(!($payment->getDisbursement()->first()->clusterInfo()->first()->branch_id == $payment->auth->branch_code)){
            return 'cross downloading of documents';
        }
        if($payment===null){
            echo 'wew';
        }else{
            $pi = new \App\Payment_Information;
            $pi = $pi::where('payment_summary_id','=',$payment_summary_id)->get();


            $cluster_code = $payment->getDisbursement()->first()->clusterInfo()->first()->code; 
            $date = $payment->collection_date;
            $time = $payment->created_at->format('g-i-s A');
            //dd($payment->created_at->hour.'.'.$payment->created_at->minute.'.'.$payment->created_at->second.' '.$payment->created_at->minute);
            $title = 'Collection Information for '.$cluster_code.' on '.$date.'(Uploaded on '.$payment->created_at->toDateString().' '.$time.')';
            $download = new \App\MyClass\Download_Collected;
            $download->set($payment_summary_id);
            $data = new \App\MyClass\Download_Collected;
            $data->set($payment_summary_id);
            $report_data = $data->p_report;
        
            \Excel::create($title, function($excel) use ($report_data) {
                
                $excel->sheet('Payment', function($sheet) use ($report_data){  
                    $sheet->fromArray($report_data,null,'A1',true);
                    $sheet->protect('ashbee');
                    $sheet->getProtection()->setSheet(true);
               

                });

                $excel->setCreator(env('Author'))->setCompany('LIGHT Microfinance Inc.');
                $excel->setSubject('CCR Collection');
                
                
            })->download('xlsx');


        }
       
    }
}
