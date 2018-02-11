<?php
namespace Modules\Paypal\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class registerOrderShipAddress extends Model{

  protected $fillable = [];
  protected $table = 'shipping_address';

  public function regOrderShipAddress($user,$id){
    $regShip = new registerOrderShipAddress();
    if ($user['new_user']) {
      if (session()->get('sponsor_selected')) {
        $regShip->sponsor = session()->get('sponsor')['eo_number'];
        $regShip->sponsor_name = session()->get('sponsor')['eo_name'];
        $regShip->sponsor_email = session()->get('sponsor')['eo_email'];
        $regShip->eo_number = 0000;
        $regShip->eo_name =session()->get('formReg')['name']." ".session()->get('formReg')['last_name'] ;
      }else{
        $regShip->sponsor = session()->get('sponsor_rnd')['eo_number'];
        $regShip->sponsor_name = session()->get('sponsor_rnd')['eo_name'];
        $regShip->sponsor_email = session()->get('sponsor_rnd')['eo_email'];
        $regShip->eo_number = session()->get('sponsor_rnd')['eo_number'];
        $regShip->eo_name = session()->get('sponsor_rnd')['eo_name'];
      }

      $regShip->order_id = $id->original['last_insert_id'];
      $regShip->type = 'INSCRIPCION';
      $regShip->folio = 1;
      $regShip->address = session()->get('formReg')['address'];
      $regShip->number = 0;
      $regShip->suburb = session()->get('formReg')['county'];
      $regShip->zip_code = session()->get('formReg')['zip_code'];
      $regShip->city = session()->get('formReg')['federal_entities'];
      $regShip->city_name = session()->get('formReg')['federal_entities'];
      $regShip->state = session()->get('formReg')['state'];
      $regShip->county = session()->get('formReg')['county'];
      $regShip->country_key = session()->get('formReg')['country'];
      $regShip->email = session()->get('formReg')['email'];
      $regShip->telephone = session()->get('formReg')['phone_number'];
      $regShip->cell_number = session()->get('formReg')['phone_number'];
      $regShip->gender = session()->get('formReg')['gender'];
      $regShip->security_question_id = session()->get('formReg')['security_question'];
      $regShip->answer = session()->get('formReg')['answer'];
      $regShip->birthdate = session()->get('formReg')['birthdate'];
      $regShip->language_short_name = session()->get('lang_id')->short_name;
      $regShip->kit_type = null;
      $regShip->document_key = null;
      $regShip->document_number = null;
    } else{
      $regShip->sponsor = null;
      $regShip->sponsor_name = null;
      $regShip->sponsor_email = null;
      $regShip->eo_number = $user['eo_number'];
      $regShip->eo_name = session()->get('userName');
      $regShip->order_id = $id->original['last_insert_id'];
      $regShip->type = 'VENTA';
      $regShip->folio = session()->get('adressShippDist')['folio'];
      $regShip->address = session()->get('adressShippDist')['direccion'];
      $regShip->number = 0;
      $regShip->suburb = session()->get('adressShippDist')['condado'];
      $regShip->zip_code = session()->get('adressShippDist')['cp'];
      $regShip->city = session()->get('adressShippDist')['ciudad'];
      $regShip->city_name = session()->get('adressShippDist')['ciudad'];
      $regShip->state = session()->get('adressShippDist')['estado'];
      $regShip->county = session()->get('adressShippDist')['condado'];
      $regShip->country_key = session()->get('adressShippDist')['clv_pais'];
      $regShip->email = session()->get('adressShippDist')['correo'];
      $regShip->telephone = session()->get('adressShippDist')['telefono'];
      $regShip->cell_number = session()->get('adressShippDist')['telefono'];
      $regShip->gender = null;
      $regShip->security_question_id = null;
      $regShip->answer = null;
      $regShip->kit_type = null;
      $regShip->document_key = null;
      $regShip->document_number = null;
    }
    $regShip->save();
    return true;
  }

  public function addUser($user,$id){
    $order = new registerOrderShipAddress();
    $order->where('order_id', $id->original['last_insert_id'])
      ->update(array('eo_number' => $user['usuario'],
        'password' => $user['contrasena']
      ));
    return true;
  }

  public  function getSegurityQuestionAnswer($eoId){
    $answer = $this->select('answer')
      ->where('eo_number', '=', $eoId)
      ->first();
    return $answer;
  }
}
