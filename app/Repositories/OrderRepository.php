<?php

namespace App\Repositories;

use App\Models\sell_watches\ShoppingCard;
use App\Models\sell_watches\Product;
use App\Models\sell_watches\Order;
use App\Models\sell_watches\OrderDetail;



class OrderRepository
{
  public function getAll()
  {
    $user = auth()->user();
    $query = Order::query()->with(['order_details.product.images']);
    $query = $query->where('user_id', $user->id);
    $order = $query->get();
    return $order;
  }

  public function getById($id)
  {
    return Order::find($id);
  }
  public function create($data, $user)
  {
    $create = Order::create(
      [
        'user_id' => $user->id,
        'order_date' => date('Y-m-d'),
        'shipping_address' => $data['shipping_address'],
        'payment_method' => $data['payment_method'],
        'status' => 'pending',
      ]
    );
    if ($create) {
      $order_details = $data['order_details'];
      foreach ($order_details as $order_detail) {
        $create_detail = OrderDetail::create([
          'order_id' => $create->id,
          'product_id' => $order_detail['product_id'],
          'quantity' => $order_detail['quantity'],
          'price' => $order_detail['product']['price'],
          'total_price' => $order_detail['total_price'],
        ]);
        if ($create_detail) {
          $check_shopping_card = ShoppingCard::where('user_id', $user->id)
            ->where('product_id', $order_detail['product_id'])->first();
          if ($check_shopping_card) {
            $check_shopping_card->delete();
          }
          $check_quantity_product = Product::find($order_detail['product_id']);
          $check_quantity_product->quantity = $check_quantity_product->quantity - $order_detail['quantity'];
          $check_quantity_product->save();
        }

      }
    }
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