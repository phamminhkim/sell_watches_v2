<?php

namespace App\Repositories;

use App\Models\sell_watches\Brand;

class BrandRepository
{
    public function getAll()
    {
        
        return Brand::all();
    }

    public function getById($id)
    {
        return Brand::find($id);
    }
    public function create($data)
    {
        return Brand::create($data);
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
