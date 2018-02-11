<?php

namespace Modules\Authentication\Entities;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Exception;

class Pdf_User extends Model
{
  protected $table = 'pdf_user';

  public static function getPdf($eo_number) {
    try {
      $pdf = $this->select('*')
        ->where('eo_number', '=', $eo_number)
        ->get()
        ->first();
    } catch (Exception $ex) {
      return null;
    }
    return $pdf;
  }
}
