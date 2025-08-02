<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchUser extends Controller
{
    public function __invoke(Request $request)
    {
        $eighteenYearsAgo = now()->subYears(18)->format('Y-m-d');

        $validator = Validator::make($request->all(), [
            'firstname' => 'sometimes|required|string|max:255',
            'lastname' => 'sometimes|required|string|max:255',
            'birth_date' => 'nullable|date',
            'phone_number' => 'nullable|string|max:20',
            'city_id' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'image' => 'nullable|file',
            'about' => 'nullable|string',
            'looking' => 'nullable|string',
            'occupation' => 'nullable|string|max:255',
               'birth_date' => ['required', 'date', 'before_or_equal:' . $eighteenYearsAgo]
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = User::find($request->user()->id);

        // Update the attributes.
        $user->update($request->only(["firstname", "lastname", "birth_date", "phone_number", "city_id", "area", "about", "looking", "occupation"]));

        // check for interets.
        if ($request->has('interests')) {
            $user->interests()->sync($request->interests);
        }

        // Check for the image
        if ($request->has('image')) {
            // delete the current image.
            $currentImage = Image::where('imageable_type', User::class)->where('imageable_id', $user->id)->first();
            if ($currentImage) {
                $currentImage->deleteWithFile();
            }


            // Update the new one.
            $path =  $request->file('image')->store('images', 'public');
            $image = $user->image()->create([
                'url' => url(Storage::url($path)),
                'path' => Storage::url($path),
                'imageable_type' => User::class,
                'imageable_id' => $user->id
            ]);

            $user->load('image');
        }

        return response()->json($user);
    }
}
