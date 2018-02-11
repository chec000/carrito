<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
     */

  'failed' => 'Estas credenciales no coinciden con nuestros registros.',
  'throttle' => 'Demasiados intentos de inicio de sesión. Por favor intente de nuevo en :seconds segundos.',
  'resetPassword' => [
    'title' => 'Recupera tu contraseña',
    'dist_instruction' => 'Ingresa tu número de distribuidor',
    'contact' => 'Contáctanos',
    'choose_method_instruction' => '¿Cómo deseas reestablecer tu contraseña?',
    'option' => 'Elige una opción',
    'support' => 'Si necesitas ayuda por favor',
    'continue' => 'Continuar',
    'cancel' => 'Cancelar',
    'receive_email' => 'Enviaremos instrucciones a tu correo que termina en:',
    'receive_email_title' => 'Recibir un correo electrónico',
    'secret_question' => 'Responde la pregunta de seguridad que elegiste al registrarte.',
    'secret_question_title' => 'Responder a pregunta de seguridad',
    'dist_num' => 'Número de Distribuidor',
    'code' => 'Código de verificación',
    'reset_password' => 'Recupera tu contraseña',
    'answer' => 'Respuesta',
    'enter_code' => 'Ingresa el código de verificación',
    'enter_code_continue' => 'Ingresa el código para continuar',
    'email_sent' => 'Revisa en tu correo el código de verificación que te enviamos',
    'birthdate_instruction' => 'Confirma tu fecha de nacimiento',
    'question_instruction' => 'Responde a esta pregunta de seguridad que elegiste al registrarte',
    'enter_password' => 'Ingresa una contraseña nueva para',
    'new_password' => 'Nueva contraseña (4 dígitos)',
    'confirm_password' => 'Confirmar contraseña',
    'password_disclaimer' => 'Evita las contraseñas que utilizas en otros sitios web o que alguien pueda adivinar con facilidad.',
    'password_changed' => 'Contraseña reestablecida correctamente',
    'password_for' => 'Tu contraseña de Omnilife para',
    'password_haschanged' => 'ha cambiado',
    'login_disclaimer' => 'Ya puedes ingresar a tu cuenta con tu nueva contraseña.',
    'login' => 'Iniciar sesión',
    'not_found' => 'Página no encontrada',
    'dist_required' => 'El Número de Distribuidor es obligatorio.',
    'method_required' => 'El método para restablecer contraseña es obligatorio.',
    'code_required' => 'El código de verificación es obligatorio.',
    'birthdate_required' => 'La fecha de nacimiento es obligatorio.',
    'question_required' => 'La respuesta a la pregunta secreta es obligatoria.',
    'fields_required' => 'Hay campos obligatorios, por favor revisa los datos.',
    'following_errors' => 'Han ocurrido los siguientes errores:',
    'dist_not_found' => 'El Distribuidor no existe.',
    'no_ajax' => 'La petición no es un objeto AJAX.',
    'request_inactive' => 'Esta petición no está activa. Por favor reinicia el proceso.',
    'email_subject' => 'Solicitud para restablecer contraseña en Omnilife',
    'email_sent_ok' => 'Te hemos enviado un código de verificación para restablecer la contraseña.',
    'email_subject_success' => 'Se restableció la contraseña de tu cuenta Omnilife.',
    'error_ocurred' => 'Ha ocurrido un error. Por favor intenta de nuevo.',
    'question_found' => 'Pregunta secreta encontrada.',
    'question_not_found' => 'Pregunta secreta no encontrada. Por favor contacte al CREO para recibir ayuda.',
    'code_correct' => 'Código de verificación correcto.',
    'code_incorrect' => 'Código de verificación incorrecto.',
    'data_incorrect' => 'Los datos son incorrectos.',
    'birthdate_incorrect' => 'La fecha de nacimiento no concuerda con los registros, por favor intenta de nuevo',
    'question_correct' => 'Respuesta correcta.',
    'dist_found' => 'Distribuidor :dist_num encontrado',
    'sesion_expired' => 'La sesión ha expirado.',
    'success' => 'Contraseña restablecida con éxito.',
    'no_email_question' => 'Para restablecer su contraseña es necesario un correo electrónico o una pregunta secreta, por favor ',
    'email' => 'Correo electrónico',
    'birthdate' => 'Fecha de nacimiento',
    'dist_num' => 'Número de distribuidor',
    'code' => 'Código de verificación',
    'reset_method' => 'Método',
    'a_question' => 'Respuesta a la pregunta secreta',
    'password' => 'Contraseña',
    'password_confirm' => 'Confirmación de la contraseña',
    'email' => [
      'grettings' => ':name',
      'heading' => "Hemos recibido tu solicitud de recuperación de contraseña, para completar este proceso ingresa el siguiente código de verificación en la página de restablecimiento de contraseña.",
      'heading_sub' => "",
      'footer_sub' => "Si tú no solicitaste esta actualización te pedimos contactes a :email para resolver cualquier inconveniente.",
      'footer' => 'Saludos cordiales,',
      'footer_omni' => "Equipo Omnilife",
      'success' => [
        'heading' => "Te confirmamos que la contraseña en tu cuenta (:email) ha sido actualizada exitosamente.",
        'heading_sub' => "Si tu no solicitaste esta actualización te pedimos contactes a :email para resolver cualquier inconveniente.",
      ]
    ],
    'errors' => [
      'birthday' => 'Fecha de nacimiento incorrecta',
      'wrongAnswer' => 'Respuesta de pregunta secreta incorrecta',
      'passwordLength' => 'La contraseña debe ser de 4 caracteres',
      'passwordMatch' => 'Las contraseñas no coinciden',
      'code' => 'El código ha expirado o no existe'
    ]
  ]
];
