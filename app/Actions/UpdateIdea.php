<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateIdea
{
    /**
     * Handle the creating of user's idea
     */
    public function handle(array $attributes, Idea $idea): void
    {
        $data = collect($attributes)->only([
            'title', 'description', 'status', 'links',
        ])->toArray();

        if ($attributes['image'] ?? false) {
            if ($idea->image_path) {
                Storage::disk('public')->delete($idea->image_path);
            }
            $data['image_path'] = $attributes['image']->store('ideas', 'public');
        }

        DB::transaction(function () use ($data, $attributes, $idea) {
            $idea->update($data);

            $idea->steps()->delete();
            $idea->steps()->createMany($attributes['steps'] ?? []);
        });
    }
}
