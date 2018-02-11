<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Benefit
 *
 * @author sergio
 */
class Benefit extends Model {

    /**
     * Schema table name to migrate
     * @var string
     */
    protected $fillable = [];

    /**     *     * The name of the table that will be saving the data     *     * @var string     */
    protected $table = 'benefit';
    protected $primaryKey = 'benefit_id';

    public function products() {
        return $this->hasMany('Modules\Products\Entities\Product');
    }

    public function benefit() {
        return $this->belongsTo('Modules\Products\Entities\BenefitLanguage');
    }

}
