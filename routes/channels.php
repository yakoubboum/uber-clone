<?php

use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });
// Broadcast::channel('test', function () {
//     return true;
// });

Broadcast::channel('test', function ($user) {
    return true;
});
