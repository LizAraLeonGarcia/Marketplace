<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'reviewable_type' => 'required|string', // 'producto' o 'user'
            'reviewable_id' => 'required|integer',
        ]);
        // Determinar el tipo de modelo al que se asigna la reseña
        $reviewableType = match ($request->reviewable_type) {
            'product' => Product::class,
            'user' => User::class,
        };

        $reviewable = $reviewableType::findOrFail($request->reviewable_id);
        // Crear la reseña
        $reviewable->reviews()->create([
            'review' => $request->review,
            'rating' => $request->rating,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Reseña creada exitosamente');
    }
}
