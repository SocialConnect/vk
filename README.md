# <img src="https://socialconnect.github.io/assets/icons/vk.png" width="27"> ВКонтакте SDK

[![Latest Stable Version](https://poser.pugx.org/SocialConnect/vk-sdk/v/stable.svg)](https://packagist.org/packages/SocialConnect/vk-sdk)
[![Build Status](https://travis-ci.org/SocialConnect/vk.svg?branch=master)](https://travis-ci.org/SocialConnect/vk)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SocialConnect/vk/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/SocialConnect/vk/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/SocialConnect/vk/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/SocialConnect/vk/?branch=master)
[![License](https://poser.pugx.org/SocialConnect/vk/license.svg)](https://packagist.org/packages/SocialConnect/vk)

Library for work with VK API.

Installation
------------

Add a requirement to your `composer.json`:

```json
{
    "require": {
        "socialconnect/vk": "~0.4"
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

## Get user with specified $id:

```php
$user = $vkService->getUser(1);
var_dump($user);
```

## Get users with specified array $ids:

```php
$users = $vkService->getUsers([1, 2]);
var_dump($users);
```

## Customs methods

```php
$parameters = [];
$result = $vkService->request('method/CustomMethod', $parameters);
if ($result) {
    var_dump($result);
}
```

## Custom entities

```php
class MyUserEntitiy extends \SocialConnect\Vk\Entity\User {
    public function myOwnMethod()
    {
        //do something
    }
}

$vkService->getEntityUser(new MyUserEntitiy());
$user = $vkService->getUser(1);

if ($user) {
    $user->myOwnMethod();
}
```

License
-------

This project is open-sourced software licensed under the MIT License. See the LICENSE file for more information.
