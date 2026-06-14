<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function count()
    {
        return response()->json([
            'count' => auth()->user()->unreadNotifications()->count(),
        ]);
    }

    public function list()
    {
        return response()->json([
            'notifications' => auth()->user()
                ->unreadNotifications()
                ->latest()
                ->take(10)
                ->get()
                ->map(fn ($notification) => [
                    'id' => $notification->id,
                    'title' => $notification->data['title'] ?? 'Уведомление',
                    'message' => $notification->data['message'] ?? '',
                    'url' => $notification->data['url'] ?? '#',
                    'type' => $notification->data['type'] ?? 'system',
                    'created_at' => optional($notification->created_at)->diffForHumans() ?? '',
                ]),
        ]);
    }

    public function read($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        return response()->json([
            'success' => true,
        ]);
    }

    public function readAll()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return response()->json([
            'success' => true,
        ]);
    }

    public function markByData(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'key' => 'required|string',
            'value' => 'required',
        ]);

        auth()->user()
            ->unreadNotifications()
            ->get()
            ->filter(function ($notification) use ($request) {
                return ($notification->data['type'] ?? null) === $request->type
                    && (string) ($notification->data[$request->key] ?? '') === (string) $request->value;
            })
            ->each(function ($notification) {
                $notification->markAsRead();
            });

        return response()->json([
            'success' => true,
        ]);
    }
}