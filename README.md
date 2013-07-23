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

### Step 3: Configuration
```yml
# app/config/config.yml

cf_the_forum:
    db_driver: orm
    image:
        upload_dir: /uploads/forum/
        max_height: 400
        max_width: 700
    video:
        width: 459
        height: 341
    video_url_services:
        - forum.services.video.youtube
        - forum.services.video.rutube
        - forum.services.video.smotri
        - forum.services.video.vimeo
        - forum.services.video.ttk
    class:
        model:
            post: Application\ForumBundle\Entity\Post
            topic: Application\ForumBundle\Entity\Topic
            category: Application\ForumBundle\Entity\Category
        bridge:
            user_meta: Application\ForumBundle\Bridge\UserMeta
        permissions:
            service_class: Application\ForumBundle\Services\ForumPermissions
    bbcode_filters:
        - forum.bbcode_filter.main
        - forum.bbcode_filter.image
        - forum.bbcode_filter.video
        - forum.bbcode_filter.url
```

### Step 4: Implement model classes

#### Bridge

This class needed to provide the project specific user's data - name, avatar,...

```php
use CF\TheForumBundle\Bridge\UserMeta as AbstractUserMeta;

class UserMeta extends AbstractUserMeta
{

    /**
     * Return the name of the user
     *
     * @param $user
     *
     * @return string
     */
    public function getUsername($user)
    {
        return $user->getUsername();
    }

    /**
     * Return the picture's url of user's avatar
     *
     * @param $user
     *
     * @return string (/img/avatars/default.gif)
     */
    public function getUserAvatar($user)
    {
        // return $user->getAvatarSrc();
        return '/img/avatars/default.gif';
    }
}
```

