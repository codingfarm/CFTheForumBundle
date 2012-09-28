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



