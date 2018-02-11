<?php
/**
 * Created by PhpStorm.
 * User: alan.magdaleno
 * Date: 12/01/18
 * Time: 17:28
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class SecurityQuestionLanguage extends Model
{
    /**
     * Tabla asociada con el modelo
     *
     * @var string
     */

    public $connection ='mysql';

    public $table = 'security_question_language';

    protected $primaryKey = 'security_question_language_id';

    protected $fillable = ['security_question_language_id','language_id','security_question_id','question','created_at','updated_at','deleted_at','modified_by','estatus'];




    public function language()
    {
        return $this->hasOne('App\Language', 'language_id','language_id');
    }
}