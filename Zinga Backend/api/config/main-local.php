<?php

$config = [
	'components' => [
		'request' => [
			'cookieValidationKey' => 'mycookievalidationkey',
			'parsers' => [
				'application/json' => 'yii\web\JsonParser',
			]
		]
	],
];

if (!YII_ENV_TEST) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] = 'yii\debug\Module';
	
	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = 'yii\gii\Module';
}


return [
	'components' => [
		'request' => [
			'cookieValidationKey' => 'mycookievalidationkey',
			'parsers' => [
				'application/json' => 'yii\web\JsonParser',
			]
		]
	],
	'bootstrap' => ['gii'],
	'modules' => [
		 'gii' => [
			  'class' => 'yii\gii\Module',
			  'allowedIPs' => ['127.0.0.1', '*:*:*'],
			  // here comes the addition configure for the extension
			  'generators' => [ // generators
					'restController' => [ // our new rest generator
						 'class' => 'deanisty\generators\controller\Generator', // generator class name
					]
			  ]
		 ],
		 // ...
	],
	// ...
];

// return $config;
