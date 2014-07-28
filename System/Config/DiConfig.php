<?php
return array(
    'test' => array(
        'class' => 'Application.Engine.DefaultEngine',
        'factory' => 'factory',
        'params' => array(
        	'Application.Engine.TwoEngine',
            'apapa',
            array(
        	   1
            )
        ),
        'actions' => array(
        	'setThree' => array(
                'test2'
            )
        ),
    ),
    'test2' => array(
        'class' => 'Application.Engine.ThreeEngine',
    )
);