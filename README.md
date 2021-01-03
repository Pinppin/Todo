# Framework PHP

Le framework étudié est Laravel, de la version 6 à 8. 

## Les objectifs de ce cours

- comprendre l'architecture du framework et les concepts
  - Structurer son code
  - Maîtriser l'accès aux données et leur persistance depuis un ORM 
  -  La notion de ressource et de routage
  - L'utilisation des contrôleurs
- Sécuriser son code  et gérer les autorisations applicatives
- Améliorer les temps de développement grâce aux outils du framework


## Les supports

Les supports seront réalisés pendant les cours et mis à  disposition sur moodle dès la fin du cours. 



## Les modalités d'évaluation

### Le code

Le code produit sera déposé de manière régulière sur git. 

Les critères d'évaluation du code seront les suivants : 

- code commenté
- passage de tests unitaires et d'intégration. 

Ces tests seront fournis au préalable et vous aiderons pendant les phases de développement. 

 ### Les concepts

En plus du code, vous fournirez pour chaque étapes clés un document expliquant les concepts mis en œuvre. Ce document devra entièrement être rédigé par vos soins. il sera passé à l'outil de détection de plagiat compilatio et le taux de similitude ne devra pas être supérieur à 15%, sous peine d'être rejeté et non évalué. 

## L'organisation du travail

Toute l'avancée sera réalisée sous forme de projet : à la fin des cours, vous aurez une application fonctionnelle développée tout au long du déroulement du module. 



### Sujet 

L'objectif sera de réaliser une application Web de gestion de tâche collaboratif. Pour utiliser cette application, l'utilisateur devra être enregistré et connecté. Une fois connecté, il pourra consulter/créer/modifier/supprimer des tâches, et y ajouter d'autres utilisateurs, enregistrés eux aussi. 

Une tâche possède un titre, une description, une date de fin (*due_date*),  un propriétaire (lui seul peut la supprimer), une priorité, un état, une catégorie et peut posséder plusieurs documents en pièces jointe. 

Une tâche peut être assignée à un de ces participants. 

Chaque utilisateur peut rajouter des commentaires sur les tâches. Son nom et l'heure et la date du commentaire doivent être gardé, et il est possible d'éditer le commentaire (cela sera marqué sur le commentaire qu'il a été édité) et même de le supprimer.

## Pour vous aider : 
- faire les fichiers de migrations : 

  - https://laravel.com/docs/8.x/migrations
  - Lire la doc pour concernant les bases de données : 

- faire les modèles Eloquents : https://laravel.com/docs/8.x/eloquent

  	- Lire la suite de la doc : il faut rajouter les relations : https://laravel.com/docs/8.x/eloquent-relationships

  Vous pouvez essayer de générer des données au moyen de seeders  et/ou de factories : https://laravel.com/docs/8.x/seeding

Un blog très pertinent  : http://laravel.sillo.org/ 

## Le mcd de l'application

[mcd]: https://raw.githubusercontent.com/NF-yac/todo-b2-20-21/master/database/mcd/todo.svg "MCD de l'application"





## TP Final

étape 1 :

j'ai rajouter l'affichage des taches lorsque l'on est sur le board car avant on était obligé de passer par la création de tache pour voir les tâches dans la vue show de board.

étape 2 : 

j'ai dans un premier temps regarder le fichier use-case pour voir quel régle mettre en place puis j'ai crée ma policy avec php artisan make:policy -m Task TaskPolicy puis j'ai complété les policies pour correspondre aux attentes.

étape 3 :

J'ai essayer de faire les commentaires mais je ne comprend pas comment savoir si tout fonctionne j'ai tester des choses mais sans succés.


