<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Collection;

class NotificationService
{
    public function create(int $userId, string $title, string $message): void
    {
        Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'is_read' => false,
        ]);
    }

    public function createUnique(int $userId, string $title, string $message): void
    {
        $alreadyExists = Notification::where('user_id', $userId)
            ->where('title', $title)
            ->where('message', $message)
            ->exists();

        if ($alreadyExists) {
            return;
        }

        $this->create($userId, $title, $message);
    }

    public function notifyStudents(string $title, string $message, bool $unique = true): void
    {
        $studentIds = User::query()
            ->where('access_level', '!=', 1)
            ->pluck('id');

        $this->notifyMany($studentIds, $title, $message, $unique);
    }

    public function notifyAdmins(string $title, string $message, bool $unique = false): void
    {
        $adminIds = User::query()
            ->where('access_level', 1)
            ->pluck('id');

        $this->notifyMany($adminIds, $title, $message, $unique);
    }

    public function notifyMany(Collection $userIds, string $title, string $message, bool $unique = true): void
    {
        foreach ($userIds as $userId) {
            if ($unique) {
                $this->createUnique((int) $userId, $title, $message);
                continue;
            }

            $this->create((int) $userId, $title, $message);
        }
    }
}
