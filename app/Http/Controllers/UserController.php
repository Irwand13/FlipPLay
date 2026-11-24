<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('media')->paginate(10);

        return UserResource::collection($users);
    }

    public function show(User $user)
    {
        $user->load('media');

        return new UserResource($user);
    }

    public function addToCollection(Request $request, User $user)
    {
        $validated = $request->validate([
            'media_id' => 'required|exists:media,id',
        ]);

        if ($user->media()->where('media_id', $validated['media_id'])->exists()) {
            return response()->json([
                'message' => 'Media sudah ada di koleksi pengguna ini.',
            ], 409);
        }

        $user->media()->attach($validated['media_id']);

        return (new UserResource($user->load('media')))->response()->setStatusCode(201);
    }

    public function removeFromCollection(User $user, Media $media)
    {
        if (! $user->media()->where('media_id', $media->id)->exists()) {
            return response()->json([
                'message' => 'Media tidak ada di koleksi pengguna ini.',
            ], 404);
        }

        $user->media()->detach($media->id);

        return response()->noContent();
    }
}
