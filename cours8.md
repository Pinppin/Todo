# Cours #8 : 04/12/2020

## Procédure de clonage du projet : 
On clone le projet.

`git clone https://github.com/NF-yac/todo-b2-20-21`

Le récupère la branche b2a : 
```sh
cd todo-b2-20-21/
git branch b2a
git checkout b2a
git pull origin b2a
```


Il faut maintenant installer les dépendances du projet : 
```sh 
composer install
```

On créée le fichier d'environnement `.env`
```sh
 cp .env.example .env
 ```
 On l'édite en renseignant les informations relatives à la BDD
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_b2
DB_USERNAME=laravel
DB_PASSWORD=l4R4V3l
```
Si besoin on génère une clé d'API : 
```sh
php artisan key:generate
# Application key set successfully.

```

Si vous avez récupéré le projet dans un projet déjà existant, il faut faire attention que les fichiers de migrations n'apparaissent pas en double. 
Comme les fichiers de migrations ont un timestamp dans leur nom, ils « cohabitent » sans se remplacer et empêche le bon fonctionnement de la migration. Il est recommandé de déplacer vos fichiers dans un sous-répertoire (les sous répertoires ne sont pas pris en compte au moment de la migration). 


On peut maintenant migrer
```sh
php artisan migrate:fresh # fresh car dans mon cas la base existe déjà
```

Pour obtenir les « assets » propres aux templates de connexion/enregistrement (dans le cas ou les styles appliqués) : 
```sh
npm install && npm run dev
```

## Réalisation du CRUD : Task


### Contrôleur et routes
Première étape : génération du contrôleur en mode `resource`, sur le modèle `Task` : 
```sh 
php artisan make:controller TaskController --model=Task
```

Avant d'implémenter les fonctions, nous allons créer les routes en mode ressources, rajoutant dans le fichier `routes/web.php` la ligne suivante : 
```sh
Route::resource("/tasks", TaskController::class)->middleware('Auth');
```
On met le middleware auth pour que les tâches accessibles qu'aux utilisateurs connectés. 

### Les vues 


On peut s'inspirer des vues créées pour le board. 


#### Étape 1 : la création d'une tâche
On va tout d'abord remplir la vue `tasks.create` qui nous donnera le formulaire de création d'une tâche.
Dans le formulaire de création, on ne s'occupe pas de l'état du board, on le gèrera à l'édition. 

Puis on remplit la fonction du contrôleur qui renvoi cette vue. 
La vue a besoin de connaître l'utilisateur, pour pouvoir accéder à sa liste de board. 

Dans la méthode store, nous allons devoir valider les champs du formulaire contenus dans la requête. 
Nous allons créer directement la tâche à partir du tableau des données de la requête validée. 
Pour cela, nous allons effectuer une assignation de masse. 
Il faut dans le modèle `Task` créer le champ : `protected $fillable = [ ];` qui est un tableau indiquant toutes les propriétés de la tâche que l'on peut assigner en masse : https://laravel.com/docs/8.x/eloquent#mass-assignment

##### Variante : 
On pourrait directement créer une tâche pour un board donné, avec une url de la forme `boards/1/tasks/create`. 
Commençons par créer 2 routes dans `routes\web.php` : une pour le formulaire, une pour la création. 
On les associe à deux nouvelles méthodes du contrôleur : `createFromBoard` et `storeFromBoard`, que l'on va rajouter. 
La première renvoi un nouvelle vue contenant le formulaire de création, sans la liste déroulante qui permet de choisir le board. On l'appelle `boards.tasks.create`, elle sera donc stockées dans un sous répertoire `tasks` dans le répertoire `boards`. 

TODO : le reste. 

#### Étape 2 : BoardUser 
BoardUser est un modèle pivot qui permet de gérer les participants d'un board. 
Par défaut le propriétaire d'un board est déjà dedans (cf cours#7).

À partir d'un board, on veut pouvoir ajouter des utilisateurs et les supprimer et c'est tout. 

On va faire en sorte de pouvoir ajouter un utilisateur depuis l'affichage de la board. 
On modifie la vue d'affichage d'un board : `boards.show`, pour rajouter une liste déroulant avec tous les utilisateurs qui ne sont pas déjà dans le board. 
On doit donc modifier le contrôleur du board pour "passer" cette liste d'utilisateur à la vue. 

On doit donc créer le contrôleur BoardUser et la route qui permet d'appeler la méthode d'ajout

#### Pour la prochaine fois. 

Finir les contrôleurs TaskController, BoardController, et faire TaskUser. 

Il faudrait pouvoir faire en sorte que seul le propriétaire d'un board puisse ajouter/supprimer des utilisateurs : 
https://laravel.com/docs/8.x/authorization

Vous serez surtout attentif aux policies. 

On fera aussi en sorte de finir notre todo : à savoir quand on ajoute une tache à un board, il faut vérifier que le board auquel appartient la tâche appartient aussi à l'utilisateur qui fait cet ajout : fonction `store` et `storeFromBoard`. 

