<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Authentication\Entities\Pdf_User;
use Mail;

class MailController extends Controller
{
  public static function send($to, $subject, $template, $parameters){
    $mail = 'mails.' . $template;
    $emailData = self::getEmaildata($parameters);
    $emailToSend = $to == "user" ? $emailData["userEmail"] : $emailData["sponsorEmail"];
    $user = $to == "user" ? $emailData["userName"] : $emailData["sponsorName"];
    if($template == "Welcome")
      $pdf = Pdf_User::getPdf($parameters["eo_number"]);

    Mail::send($mail, $parameters, function($message) use ($emailToSend, $user, $subject, $template){
      $message->to($emailToSend, $user)->subject($subject);
      $message->from("noreply@omnilife.com", 'Omnilife');
      if($template == "Welcome")
        $message->attachData(base64_decode($pdf), 'document.pdf', ['mime' => 'application/pdf',]);
    });
    return 'Email enviado con exito';
  }

  public static function getEmaildata($parameters){
  	$data = array();
    if(isset($parameters["resetPassword"])){
    	$data["userEmail"] = $parameters["resetPassword"]["email"];
	    $data["userName"] = $parameters["resetPassword"]["name"];
    }
    else if(!isset($parameters["cron"])){
    	$data["userEmail"] = session()->has('userId') ? session()->get('adressShippDist')["correo"] : session()->get('formReg')["email"];
	    $data["userName"] = session()->has('userId') ? session()->get('userName') : session()->get('formReg')["name"];
	    $data["sponsorEmail"] = session()->get('sponsor_selected') ? session()->get("sponsor")["eo_email"] : session()->get("sponsor_rnd")["eo_email"];
	    $data["sponsorName"] = session()->get('sponsor_selected') ? session()->get("sponsor")["eo_name"] : session()->get("sponsor_rnd")["eo_name"];
    }
    else{
    	$data["userEmail"] = $parameters["cron"]["user"]["email"];
	    $data["userName"] = $parameters["cron"]["user"]["name"];
	    $data["sponsorEmail"] = $parameters["cron"]["sponsor"]["email"];
	    $data["sponsorName"] = $parameters["cron"]["sponsor"]["name"];
    }
    return $data;
  }
}
