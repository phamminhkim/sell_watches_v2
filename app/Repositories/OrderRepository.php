<?php

namespace App\Repositories;

use App\Models\sell_watches\ShoppingCard;
use App\Models\sell_watches\Product;
use App\Models\sell_watches\Order;


class OrderRepository
{
    public function getAll()
    {
        
        return Order::all();
    }

    public function getById($id)
    {
        return Order::find($id);
    }
    public function create($data)
    {
        $create = Order::create($data);
        return $create;
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
