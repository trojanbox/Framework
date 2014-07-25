<?php
return array(
    'test' => array(
        'class' => 'Application.Engine.DefaultEngine',
        'params' => array(
            'test2',
            'test4',
            array(
            	123,4235
            )
        ),
    ),
    'test2' => array(
    	'class' => 'Application.Engine.TwoEngine',
        'params' => array(
        	'test3'
        )
    ),
    'test3' => array(
    	'class' => 'Application.Engine.ThreeEngine',
        
    ),
    'test4' => array(
    	'class' => 'Application.Engine.FourEngine'
    )
);