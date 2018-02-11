<?php 
return array(
        // QA
		//'client_id'=>'AR99GCOSifCJtV21-9ufZxrbEoHQt-yohn0wFtHfNiAx07PW5hOLuf4my1_hxakZ-HrxDwQgY1pnImcc',
		//'secret'=>'EGKxZ6EgmGd9i6Fo4xyQuD3aMNajnw5jKt1p98Tm7KvA_KHb2E2UfuTvE69P9WbzDtJuHf10yJ_cqQrX',
        'client_id' => 'AUoUj97i1s5axqmd7GgxgFPRd4hgZ7ue5kANoGtRDqi2fV-M4XLoa1B12LOH5iL1TBLRZb6sdTQBWdFU',
        'secret' => 'EParit5J9HFsgj7PSS1Ggpi6ThnFoCPV3YXDmHHD5c6057uVReE5EnCeVN_3xiJhqgy3Jjldyw05F96L',
		'settings'=>array(
			'mode'=>'sandbox',
			'http.ConnectionTimeOut'=>30,
			'log.LogEnabled'=> true,
			'log.FileName'=>storage_path() . '/logs/paypal.log',
			'log.LogLevel'=>'FINE'
		),
	);
