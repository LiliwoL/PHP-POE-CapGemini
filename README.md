# TP 1

## Enoncé

On demande ici de créer les entités correspondantes au diagramme de classe fourni.

***

## Initialisation de composer

```bash
composer init
```


### Utilisation de composer pour l'autoloading

Dans les projets en PHP, nous avons souvent besoin d’un système d’autoloading.

Au lieu de créer de zéro ce système d’autoloading en PHP, il suffit d’initialiser composer et de l’utiliser simplement.

#### Autoloading et namespace

On modifie la ligne
    
    "autoload": {
        "psr-4": {
            /* On modifie ceci pour notre autoload */
            "Eni\\Tp1\\": "src/"
        }
    
par

    "autoload": {
        "psr-4": {            
            "App\\": "src/"
        }
    },

#### Fichier principal du projet

Le fichier principal du projet **index.php** contiendra:

    <?php
    require dirname(__DIR__).'/vendor/autoload.php';

#### Namespace

Dans les classes du dossier **src/**, on pourra définir le namespace avec:

    <?php
    namespace App\Entite;


#### Dump de l'autoload

Dans le cas où l'autoload e composer n'est pas correct, vous pouvez faire un **dump**:

    composer dump

***

