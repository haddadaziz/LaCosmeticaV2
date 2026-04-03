<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Authentifie un utilisateur et retourne un JWT.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Identifiants invalides'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Inscrit un utilisateur, le connecte et retourne un JWT.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create(array_merge(
            $validated,
            ['password' => Hash::make($request->password)]
        ));

        // Connecte l'utilisateur immédiatement après inscription
        $token = Auth::guard('api')->login($user);

        return response()->json([
            'message' => 'Utilisateur inscrit avec succès',
            'user' => $user,
            'token_info' => $this->respondWithToken($token)->original
        ], 201);
    }

    /**
     * Retourne les détails de l'utilisateur connecté.
     */
    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    /**
     * Déconnecte l'utilisateur (invalide le JWT).
     */
    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json(['message' => 'Déconnexion réussie']);
    }

    /**
     * Rafraîchit un token expiré.
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    /**
     * Formate la réponse JSON contenant le token JWT.
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }
}
