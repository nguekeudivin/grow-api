<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class Image extends Model
{
    protected $fillable = [
        "url",
        "path",
        "imageable_type",
        "imageable_id"
    ];

    public function deleteWithFile(): bool|null
    {
        if ($this->path && Storage::disk('public')->exists($this->path)) {
            Storage::disk('public')->delete($this->path);
        }

        return $this->delete();
    }

    public static function handleDataUrl($dataUrl)
    {

        if (preg_match('/^data:image\/(\w+);base64,/', $dataUrl, $type)) {
            $data = substr($dataUrl, strpos($dataUrl, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif, etc.

            // Decode the base64 string
            $data = base64_decode($data);

            if ($data === false) {
                return null;
            }

            // Generate a unique file name
            $fileName = Str::random(40) . '.' . $type;
            $filePath = 'images/' . $fileName;

            return [
                'data' => $data,
                'path' => $filePath
            ];

        } else {
            return null;
        }
    }
}
