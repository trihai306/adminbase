<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('shop.{id}', function ($user, $id) {
    return $user->id == $id;
});

Broadcast::channel('shop.threads.{id}', function ($user, $id) {
    return true;
});

Broadcast::channel('shop.payments.{id}', function ($user, $id) {
    return true;
});

Broadcast::channel('shop.{id}.card-exchanges', function ($user, $id) {
    return $user->id == $id;
});

Broadcast::channel('shop.{id}.notifications', function ($user, $id) {
    return $user->id == $id;
});

Broadcast::channel('admin.{id}', function ($user, $id) {
    return $user->id == $id && $user->is_admin;
});

Broadcast::channel('admin.threads.{id}', function ($user, $id) {
    return $user->is_admin;
});

Broadcast::channel('admin.{id}.notifications', function ($user, $id) {
    return $user->id == $id && $user->is_admin;
});
