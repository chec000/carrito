<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogOrder extends Model{
//Conexion a base de datos
    public $connection ='mysql';

// La tabla usada por el modelo
    public $table = 'log_orden';




// Atributos que esta permitido modificar
    protected $fillable = ['order_id','orden','amount','points','tax_amount','error_corbiz','last_modifier','amount_new','points_new','tax_amount_new','last_modifier_new','updated_at','created_at'];

//Atributos excluidos en consultas JSON y otro tipo.
    protected $hidden = array();

// Indica llave primaria y elimina campos que agrega por default para el log de laravel en tablas
    protected $primaryKey = 'id';
}
