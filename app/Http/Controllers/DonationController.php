<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonationRequest;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    // GET /api/donations?per_page=10
    public function index(Request $request)
    {
        $donations = Donation::where('user_id', $request->user()->id)
            ->orderBy('date', 'desc')
            ->paginate($request->integer('per_page', 10));

        return response()->json($donations);
    }

    // POST /api/donations
    public function store(StoreDonationRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $donation = Donation::create($data);

        return response()->json($donation, 201);
    }

    // GET /api/donations/{id}
    public function show(Request $request, int $id)
    {
        $donation = Donation::where('user_id', $request->user()->id)->findOrFail($id);
        return response()->json($donation);
    }

    // DELETE /api/donations/{id}
    public function destroy(Request $request, int $id)
    {
        $donation = Donation::where('user_id', $request->user()->id)->findOrFail($id);
        $donation->delete();
        return response()->json(null, 204);
    }
}
