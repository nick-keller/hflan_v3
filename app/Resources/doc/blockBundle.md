BlockBundle
===========

Entités
-------

### Block

Un block est un élément de texte sur le site. Il a un slug unique et deux versions du texte : française et anglaise.

Roles
-----

### ROLE_BLOCK

Permet de modifier et voire la liste des blocks

### ROLE_ADMIN

Permet de créer un nouveau block (opération très rare).

Twig
----

### renderBlock(slug)

Cette fonction permet d'aler chercher un block en BDD à partir du slug et d'afficher la version correspondant à la locale de l'utilisateur. Si l'utilisateur possède le role ROLE_BLOCK alors un icon pour édité le block apparait.