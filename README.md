ВКонтакте SDK
=============
[![Latest Stable Version](https://poser.pugx.org/SocialConnect/vk-sdk/v/stable.svg)](https://packagist.org/packages/SocialConnect/vk-sdk)
[![Build Status](https://travis-ci.org/SocialConnect/vk-sdk.svg?branch=master)](https://travis-ci.org/SocialConnect/vk-sdk)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SocialConnect/vk-sdk/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/SocialConnect/vk-sdk/?branch=master)
[![Coverage Status](https://img.shields.io/coveralls/SocialConnect/vk-sdk.svg)](https://coveralls.io/r/SocialConnect/vk-sdk?branch=master)
[![License](https://poser.pugx.org/SocialConnect/vk-sdk/license.svg)](https://packagist.org/packages/SocialConnect/vk-sdk)

Library for work with VK API.

Installation
------------

Add requirement to your `composer.json`:

```json
{
    "require": {
        "socialconnect/vk-sdk": "~0.2"
    }
}
```

Run the composer installer:

```bash
php composer.phar install
```

How to use
----------

First you need to create service:

```php
// Your Vk Application Settings
$appId = 123456;
$appSecret = 'secret';

$vkService = new \SocialConnect\Vk\Client($appId, $appSecret);
$vkService->setHttpClient(new \SocialConnect\Common\Http\Client\Curl());
```


License
-------

This project is open-sourced software licensed under the MIT License. See the LICENSE file for more information.
