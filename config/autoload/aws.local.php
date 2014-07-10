<?php

return array(
    /**
     * You can define global configuration settings for the SDK as an array. Typically, you will want to a provide your
     * credentials (key and secret key) and the region (e.g. us-west-2) in which you would like to use your services.
     */
    'aws' => array(
        'key'    => 'AKIAIGNEBVLB2ZNDA7RQ',
        'secret' => 'kcmqxyziJ175fFcGLxTtWNXKpJZ+SIEtOu9lbj8Z',
        'region' => 'eu-west-1'
    ),

    /**
     * You can alternatively provide a path to an AWS SDK for PHP config file containing your configuration settings.
     * Config files can allow you to have finer-grained control over the configuration settings for each service client.
     */
    // 'aws' => 'path/to/your/aws-config.php'
);
