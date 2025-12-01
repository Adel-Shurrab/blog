<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isEditor() || $user->isAuthor();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Comment $comment): bool
    {
        if ($user->isAdmin() || $user->isEditor()) {
            return true;
        }

        return $user->isAuthor() && $comment->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isAuthor();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        if ($user->isAdmin() || $user->isEditor()) {
            return true;
        }

        return $user->isAuthor() && $comment->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        if ($user->isAdmin() || $user->isEditor()) {
            return true;
        }

        return $user->isAuthor() && $comment->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comment $comment): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return $user->isAdmin() || $user->isEditor();
    /**
     * Determine whether the user can view the model.
     */
    public static function getEloquentQuery(): Builder
    {
        $query = Comment::query();

        if (Auth::user()->isAuthor()) {
            return $query->where('user_id', Auth::id());
        }

        return $query;
    }
        return $query;
    }
}
