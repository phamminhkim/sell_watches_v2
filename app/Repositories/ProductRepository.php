<?php

namespace App\Repositories;

use App\Models\sell_watches\Product;
use App\Models\sell_watches\ShoppingCard;
use App\Models\sell_watches\Image;


class ProductRepository
{
    public function getAll($request)
    {
        $query = Product::with(['images', 'brand', 'category', 'color']);
        if ($request->filled('start_price') && $request->filled('end_price')) {
            $query->whereBetween('price', [$request->start_price, $request->end_price]);
        }
        if ($request->filled('gender')) {
            $query->where('gender',  $request->gender);
        }
        $product = $query->get();
        return $product;
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
            $check_card = ShoppingCard::where('product_id', $product->id)->first();
            if ($check_card) {
                $check_card->update([
                    'total_price' => $product->price * $check_card->quantity,
                ]);
            }
            $images = $data['images'];
            foreach ($images as $image) {
                if ($image['id'] == null) {
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
        if ($product) {
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
