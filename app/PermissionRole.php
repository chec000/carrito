<?php
/**
 * Created by PhpStorm.
 * User: joseosuna
 * Date: 23/11/16
 * Time: 4:55 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    /**
     * Tabla asociada con el modelo
     *
     * @var string
     */

    public $connection ='mysql';

    public $table = 'permission_role';

    protected $primaryKey = 'permission_id';

    protected $fillable = ['permission_id', 'role_id'];

    public $timestamps = false;
}
