<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class GetProjects extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Project::with(['location.division', 'location.country']);

        if ($request->has('user_id')) {
            $user = User::find($request->user_id);

            if ($user) {
                $query->whereIn('association_id', function ($q) use ($user) {
                    $q->select('association_id')
                      ->from('association_users') // ✅ your custom table
                      ->where('user_id', $user->id);
                });
            }
        }

        $projects = $query->get();

        return response()->json([
            'projects' => $projects
        ]);
    }
}
