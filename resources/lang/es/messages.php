<?php

return [
    'message' => 'MENSAJE',
    'acDireccion'=>[
        'EXITO' => 'LOS DATOS HAN SIDO GUARDADOS CON ÉXITO',
        'ERROR_ACDIRECCIONES_CP_LENGTH' =>	'TAMAÑO DE CODIGO POSTAL INCORRECTO.', //'Este valor es retornado cuando la longitud de la cadena de codigo postal no es la esperada'
        'INFO_ACDIRECCIONES_EMPTY_RESPONSE' => 'FALLA DE SERVICIO, INTENTELO MAS TARDE.',	//'Este valor es retornado cuando el servicio no regresa respuesta'
        'ERROR_INACTIVADIRECCIONES_CANNOTSAVE_ADDRESS' =>	'REVISE SUS DATOS E INTENTELO MAS TARDE.',//'Este valor es retornado cuando no se pudo guardar la información de la direccion'
        'ERROR_ACDIRECCIONES_EMPTY_PARAMS' =>	'REVISE SUS DATOS, E INTENTELO MAS TARDE.',//'Este valor es retornado cuando alguno de los parametros de entrar nos es enviado (pais,estado)'
    ],
    'inactivaDireccion' =>[
        'EXITO' => 'LA DIRECCIÓN HA SIDO DESHABILITADA CON ÉXITO',
        'INFO_INACTIVADIRECCIONES_EMPTY_RESPONSE' => 'FALLA DE SERVICIO, INTENTELO MAS TARDE.', //Este valor es retornado cuando el servicio no regresa respuesta
        'ERROR_INACTIVADIRECCIONES_CANNOT_INACTIVE_ADDRESS' =>	'NO ES POSIBLE ELIMINAR ESTÁ DIRECCIÓN, PARA MÁS INFORMACIÓN PONTE EN CONTACTO CON "CREO"', //Este valor es retornado cuando no se pudo inactivar la direccion, son regresados en json los errores que ocurrieron
        'ERROR_INACTIVADIRECCIONES_EMPTY_PARAMS' => 'FALLA DE SERVICIO, POR FAVOR INTENTE MAS TARDE.', //Este valor es retornado cuando alguno de los parametros de entrar nos es enviado (pais,estado)
    ],
    'update_data' => [
        'EXITO' => 'LOS DATOS HAN SIDO ACTUALIZADOS CON ÉXITO.',
        'FAILED_UPDATE' => 'LOS DATOS NO SE PUDIERON ACTUALIZAR, REVISE SUS DATOS E INTENTELO MAS TARDE.',
        'UPDATE_ZIP' => 'CAMBIAR TU CÓDIGO POSTAL DE ENVÍO PUEDE MODIFICAR LA DISPONIBILIDAD DE PRODUCTO',
        'UPDATE_ADDRESS' => 'Desea cambiar su dirección de envío?. CAMBIAR TU CÓDIGO POSTAL DE ENVÍO PUEDE MODIFICAR LA DISPONIBILIDAD DE PRODUCTO'
    ]
];

