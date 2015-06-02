yii2-ssdb
===========

Yii2-ssdb - a Yii 2.0 SSDB extension

##Requirements

Yii 2.0 or above

##Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

    composer.phar require "ijackwu/yii2-ssdb":"*"

##Configuration

To use this extension, you have to configure the Connection class in your application configuration:

```php
return [
    //....
    'components' => [
        'redis' => [
            'class' => 'ijackwu\ssdb\Connection',
            'host' => 'localhost',
            'port' => 8888,
        ],
    ]
];
```