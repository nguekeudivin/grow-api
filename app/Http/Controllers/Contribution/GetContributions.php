<?php

namespace App\Http\Controllers\Contribution;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contribution; // ✅ Import the Contribution model
use Illuminate\Http\JsonResponse; // (optional) for return type clarity

class GetContributions extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $query = Contribution::with(['user', 'project']);

        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $contributions = $query->orderBy('amount', 'desc')->get();

        return response()->json([
            'contributions' => $contributions
        ]);
    }
}
