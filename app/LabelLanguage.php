<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabelLanguage extends Model
{
    protected $table = 'labels_language';

    protected $primaryKey = 'labels_language_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'labels_language_id', 'label_id', 'language_id','name','created_at','updated_at','deleted_at','modified_by','estatus'
    ];

    public function label()
    {
        return $this->hasOne('App\Label', 'label_id','label_id');
    }

    public function language()
    {
        return $this->hasOne('App\Language', 'language_id','language_id');
    }

}
