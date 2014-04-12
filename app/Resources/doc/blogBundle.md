BlogBundle
===========

Entités
-------

### Article

Un article est une news sur le site. Les extensions slugable, blamable, timestampable et uploadable sont utilisées.

Roles
-----

### ROLE_NEWSER

Permet de modifier et d'ajouter des articles.

### ROLE_REMOVE

Utilisé avec ROLE_NEWSER, il permet de supprimer des articles.

Twig
----

### string|stripHtml(length = 0)

Enlève toutes les balises HTML d'une chaine. Si length est plus grand que 0 et que la chaine est trop longue, alors elle serra tronqué au mot prêt et des points de suspensions sont ajoutés.

### string|nl2br

Le HTML est échappé. Remplace les retour à la ligne par des <br>. Remplace les retours à la ligne multiples par un nouveau paragraphe. La fonction retourne donc un ou plusieurs paragraphes.

### string|maxLength(length)

Tonque une chaine au caratère prêt pour ne pas qu'elle dépasse **length** caratères. Des points de suspensions sont ajoutés.

Form types
----------

### radiobar

Une raiobar est une petite barre horizontale qui permet de choisir parmis plusieur options. Elle hérite de **choice**.

### toggle

Par défaut un toggle est une checkbox stylisée (no JS). Voici les options par défaut du champ :

    'icons' => array(
        'inactive' => 'check-empty',
        'active' => 'check',
    ),
    'labels' => array(
        'inactive' => '',
        'active' => '',
    ),

Les icons sont simplement les nom des icons de fontawesome 3.xx.