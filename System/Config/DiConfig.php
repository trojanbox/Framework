<?php
return array(
    // 数据库对象
    'capsule' => array(
    	'class' => 'Illuminate.Database.Capsule.Manager',
        'params' => array(
        	
        ),
        'actions' => array(
        	'addConnection' => array(
        	    array(
        	        'driver'    => 'mysql',
        	        'host'      => 'localhost',
        	        'database'  => '158news',
        	        'username'  => 'root',
        	        'password'  => '123456',
        	        'charset'   => 'utf8',
        	        'collation' => 'utf8_unicode_ci',
        	        'prefix'    => '',
        	    )
        	),
            'setEventDispatcher' => array(
            	'Illuminate.Events.Dispatcher',
                'Illuminate.Container.Container'
            )
        )
    ),
);