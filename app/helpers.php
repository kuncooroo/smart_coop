<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('user_notifications')) {
    function user_notifications() {
        return Auth::user()?->unreadNotifications;
    }
}

if (!function_exists('notif_count')) {
    function notif_count() {
        return Auth::user()?->unreadNotifications->count() ?? 0;
    }
}