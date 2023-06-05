<?php

namespace App\Traits;

trait CheckAuthorized
{
    protected function IsNotAuthorized($project)
    {
        if (auth()->user()->id !== $project->author->id) {
            return response()->json([
                'message' => 'You are not authorized to make this request',
                'status' => 403
            ], 403);
        }
    }
}
