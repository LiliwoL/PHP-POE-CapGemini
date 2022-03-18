<?php

namespace App\BLL\Validator;

use Respect\Validation\Validator as v;

class ArticleValidator
{
    private array $errors = [];
    public function __construct(private $prixUnitaire, private $qteStock)
    {
    }

    public function isValid()
    {
        if (!v::numericVal()->positive()->validate($this->prixUnitaire)) {
            $this->errors['prixUnitaire'] = 'Le prix doit être au format numérique et ne peut pas être négatif';
        }
        if (!v::numericVal()->positive()->validate($this->qteStock)) {
            $this->errors['qteStock'] = 'Le stock doit être au format numérique et ne peux pas être négatif';
        }
        return count($this->errors) === 0;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
