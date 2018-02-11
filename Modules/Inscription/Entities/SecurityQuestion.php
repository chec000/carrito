<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Inscription\Entities;
use Illuminate\Database\Eloquent\Model;
use Exception;
/**
 * Description of SecurityQuestion
 *
 * @author sergio
 */
class SecurityQuestion extends Model{
   protected $table = 'security_question_language';

   public  function getSegurityQuestion(){
           $questions = $this->select('security_question_language.question', 'security_question_language.language_id','security_question.country_id','security_question.security_question_id')
            ->join('security_question', 'security_question.security_question_id', '=', 'security_question_language.security_question_id')
            ->where('security_question.estatus', '=', 1)
            ->where('security_question_language.language_id', '=', session()->get('lang_id')->language_id)
            ->where('security_question.country_id', '=', session()->get('country_id')->country_id)
           ->get();
           return $questions;
   }
   public  function getSegurityQuestionById($id){
           $questions = $this->select('security_question_language.question', 'security_question_language.language_id','security_question.country_id','security_question.security_question_id')
            ->join('security_question', 'security_question.security_question_id', '=', 'security_question_language.security_question_id')
            ->where('security_question.security_question_id', '=', $id)
           ->first();
           return $questions;
   }
}
