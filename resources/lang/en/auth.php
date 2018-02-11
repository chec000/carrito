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

  'failed' => 'These credentials do not match our records.',
  'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
  'resetPassword' => [
    'title' => 'Recover your password',
    'dist_instruction' => 'Enter your distributor number',
    'contact' => 'Contact us',
    'choose_method_instruction' => 'How would you like to recover your password?',
    'option' => 'Choose an option',
    'support' => 'If you need assistance',
    'continue' => 'Continue',
    'cancel' => 'Cancel',
    'receive_email' => 'We will send you directions to your email address that ends in :',
    'receive_email_title' => 'Receive an email',
    'secret_question' => 'Answer the security question you chose when you registered.',
    'secret_question_title' => 'Answer your security question',
    'reset_password' => 'Recover password',
    'answer' => 'Answer',
    'enter_code' => 'Enter verification code',
    'enter_code_continue' => 'Enter code to continue',
    'email_sent' => 'Check your email for the verification code we sent you',
    'birthdate_instruction' => 'Confirm your birthdate',
    'question_instruction' => 'Answer this security question that you chose when you registered',
    'enter_password' => 'Enter a new password for',
    'new_password' => 'New password (4 digits)',
    'confirm_password' => 'Confirm password',
    'password_disclaimer' => 'Avoid passwords that you use on other websites or that someone else can guess easily.',
    'password_changed' => 'Password reset successful',
    'password_for' => 'Your Omnilife password for',
    'password_haschanged' => 'has changed.',
    'login_disclaimer' => 'You can now log in to your account with your new password.',
    'login' => 'Start session',
    'not_found' => 'Page not found',
    'dist_required' => 'Distributor number is required.',
    'method_required' => 'The reset method is required.',
    'code_required' => 'The verification code is required.',
    'birthdate_required' => 'The birthdate is required.',
    'question_required' => 'The answer for secret question is required.',
    'fields_required' => 'There are required fields missing. Please check the data and try again.',
    'following_errors' => 'The following errors has occurred:',
    'dist_not_found' => 'Distributor not found.',
    'no_ajax' => 'The request is not an AJAX request.',
    'request_inactive' => 'This request is not active. Please restart the process.',
    'email_subject' => 'Reset Password request in Omnilife',
    'email_sent_ok' => 'We have e-mailed your password reset code.',
    'email_subject_success' => 'Your Omnilife account password has been reset.',
    'error_ocurred' => 'An error ocurred. Please try again.',
    'question_found' => 'Secret question found.',
    'question_not_found' => 'Secret question not found. Please contact us for help.',
    'code_correct' => 'Verification code correct.',
    'code_incorrect' => 'Verification code incorrect.',
    'data_incorrect' => 'Data incorrect.',
    'birthdate_incorrect' => 'The birthdate does not match with the records, please try again.',
    'question_correct' => 'Secret question correct.',
    'dist_found' => 'Distributor # :dist_num found',
    'sesion_expired' => 'The session has expired.',
    'success' => 'Reset password success.',
    'no_email_question' => 'It is necessary an email or a secret question established to recover your password, please ',

    'email' => 'Email',
    'birthdate' => 'Birthdate',
    'dist_num' => 'Distributor Number',
    'code' => 'Verification code',
    'reset_method' => 'Reset Method',
    'a_question' => 'Answer for Secret Question',
    'password' => 'Password',
    'password_confirm' => 'Password confirm',

    'email' => [
      'grettings' => 'Dear :name',
      'heading' => "We have received your request to reset your password. To complete this process, enter the following verification code in the password reset webpage.",
      'heading_sub' => "",
      'footer_sub' => "If you did not make this update request, please notify us at :email to resolve any inconvenience.",
      'footer' => 'Best regards,',
      'footer_omni' => "Team Omnilife",
      'success' => [
        'heading' => "We'd like to confirm that the password for your account (:email) has been successfully updated",
        'heading_sub' => "If you did not request this reset, please notify us at :email to resolve any inconvenience.",
      ]
    ],
    'errors' => [
      'birthday' => 'Wrong date of birth',
      'wrongAnswer' => 'Wrong secret question answer',
      'passwordLength' => 'The password must be of 4 characters',
      'passwordMatch' => 'Passwords do not match',
      'code' => 'The code has expired or does not exist'
    ]
  ]
];
