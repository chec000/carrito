<?php

namespace Modules\Authentication\Entities;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Exception;

class Passwordresets extends Model
{
  public function deleteToken($token) {
    if(strlen($token)>0)
      $this->where('token', $token)->delete();
  }

  public function setToken($eoId, $eoName, $eoEmail,$token, $expirDate) {
    $passwordReset = new Passwordresets;
    $passwordReset->distribuidor = $eoId;
    $passwordReset->name = $eoName;
    $passwordReset->email  = $eoEmail;
    $passwordReset->token = $token;
    $passwordReset->expiry_at = $expirDate;
    $passwordReset->save();
  }

  public function getToken($token) {
    try {
      $tokenData = $this->select('*')
        ->where('token', '=', $token)
        ->get()
        ->first();
    } catch (Exception $ex) {
      return null;
    }
    return $tokenData;
  }
}
