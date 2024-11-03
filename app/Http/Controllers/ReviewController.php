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
            'reviewable_type' => 'required|string',
            'reviewable_id' => 'required|integer',
        ]);

        // Identifica el modelo al que pertenece la reseña
        switch ($request->reviewable_type) {
            case 'order':
                $reviewable = Order::findOrFail($request->reviewable_id);
                break;
            case 'product':
                $reviewable = Product::findOrFail($request->reviewable_id);
                break;
            case 'user':
                $reviewable = User::findOrFail($request->reviewable_id);
                break;
            default:
                return redirect()->back()->withErrors(['invalid_type' => 'Tipo de reseña no válido']);
        }

        // Crear la reseña
        $review = $reviewable->reviews()->create([
            'review' => $request->review,
            'rating' => $request->rating,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Reseña creada exitosamente');
    }
}
