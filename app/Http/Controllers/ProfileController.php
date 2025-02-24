<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function avatarStore(Request $request)
    {
        $request->validate([
            'avatar' => 'required|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = Auth::user();
        $file      = $request->file('avatar');
        $extension = $file->extension();
        $filename  = Str::random(20) . '.' . $extension;
        $tempPath = public_path('images/temp/');
        $avatarPath =storage_path('app/public/avatars/');

        if (!File::exists($tempPath)) {
            File::makeDirectory($tempPath, 0755, true); // Create directory with 755 permissions
        }

        if (!File::exists($avatarPath)) {
            File::makeDirectory($avatarPath, 0755, true); // Create directory with 755 permissions
        }


        $image = Image::read($request->file('avatar'));
        // Main Image Upload on Folder Code
        $image->save($tempPath.$filename);

        // Generate Thumbnail Image Upload on Folder Code
        $thumbnailFullPath = $avatarPath.$filename;
        $image->resize(150,150);
        $image->save($thumbnailFullPath);
        // Delete the temporary main image file.
        if (file_exists($tempPath.$filename)) {
            unlink($tempPath.$filename);
        }

        // Build the public path (requires php artisan storage:link)
        $avatarUrl = asset('storage/avatars/' . $filename);

        // Optionally, remove the old avatar if it exists
        if ($user->avatar) {
            $oldAvatarPath = public_path(str_replace(asset(''), '', $user->avatar));
            if (File::exists($oldAvatarPath)) {
                File::delete($oldAvatarPath);
            }
        }

        // Save new avatar path in the user record
        $user->avatar = 'storage/avatars/' . $filename;
        $user->save();

        return response()->json([
            'success' => true,
            'avatar' => $avatarUrl,
            'message' => 'Avatar updated successfully.'
        ]);
    }

    public function update(Request $request)
    {
        // Update other profile info...
        $user = Auth::user();
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('name', 'email'));

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }
}
