# AfterBug for Yii Framework

[![StyleCI](https://styleci.io/repos/130384190/shield?style=flat)](https://styleci.io/repos/66539893)
[![Total Downloads](https://poser.pugx.org/afterbug/afterbug-yii/downloads)](https://packagist.org/packages/afterbug/afterbug-yii)
[![Latest Stable Version](https://poser.pugx.org/afterbug/afterbug-yii/v/stable)](https://packagist.org/packages/afterbug/afterbug-yii)
[![Latest Unstable Version](https://poser.pugx.org/afterbug/afterbug-yii/v/unstable)](https://packagist.org/packages/afterbug/afterbug-yii)
[![License](https://poser.pugx.org/afterbug/afterbug-yii/license)](https://packagist.org/packages/afterbug/afterbug-yii)

This library detects errors and exceptions in your Yii Framework application and reports them to AfterBug for alerts and reporting.

## Features

- Automatically report exceptions and errors
- Send customized diagnostic data
- Attach user information to determine how many people are affected by the error.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).


Either run

```
composer require afterbug/afterbug-yii "~1.0"
```

or Add `afterbug/afterbug-yii` to your composer.json

```
"afterbug/afterbug-yii": "~1.0"
```


## Usage

Once the extension is installed, simply modify your application configuration as follows:

```php
$config = [
    // ...
    'components' => [
        'afterbug' => [
            'class' => 'AfterBug\AfterBugYii\AfterBug',
            'apiKey' => 'YOUR_AFTERBUG_API_KEY',
        ],
        // ...
        'errorHandler' => [
            'class' => 'AfterBug\AfterBugYii\Exceptions\ErrorHandler',
            'errorAction' => 'site/error',
        ],
    ]
];
```

### Exclude exceptions

```php
$config = [
    // ...
    'components' => [
        'afterbug' => [
            'class' => 'AfterBug\AfterBugYii\AfterBug',
            'apiKey' => 'YOUR_AFTERBUG_API_KEY',
            'excludeExceptions' => ['yii\web\NotFoundHttpException']
        ],
    ]
];
```

### Callbacks

Set a callback to customize the data.

```php
$config = [
    // ...
    'components' => [
        'afterbug' => [
            'class' => 'AfterBug\AfterBugYii\AfterBug',
            'apiKey' => 'YOUR_AFTERBUG_API_KEY',
            'on beforeNotify' => function ($event) {
                $event->client->setMetaData([
                    'custom' => 'Your custom data',
                ]);
            }
        ],
    ]
];
```
