<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('my-channel', function ($user) {
return true; // or add any authentication logic if needed
});
