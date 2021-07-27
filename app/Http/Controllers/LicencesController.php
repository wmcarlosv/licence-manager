<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Licence;
use DateTime;

class LicencesController extends Controller
{
    public function check_licence($key){
        $licence = Licence::where('key',$key)->get();

        if($licence->count() > 0){

            $currentData = new DateTime(date('Y-m-d'));
            $dt = new DateTime($licence[0]->date_to);
            $interval = $currentData->diff($dt);
            $days = $interval->format('%r%a');

            $result = [
                'date_from' => $licence[0]->date_from,
                'date_to' => $licence[0]->date_to,
                'total_days' => $days,
                'status' => $licence[0]->status,
                'is_payment' => $licence[0]->is_payment,
                'is_asigned' => $licence[0]->is_asigned
            ];

           if($licence[0]->is_payment == 1){

                if($days >= 0){

                    if($licence[0]->status == 'active'){
                         $uLicence = Licence::findorfail($licence[0]->id);
                         $uLicence->is_asigned = 1;
                         $uLicence->update();
                        $data = ['success'=>'yes', 'data' => $result];
                    }else{
                        $data = ['success'=>'no', 'message' => 'La licencia no se encuentra Activa!!'];
                    }
                    
                }else{
                    $uLicence = Licence::findorfail($licence[0]->id);
                    $uLicence->status = 'inactive';
                    $uLicence->update();
                    $data = ['success'=>'no', 'message'=>'La licencia ha caducado!!'];
                }
            }else{
                $data = ['success'=>'no', 'message'=>'La licencia no ha sido pagada!!'];
            } 

            
        }else{
            $data = ['success'=>'no', 'message'=> 'La licencia no existe!!'];
        }   

        return response()->json($data);
    }

    public function add_devices($key, $type, $count){
        $licence = Licence::where('key',$key)->get();

        if($licence->count() > 0){
            if($type=='actives'){
                $licence[0]->active_devices = $count;
            }else{
                 $licence[0]->inactive_devices = $count;
            }

            $licence[0]->update();
        }

        
    }
}
