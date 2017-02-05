<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function downloadCCRThisDay($d_id,$date){
        $data = new \App\Amortization;
        $data = $data->todayCCR($d_id,$date);  
        $cluster = new \App\Disbursement_Information;
        $cluster = $cluster::find($d_id);
        $cluster = $cluster->clusterInfo()->first()->code;
        \Session::set('ccr',$cluster);
        //dd($data);
      //  dd($data);
        for ($x=0;$x<=count($data)-1;$x++){
              $data[$x] = array_add($data[$x],'amount_paid','');
              $data[$x] = array_add($data[$x],'past_due','');
              $data[$x] = array_add($data[$x],'cbu','');


            
        }
       
    	\Excel::create('CCR for '.$cluster.' ('.$date.')', function($excel) use ($data) {
            
            $excel->sheet(\Session::get('ccr'), function($sheet) use ($data){  

				$sheet->fromArray($data);
               
             
                
                //dd($sheet->cells('A1:B1'));
                $sheet->cells('A1:K1', function($cells) {
                    $cells->setBackground('#FFFF00');
                });
                $sheet->getColumnDimension('A')->setVisible(false);
                $row_count = count($data)+1;
                $sheet->cells('I2:I'.$row_count, function($cells) {
                    $cells->setBackground('#FABF93');
                });
                $sheet->cells('E2:E'.$row_count, function($cells) {
                    $cells->setBackground('#00B0F0');
                });
                $sheet->cells('J2:J'.$row_count, function($cells) {
                    $cells->setBackground('#ffa500');
                });
                $sheet->cells('K2:K'.$row_count, function($cells) {
                    $cells->setBackground('#ffa500');
                });
                
/*                $sheet->protectCells('A2:A'.$row_count, env('excel_password'));
                $sheet->protectCells('B2:B'.$row_count, env('excel_password'));
                $sheet->protectCells('C2:C'.$row_count, env('excel_password'));
                $sheet->protectCells('D2:D'.$row_count, env('excel_password'));
                $sheet->protectCells('E2:E'.$row_count, env('excel_password'));
                $sheet->protectCells('F2:F'.$row_count, env('excel_password'));
                $sheet->protectCells('G2:G'.$row_count, env('excel_password'));
                $sheet->protectCells('H2:H'.$row_count, env('excel_password'));
*/

//$sheet->getProtection()->setCells(true);
                //$sheet->getProtection()->setSheet(true);
                $sheet->protectCells('A1:H1', env('excel_password'));
                $sheet->getStyle('A2:B2')->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                //$sheet->getProtection()->setSheet(true);

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
            $excel->setSubject('CCR Collection');
            
        })->download('xlsx');
    
    }
}
