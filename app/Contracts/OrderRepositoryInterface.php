<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Order;

interface OrderRepositoryInterface
{
    public function findByUser(int $userId): Collection;
    public function findById(int $id): ?Order;
    public function create(array $data): Order;
    public function updateStatus(int $id, string $status): Order;
    public function getPendingOrders(): Collection;
}
