<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('post.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('post.created', function ($user) {
    return true; // Allow all authenticated users to listen to this channel
});

Broadcast::channel('post.deleted', function ($user) {
    return true; // Allow all authenticated users to listen to this channel
});