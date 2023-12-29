<?php

namespace App\Listeners;

use App\Events\UserPermissionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserPermissionListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserPermissionEvent $event): void
    {
        $user = $event->user  ;
        $permissions = $event->permissions['permissions'] ;

        $user->addRole('admin');
        $user->syncPermissions($permissions);
    }
}
