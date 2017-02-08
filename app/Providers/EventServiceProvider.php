<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\HomeworkType;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            // add your listeners (aka providers) here
            'SocialiteProviders\CMU\CMUExtendSocialite@handle',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        // Set new homework id
        HomeworkType::creating(function($homeworktype){
            $last_homework_id = HomeworkType::max('id');
            $homeworktype->id = str_pad(++$last_homework_id,3,'0',STR_PAD_LEFT);
        });
        HomeworkType::saving(function($homeworktype){
            $last_homework_id = HomeworkType::max('id');
            $homeworktype->id = str_pad(++$last_homework_id,3,'0',STR_PAD_LEFT);
        });
    }
}
