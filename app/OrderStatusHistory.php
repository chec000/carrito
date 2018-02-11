<?php
/**
 * Created by PhpStorm.
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model{
    //Conexion a base de datos
    public $connection ='mysql';

    // La tabla usada por el modelo
    public $table = 'order_status_history';

    // Atributos que esta permitido modificar
    protected $fillable = ['id','order_id','payment_type_id','status_id','created_at','last_modifier'];

    //Atributos excluidos en consultas JSON y otro tipo.
    protected $hidden = array();

    // Indica llave primaria y elimina campos que agrega por default para el log de laravel en tablas
    protected $primaryKey = 'id';

    public $timestamps = false;
}