<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\User;
use Illuminate\Console\Command;

class MakeNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:notification {num=1}';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $num = max((int)$this->argument('num'), 1);

        $userIds = User::pluck('id')->all();
        $notifications = Notification::factory($num)->create();

        $notifications->each(function (Notification $notification) use ($userIds) {
            foreach(array_chunk($userIds, 100) as $chunk) {
                $insert = array_map(function ($userId) use ($notification) {
                    return [
                        'notification_id' => $notification->id,
                        'user_id' => $userId,
                    ];
                }, $chunk);
                NotificationUser::insert($insert);
            }
        });
    }
}
