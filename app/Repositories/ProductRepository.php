<?php

namespace App\Repositories;

use App\Models\sell_watches\Product;
use App\Models\sell_watches\Image;


class ProductRepository
{
    public function getAll()
    {

        return Product::with(['images', 'brand', 'category', 'color'])->get();
    }

    public function getById($id)
    {
        return Product::with(['images', 'brand', 'category', 'color'])->find($id);
    }
    public function create($data)
    {

        $create = Product::create($data);
        if (!isset($data['images'])) {
            return $create;
        } else {
            $images = $data['images'];
            foreach ($images as $image) {
                $randomName = uniqid();
                $imagePath = 'images/' . $randomName;
                $imageExtension = pathinfo($image['name'], PATHINFO_EXTENSION); // Lấy đuôi tệp từ tên gốc
                $imagePathWithExtension = $imagePath . '.' . $imageExtension; // Tạo tên tệp với đuôi
                $base64Data = substr($image['path'], strpos($image['path'], ",") + 1);
                $imageData = base64_decode($base64Data);
                file_put_contents($imagePathWithExtension, $imageData);

                Image::create([
                    'imageable_id' => $create->id,
                    'imageable_type' => Product::class,
                    'path' => $imagePathWithExtension,
                ]);
            }
            return $create;
        }
    }
    public function update($id, $data)
    {
        $product = $this->getById($id);
        $product->update($data);
        if ($product) {
            $images = $data['images'];
            foreach ($images as $image) {
                $randomName = uniqid();
                $imagePath = 'images/' . $randomName;
                $imageExtension = pathinfo($image['name'], PATHINFO_EXTENSION); // Lấy đuôi tệp từ tên gốc
                $imagePathWithExtension = $imagePath . '.' . $imageExtension; // Tạo tên tệp với đuôi
                $base64Data = substr($image['path'], strpos($image['path'], ",") + 1);
                $imageData = base64_decode($base64Data);
                file_put_contents($imagePathWithExtension, $imageData);

                Image::create([
                    'imageable_id' => $product->id,
                    'imageable_type' => Product::class,
                    'path' => $imagePathWithExtension,
                ]);
            }
            $image_dels = $data['image_dels'];
            foreach ($image_dels as $image_del) {
                $image = Image::find($image_del['id']);
                if ($image) {
                    if (file_exists($image->path)) {
                        unlink($image->path);
                    }
                    $image->delete();
                }
            }
        }
        return $product;
    }
    public function delete($id)
    {
        $product = $this->getById($id);
        $product->delete();
        if($product){
            $images = $product->images;
            foreach ($images as $image) {
                if (file_exists($image->path)) {
                    unlink($image->path);
                }
                $image->delete();
            }
        }
        return $product;
    }
}