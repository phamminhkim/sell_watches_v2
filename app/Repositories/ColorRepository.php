<?php

namespace App\Repositories;

use App\Models\sell_watches\Color;

class ColorRepository
{
    public function getAll()
    {
        
        return Color::all();
    }

    public function getById($id)
    {
        return Color::find($id);
    }
    public function create($data)
    {
        return Color::create($data);
    }
    public function update($id, $data)
    {
        $brand = $this->getById($id);
        $brand->update($data);
        return $brand;
    }
    public function delete($id)
    {
        $brand = $this->getById($id);
        $brand->delete();
        return $brand;
    }

}
