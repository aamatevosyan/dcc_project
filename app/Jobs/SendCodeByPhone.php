<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use Illuminate\Support\Facades\Cache;

class SendCodeByPhone implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $phone;
    public string $uuid;

    /**
     * Create a new job instance.
     *
     * @param  string  $phone
     * @param  string  $uuid
     */
    public function __construct(string $phone, string $uuid)
    {
        $this->phone = $phone;
        $this->uuid = $uuid;
    }


    /**
     * Execute the job.
     *
     * @throws Exception
     */
    public function handle(): void
    {
        $code = (string) random_int(10000, 99999);
        $cacheKey = "auth.sendcode.phone.$this->uuid";

        //TODO: add Twilio send

        $data = Cache::get($cacheKey);
        $data['code'] = $code;

        Cache::put($cacheKey, $data, now()->addSeconds(config('auth.sms_cool_down_after_seconds')));
    }
}
