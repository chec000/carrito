<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Category
 *
 * @author sergio
 */
class Category extends Model {

    /**
     * Schema table name to migrate
     * @var string
     */
    protected $fillable = [];
    protected $primary_key = 'category_id';
    protected $table = 'category';
  
}
