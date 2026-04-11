<?php

namespace App\Repositories;

use App\Contracts\OrderRepositoryInterface;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    public function findByUser(int $userId): Collection
    {
        return Order::with('items.product')->where('user_id', $userId)->orderBy('created_at', 'desc')->get();
    }

    public function findById(int $id): ?Order
    {
        return Order::with('items.product', 'user')->findOrFail($id);
    }

    public function create(array $data): Order
    {
        $order = Order::create([
            'user_id' => $data['user_id'],
            'total_price' => $data['total_price'],
            'status' => 'pending'
        ]);

        foreach ($data['items'] as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price']
            ]);
        }

        return $order;
    }

    public function updateStatus(int $id, string $status): Order
    {
        $order = $this->findById($id);
        $order->update(['status' => $status]);
        return $order;
    }

    public function getPendingOrders(): Collection
    {
        return Order::with('items.product', 'user')->where('status', 'pending')->orderBy('created_at', 'asc')->get();
    }
}
