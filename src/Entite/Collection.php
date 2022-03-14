<?php

namespace App\Entite;

use ArrayObject;

class Collection extends ArrayObject
{
    public function contains($item): bool
    {
        $i = $this->getIterator();

        while ($i->valid()) {
            if ($i->current() === $item) {
                return true;
            }
            $i->next();
        }

        return false;
    }

    public function remove($item): bool
    {
        $i = $this->getIterator();

        while ($i->valid()) {
            if ($i->current() === $item) {
                $this->offsetUnset($i->key());
                return true;
            }
            $i->next();
        }

        return false;
    }
}
