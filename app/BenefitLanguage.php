<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BenefitLanguage extends Model
{
    protected $table = 'benefit_language';

    protected $primaryKey = 'benefit_language_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'benefit_language_id', 'benefit_id', 'language_id','benefit','created_at','updated_at','deleted_at','modified_by','estatus'
    ];

    public function language()
    {
        return $this->hasOne('App\Language', 'language_id','language_id');
    }

}
