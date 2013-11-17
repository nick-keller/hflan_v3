LanBundle
===========

Entités
-------

### Event

Un évènement représente une LAN, avec un prix et des dates. L'extension slugable est utilisé.

### EventExport

Cette entité n'est pas persisté en BDD. Elle permet juste de sélectionner les joueurs a exporter our générer une mailing list.

### ExtraField

Ce sont les champs spécifiques à chaque tournois, avec un nom, un placeholder et une regex ou une liste des choix.

### Player

Un player représente un joueur physique, avec nom, prénom, etc... Tous les champs spécifiques au tournois auquel le joueur est inscrit sont stockés dans la propriété extraFields qui est un tableau dont les clefs sont les id de l'ExtraField.

### Team

Une team représente une équipe de joueurs. Les tournois solo possèdent donc des équipes de 1 joueur. La propriété infoLocked indique si une équipe a vérouillé ses infos. La propriété paid indique si une équipe à payé.

### Tournament

Représente un tournoi avec un nom, un nombre d'équipe, un jeu, etc...

Roles
-----

### ROLE_RESPO

Permet de modifier et d'ajouter tout ce beau monde.

### ROLE_REMOVE

Utilisé avec ROLE_RESPO, il permet de supprimer des choses.

### ROLE_ADMIN

Permet de modifier des evènement et des tournois même quand des joueurs sont déjà inscrits.

Twig
----

### DateTime|countdown

Transforme une date en chaine de charactère. PAr exemple : dans un peut plus d'une heure, il y a 2 minutes...

### DateTime|simpleDate(separator = '/')

Transforme une date en 'jj/mm/aaaa' ou 'mm/dd/yyyy' selon la locale de l'utilisateur.

### weekend(DateTime from, DateTime to)

Génère une chaine de caractère du type : le weekend du 14 au 15 décembre, du 31 janvier au 1 février...

### dateRange(DateTime from, DateTime to)

Génère une chaine de caractère du type : du 10 au 25 décembre, du 20 janvier au 17 février...

### nextEvent()

Retourne le prochain évènement ou null si aucun évènement n'est trouvé.

Form types
----------

### datepicker

Permet de sélectionner une date avec un calendrier.

### extrafield

Formulaire pour les champs spécifiques.

Services
--------

### CsvGenerator

Génère un CSV pour un tournoi avec la liste des joueurs de la liste définitive.

### ExtraFieldsFormFactory

Génère un formulaire pou rles champs spéciaux d'un Player.

### TeamManager

Permet de créer des équipes avec le nombre de joueurs nécéssaire et d'envoyer un mail lors de l'inscription.