<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Voir ses propres commandes (Client)
     */
    public function myOrders()
    {
        $userId = Auth::guard('api')->id();
        return response()->json($this->orderRepository->findByUser($userId));
    }

    /**
     * Passer une commande (Client)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0'
        ]);

        $validated['user_id'] = Auth::guard('api')->id();

        $order = $this->orderRepository->create($validated);

        return response()->json(['message' => 'Commande validée !', 'order' => $order], 201);
    }

    /**
     * Annuler une commande en attente (Client)
     */
    public function cancel($id)
    {
        $order = $this->orderRepository->findById($id);

        if ($order->user_id !== Auth::guard('api')->id()) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        if ($order->status !== 'pending') {
            return response()->json(['error' => 'Impossible d\'annuler une commande déjà traitée'], 422);
        }

        $order = $this->orderRepository->updateStatus($id, 'cancelled');
        return response()->json(['message' => 'Commande annulée', 'order' => $order]);
    }

    /**
     * Liste des commandes à préparer (Employé/Admin)
     */
    public function pendingOrders()
    {
        // Vérification stricte du rôle
        $user = Auth::guard('api')->user();
        if ($user->role === 'customer') {
            return response()->json(['error' => 'Accès Employé requis'], 403);
        }

        return response()->json($this->orderRepository->getPendingOrders());
    }

    /**
     * Changer le statut d'une commande (Employé/Admin)
     */
    public function updateStatus(Request $request, $id)
    {
        $user = Auth::guard('api')->user();
        if ($user->role === 'customer') {
            return response()->json(['error' => 'Accès Employé requis'], 403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,prepared,delivered,cancelled'
        ]);

        $order = $this->orderRepository->updateStatus($id, $validated['status']);
        
        return response()->json(['message' => 'Statut mis à jour', 'order' => $order]);
    }
}
