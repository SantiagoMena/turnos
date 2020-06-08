<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=mysql;dbname=turnos',
    'username' => 'turnos',
    'password' => 'turnos',
    'charset' => 'utf8',


    'on afterOpen' => function($event) {
  //       if (Yii::$app->user->isGuest) {
  //           return;
  //       }
  //   	$cookies = Yii::$app->request->cookies;
		// $timeZoneId = $cookies->getValue('time_zone', 12);
		// $timeZone = TimeZones::findOne($timeZoneId);
        $event->sender->createCommand("SET SESSION time_zone = '-3:00';")->execute();
        // $event->sender->createCommand("SET @@global.time_zone = '-5:00';")->execute();
        $event->sender->createCommand("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));")->execute();
    }

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
