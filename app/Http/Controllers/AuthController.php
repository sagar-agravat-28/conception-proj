<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate input including image file
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'avatar' => 'nullable|mimes:jpg,png|max:2048'
        ]);

        $filename = null;
        if ($request->hasFile('avatar')) {
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
        }
       $avatarPath = $filename ? 'storage/avatars/' . $filename : null;

        // Create the user with hashed password
        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'avatar' => $avatarPath,
        ]);

        Auth::login($user);
        return redirect()->route('products.index');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Rate limit key based on IP address
        $key = 'login_attempts_' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors(['email' => 'Too many login attempts. Please try again later.']);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Successful login, clear rate limiter
            RateLimiter::clear($key);
            return redirect()->route('products.index');
        }

        RateLimiter::hit($key, 60);
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login.form');
    }
}
