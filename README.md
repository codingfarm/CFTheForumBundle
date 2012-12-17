CFTheForumBundle
================

Requirements:
-------------

- KnpTimeBundle
- WysiBB fork https://github.com/jekill/WysiBB
- WhiteOctoberPagerfantaBundle
- KnockoutJS


Основные возможности и концепции
--------------------------------

Форум жестко не привязан к имеющейся системе авторизации, имеется зависимость только
от Symfony\Component\Security\Core\User\UserInterface, так что вы можете использовать любую реализацию,
FOSUserBundle - поддерживается.


Форум имеет три основных сущности:

- Категория
- Топик
- Пост

Инсталяция
----------

### Step 1: Download CFTheForumBundle using composer

Add CFTheBundle in your composer.json:

```js
{
    "require": {
        "codingfarm/the-forum-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update codingfarm/the-forum-bundle
```

Composer will install the bundle to your project's `vendor/codingfarm/the-forum-bundle/` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new CF\TheForumBundle\CFTheForumBundle(),
    );
}
```




