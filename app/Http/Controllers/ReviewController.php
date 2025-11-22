<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Show reviews (in contact/review page)
    public function index()
    {
        // Admins can see all reviews, users see all reviews too
        $reviews = Review::with(['user', 'menu'])
            ->latest()
            ->paginate(5);

        $menus = Menu::all();

        return view('review', compact('reviews', 'menus'));
    }

    // Store review
    public function store(Request $request)
    {
        // Only users (not admins) can create reviews
        if (Auth::user()->role === 'admin') {
            abort(403, 'Admin tidak dapat membuat review.');
        }

        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        // Check if user already reviewed this menu
        $existingReview = Review::where('user_id', Auth::id())
            ->where('menu_id', $request->menu_id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan review untuk produk ini.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'menu_id' => $request->menu_id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Review berhasil ditambahkan!');
    }

    // Update review
    public function update(Request $request, Review $review)
    {
        // Only users (not admins) can update their own reviews
        if (Auth::user()->role === 'admin') {
            abort(403, 'Admin tidak dapat mengupdate review.');
        }

        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        $review->update($request->only(['rating', 'komentar']));

        return back()->with('success', 'Review berhasil diperbarui!');
    }

    // Delete review
    public function destroy(Review $review)
    {
        // Only users (not admins) can delete their own reviews
        if (Auth::user()->role === 'admin') {
            abort(403, 'Admin tidak dapat menghapus review.');
        }

        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Review berhasil dihapus!');
    }
}
