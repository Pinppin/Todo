# CRUD board

## Pour faire un CRUD il nous fait : 
Enregistrer les routes dans le fichier `routes/web.php`. 
Elles appellerons une méthode d'un contrôleur. 
Les routes peuvent être nommées (et c'est mieux si elles le sont)

Les contrôleurs sont créés avec la commande : 
`php artisan make:controller BoardController --model=Board`

La différence entre un contrôleur API et un contrôleur ressource, c'est que le contrôleur ressource a 2 méthodes en plus : `edit` et `create`. 