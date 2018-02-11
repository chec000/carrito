<?php

return [
    'message' => 'MESSAGE',
    'acDireccion'=>[
        'EXITO' => 'THE DATA HAS BEEN SAVED WITH SUCCESS.',
        'ERROR_ACDIRECCIONES_CP_LENGTH' =>	'INCORRECT ZIP CODE.', //'Este valor es retornado cuando la longitud de la cadena de codigo postal no es la esperada'
        'INFO_ACDIRECCIONES_EMPTY_RESPONSE' => 'FAILURE OF SERVICE, TRY IT LATER.',	//'Este valor es retornado cuando el servicio no regresa respuesta'
        'ERROR_INACTIVADIRECCIONES_CANNOTSAVE_ADDRESS' =>	'CHECK YOUR DATA AND TRY IT LATER.',//'Este valor es retornado cuando no se pudo guardar la información de la direccion'
        'ERROR_ACDIRECCIONES_EMPTY_PARAMS' =>	'CHECK YOUR DATA AND TRY IT LATER.',//'Este valor es retornado cuando alguno de los parametros de entrar nos es enviado (pais,estado)'
    ],
    'inactivaDireccion' =>[
        'EXITO' => 'THE ADDRESS HAS BEEN DELETED SUCCESSFULLY.',
        'INFO_INACTIVADIRECCIONES_EMPTY_RESPONSE' => 'FAILURE OF SERVICE, TRY IT LATER.', //Este valor es retornado cuando el servicio no regresa respuesta
        'ERROR_INACTIVADIRECCIONES_CANNOT_INACTIVE_ADDRESS' =>	'IT IS NOT POSSIBLE TO ELIMINATE THIS ADDRESS, FOR MORE INFORMATION CONTACT "CREO', //Este valor es retornado cuando no se pudo inactivar la direccion, son regresados en json los errores que ocurrieron
        'ERROR_INACTIVADIRECCIONES_EMPTY_PARAMS' => 'FAILURE OF SERVICE, TRY IT LATER.', //Este valor es retornado cuando alguno de los parametros de entrar nos es enviado (pais,estado)
    ],
    'update_data' => [
        'EXITO' => 'THE DATA HAS BEEN UPDATED SUCCESSFULLY.',
        'FAILED_UPDATE' => 'THE DATA CAN NOT BE UPDATED, CHECK YOUR DATA AND TRY IT LATER.',
        'UPDATE_ZIP' => 'CHANGING YOUR ZIPCODE MAY MODIFY THE AVAILABILITY OF THE PRODUCT',
        'UPDATE_ADDRESS' => 'DO YOU WANT TO CHANGE YOUR SHIPPING ADDRESS? CHANGE YOUR POSTAL SHIPPING CODE CAN MODIFY PRODUCT AVAILABILITY'
    ]
];

