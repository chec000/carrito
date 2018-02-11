<?php

namespace Modules\Authentication\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Inscription\Entities\SecurityQuestion;
use Modules\Authentication\Entities\Passwordresets;
use Modules\Paypal\Entities\RegisterOrderShipAddress;
use Modules\Inscription\Http\Controllers\InscriptionController;
use App\Http\Controllers\MailController;
use App\UrlService;
use Carbon\Carbon;

class AuthenticationController extends Controller
{
  public function resetPassword($token = null){
    if($token != null){
      $passwordResetsObj = new Passwordresets();
      $tokenData = $passwordResetsObj->getToken($token);
      if(count($tokenData) > 0){
        if(Carbon::now() > $tokenData["expiry_at"]){
          $passwordResetsObj = new Passwordresets();
          $tokenData = $passwordResetsObj->deleteToken($token);
          $resetPasswordSession = self::getResetPasswordObject(false, "", "", "", "", "", "", "", "rejectReset", "");
        }else
          $resetPasswordSession = self::getResetPasswordObject(false, "", $tokenData["name"], $tokenData["email"], "", "", "", "", "confirmResetPassword", $token);
      }
      else
        $resetPasswordSession = self::getResetPasswordObject(false, "", "", "", "", "", "", "", "rejectReset", "");
      session()->put("resetPasswordSession", $resetPasswordSession);
    }
    elseif(session()->has("resetPasswordSession")){
      if(!session()->get("resetPasswordSession")["exito"])
        self::deleteSessionResetPassword();
    }

    return view('authentication::resetPassword');
  }

  public function validateEo(Request $request)
  {
    $data_eo = array(
      "metodo" => "resetPassword",
      "params" => array(
        "accion" => "GetData",
        "ideO" => $request["eoId"],
        "pais" => session()->get('country'),
        "password" => ""
      ));
    $response = UrlService::webService($data_eo);
    if(!$response["exito"])
      $resetPasswordSession = self::getResetPasswordObject(false, $request["eoId"], "", "", "", "", "", "Usuario no encontrado", "distributorNumber", "");
    else{
      $securityQuestionObj = new SecurityQuestion();
      $question = $securityQuestionObj->getSegurityQuestionById($response["data"]["pregunta"]);
      $registerOrderShipAddressObj = new RegisterOrderShipAddress();
      $answerQuestion = $registerOrderShipAddressObj->getSegurityQuestionAnswer($request["eoId"]);
      $resetPasswordSession = self::getResetPasswordObject(true, $request["eoId"], $response["data"]["nombre"], $response["data"]["correo"], $response["data"]["fecha_nac"], $question["question"], $answerQuestion["answer"], "", "resetOption", "");
      session()->put('resetPasswordSession', $resetPasswordSession);
    }
    return $resetPasswordSession;
  }


  public function getSessionResetPassword()
  {
    if (session()->has("resetPasswordSession"))
      return session()->get("resetPasswordSession");
    else{
      $resetPasswordSession = self::getResetPasswordObject("", "", "", "", "", "", "", "", "distributorNumber", "");
      return $resetPasswordSession ;
    }
  }

  public function deleteSessionResetPassword()
  {
    session()->forget("resetPasswordSession");
  }

  public function setSessionResetPassword(Request $request)
  {
    session()->put("resetPasswordSession", $request["resetPasswordSession"]);
  }

  public function getResetPasswordObject($exito, $eoId, $eoName, $email, $birthday, $question, $answerQuestion, $message, $stage, $token)
  {
    $resetObject = array(
      "exito" => $exito,
      "eoId" => $eoId,
      "eoName" => $eoName,
      "email" => $email,
      "birthday" => $birthday,
      "question" => $question,
      "answerQuestion" => $answerQuestion,
      "message" => $message,
      "stage" => $stage,
      "token" => $token,
    );
    return $resetObject;
  }

  public function resetPasswordEo(Request $request)
  {
    $data_eo = array(
      "metodo" => "resetPassword",
      "params" => array(
        "accion" => "reset",
        "ideO" => $request["eoId"],
        "pais" => session()->get('country'),
        "password" => $request["newPassword"]
      ));
    $resetPasswordObj = array(
      'email' => session()->get("resetPasswordSession")["email"],
      'name' => session()->get("resetPasswordSession")["eoName"]
    );
    $response = UrlService::webService($data_eo);
    MailController::send("user", "Reset password done", "successResetPassword", array(
      "eoName" => session()->get("resetPasswordSession")["eoName"],
      "eoEmail" => session()->get("resetPasswordSession")["email"],
      "resetPassword" => $resetPasswordObj));
    $passwordResetsObj = new Passwordresets();
    $tokenData = $passwordResetsObj->deleteToken(session()->get("resetPasswordSession")["token"]);
    self::deleteSessionResetPassword();
  }

  public function sendTokenEmail(Request $request)
  {
    $inscriptionControllerObj = new InscriptionController();
    $token = $inscriptionControllerObj->get_random_string(15);
    self::setToken($token);
    $resetPasswordObj = array(
      'email' => session()->get("resetPasswordSession")["email"],
      'name' => session()->get("resetPasswordSession")["eoName"]
    );
    MailController::send("user", "Reset password", "resetPassword", array(
      "eoName" => session()->get("resetPasswordSession")["eoName"],
      "eoEmail" => session()->get("resetPasswordSession")["email"],
      "token" => $token,
      "resetPassword" => $resetPasswordObj));
    self::deleteSessionResetPassword();
  }

  public function setToken($token)
  {
    $passwordResetsObj = new Passwordresets();
    $expirDate = (new Carbon())->addMinutes(10);
    $passwordResetsObj->setToken(
      session()->get("resetPasswordSession")["eoId"],
      session()->get("resetPasswordSession")["eoName"],
      session()->get("resetPasswordSession")["email"],
      $token,
      $expirDate
    );
  }

  public function index()
  {
    return view('authentication::index');
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create()
  {
    return view('authentication::create');

  }

  /**
   * Store a newly created resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function store(Request $request)
  {
  }

  /**
   * Show the specified resource.
   * @return Response
   */
  public function show()
  {
    return view('authentication::show');
  }

  /**
   * Show the form for editing the specified resource.
   * @return Response
   */
  public function edit()
  {
    return view('authentication::edit');
  }

  /**
   * Update the specified resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function update(Request $request)
  {
  }

  /**
   * Remove the specified resource from storage.
   * @return Response
   */
  public function destroy()
  {
  }
}
