<?php

return array(
    'zfcuser' => array(
        'form_captcha_options' => array(
            'class'   => 'Zend\Captcha\ReCaptcha',
            'options' => array(
                'privkey' => '6LdWDvcSAAAAAAjhm56hU22-FmpXI1LXGveN0yo_',
                'pubkey'  => '6LdWDvcSAAAAAFjb7VFZFR47NMZYQL7t2saq28ua',
            ),
        ),
    ),

    'di' => array(
        'instance' => array(
            'alias' => array(
                'recaptcha_element' => 'Zend\Form\Element\Captcha',
            ),
            'ZfcUser\Form\Register' => array(
                'parameters' => array(
                    'captcha_element' => 'recaptcha_element',
                ),
            ),
        ),
    ),
);