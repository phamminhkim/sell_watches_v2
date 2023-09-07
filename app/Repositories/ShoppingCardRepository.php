<?php

namespace App\Repositories;

use App\Models\sell_watches\ShoppingCard;

class ShoppingCardRepository
{
    public function getAll()
    {
        
        return ShoppingCard::with(['product.images'])->get();
    }

    public function getById($id)
    {
        return ShoppingCard::find($id);
    }
    public function create($data)
    {
        return ShoppingCard::create($data);
    }
    public function update($id, $data)
    {
        $ShoppingCard = $this->getById($id);
        $ShoppingCard->update($data);
        return $ShoppingCard;
    }
    public function delete($id)
    {
        $ShoppingCard = $this->getById($id);
        $ShoppingCard->delete();
        return $ShoppingCard;
    }

}
