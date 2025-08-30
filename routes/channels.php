<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth; // Make sure this is imported

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// THIS IS THE MOST IMPORTANT PART FOR THE CHAT
Broadcast::channel('livechat.{userId}', function ($user, $userId) {
    // Return true if the authenticated user is the user for this channel
    // OR if the authenticated user is an admin.
    return $user->id == $userId || $user->is_admin;
});