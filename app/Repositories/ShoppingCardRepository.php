<?php

namespace App\Repositories;

use App\Models\sell_watches\ShoppingCard;
use App\Models\sell_watches\Product;

class ShoppingCardRepository
{
  public function getAll()
  {
    $user = auth()->user();
    $query = ShoppingCard::query()->with(['product.images']);
    $query = $query->where('user_id', $user->id);
    $shopping = $query->get();
    return $shopping;
    // return ShoppingCard::with(['product.images'])->get();
  }

  public function getById($id)
  {
    return ShoppingCard::find($id);
  }
  public function create($data, $user)
  {
    $product = Product::where('id', $data['product_id'])->first();
    if ($product) {
      $price = $product->price;
      $total_price = $price * $data['quantity'];
      $check_product_id = ShoppingCard::where('product_id', $data['product_id'])->where('user_id', $user->id)->first();
      if ($check_product_id) {
        $quantity = $check_product_id->quantity;
        $sum_quantity = $quantity + $data['quantity'];
        $total_price = $price * $sum_quantity;
        $check_product_id->update([
          'quantity' => $sum_quantity,
          'total_price' => $total_price,
        ]);
        return $check_product_id;
      } else {
        $re = ShoppingCard::create([
          'user_id' => $user->id,
          'product_id' => $data['product_id'],
          'quantity' => $data['quantity'],
          'total_price' => $total_price,
        ]);
        return $re;
      }

    }
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

  public function count()
  {
    return ShoppingCard::count();
  }

  public function increasing_quantity_shoppingcard($id)
  {
    $shoppingcard = ShoppingCard::where('id', $id)->first();
    if ($shoppingcard) {
      $product = Product::where('id', $shoppingcard->product_id)->first();
      if ($product) {
        $price = $product->price;
        $quantity = $shoppingcard->quantity;
        $sum_quantity = $quantity + 1;
        $total_price = $price * $sum_quantity;
        $shoppingcard->update([
          'quantity' => $sum_quantity,
          'total_price' => $total_price,
        ]);
        return $shoppingcard;
      }
    }
  }

  public function reduce_quantity_shoppingcard($id)
  {
    $shoppingcard = ShoppingCard::where('id', $id)->first();
    if ($shoppingcard) {
      $product = Product::where('id', $shoppingcard->product_id)->first();
      if ($product) {
        $price = $product->price;
        $quantity = $shoppingcard->quantity;
        $sum_quantity = $quantity - 1;
        $total_price = $price * $sum_quantity;
        $shoppingcard->update([
          'quantity' => $sum_quantity,
          'total_price' => $total_price,
        ]);
        return $shoppingcard;
      }
    }
  }

}