Installation
============

Intaller les outils
-------------------

### GitHub
Il faut dans un premier temps créer un compte GitHub et forker le projet.
Installer ensuite [GitHub for Windows](http://windows.github.com/) et le configurer correctement avec vos identifiants GitHub. Dans les options, mettez **default storage directory** à :
    C:\wamp\www

### PHP
Il faut ensuite installer la dernière version de [Wamp](http://www.wampserver.com/). Ouvrir **wamp/bin/php/phpXXX/php.ini** et vérifier que ces lignes sont bien décommentées :
    short_open_tag = Off
    max_execution_time = 30   (augmenter ce chiffre si besoin)
    magic_quotes_gpc = Off
    magic_quotes_runtime = Off
    magic_quotes_sybase = Off
    extension=php_curl.dll
    extension=php_intl.dll
    extension=php_openssl.dll

Ouvrir la console et taper cette commande :
    php -v

Si il y a une erreur, aller dans **Panneau de configuration > Système et sécurité > Système > Paramètres système avancés > Variables d'environnement… > Variables système**. Double cliquez sur **Path** et collez à la fin de la ligne ceci en remplacant XXX par votre version:
    ;C:\wamp\bin\php\phpXXX

Vérifier que la commande **php -v** fonctionne bien.

### Composer
[Télécharger](http://getcomposer.org/download/) le fichier Composer-Setup.exe et l'installer.

Récupérer le code
-----------------

Depuis le logiciel GitHub, cliquer sur votre compte dans la collone de gauche puis cloner le projet hflan_v3 en cliquant sur **clone**. Vérifiez que le projet se trouve bien dans C:/wamp/www/hflan_v3

Finir l'installation
--------------------

Renomer le fichier **app/config/parameters.yml.dist** en **app/config/parameters.yml** puis modifier la ligne suivante avec le nom que vous voullez donner à la base de données :
    database_name: symfony

Installer les dépendances :
    composer install

Installer la base de données :
    php app/console doctrine:database:create
    php app/console doctrine:schema:update --force

Importer les [blocks](table_block.sql) dans la base de données à l'aide de [phpMyAdmin](http://localhost/phpmyadmin/)

Créer un utilisateur :
    php app/console fos:user:create admin admin@gmail.com admin
    php app/console fos:user:promote admin ROLE_ADMIN

Vider le cache :
    php app/console cache:clear

Tester le site : [localhost/hflan_v3/www/app_dev.php/](http://localhost/hflan_v3/www/app_dev.php/)
