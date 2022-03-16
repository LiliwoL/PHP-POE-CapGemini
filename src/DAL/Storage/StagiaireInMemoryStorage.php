<?php

namespace App\DAL\Storage;

class StagiaireInMemoryStorage implements StagiaireStorage
{
    // Méthodes spécifiques pour le stockage In Memory
    
    // Constructeur spécifique car pas de base de données
    // Constructeur à la sauce PHP 8 qui définit directement les attributs
    /*
        Idem à:

        private array $data;
        public function __construct( $data ){
            $this->data = $data;
        }

    */
    public function __construct(private array $data = [] ){}
    
    public function insert(
        string $nom
    ): int
    {
        // Ajout d'une case dans le tableau $data

        // 1. Récup de l'identifiant de l'utilisateur à ajouter
        // correspond à la taille +1
        $identifiant = count($this->data) + 1;

        // 2. Ajout dans le tableau
        $this->data[] = [
            'identifiant' => $identifiant,
            'nom' => $nom
        ];

        // 3. On doit renvoyer un entier
        return $identifiant;
    }

    public function find(int $id): ?array
    {
        // On va parcouri le tableau $this->data
        // a la recherche de l'identifiant qui correspon au paramètre $id
        // $data correspondra au stagiaire trouvé
        $data = array_filter(
            $this->data,
            // Fonction de rappel pour chaque élément
            // On lui fournit en plus $id qui vient d'en dehors du contexte du array_filter
            // https://www.php.net/manual/fr/functions.anonymous.php
            function ($elementEnCours) use ($id) {
                return $elementEnCours['identifiant'] === $id;
            }
        );

        // On a trouvé?
        if (count($data) === 1){
            // On ne renvoie que la case 0
            // @TODO: ?
            return $data[0];
        }

        return null;
    }


    public function findAll(): array
    {
        return $this->data;
    }

    public function update(
        string $nom,
        int $id,
    )
    {
        // Parcours du tableau à la recherche de $id
        foreach( $this->data as $key => $stagaire )
        {
            if ( $stagiaire['identifiant'] === $id )
            {
                // Modification de la RECOPIE de la case en cours
                $stagiaire['nom'] = $nom;

                // Mise à jour dans le tableau
                $this->data[$key] = $stagiaire;

                // On a trouvé et modifié, on sort
                break;
            }
        }
    }

    public function delete(int $id): int
    {
        // Parcours du tableau à la recherche de $id
        foreach( $this->data as $key => $stagaire )
        {
            if ( $stagiaire['identifiant'] === $id )
            {
                // Effacement dans le tableau
                unset($this->data[$key]);

                return 1;
            }
        }

        return 0;
    }
}
