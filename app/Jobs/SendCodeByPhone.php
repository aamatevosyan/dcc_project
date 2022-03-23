<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use Illuminate\Support\Facades\Cache;
use Throwable;
use Twilio;

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

        Log::debug("Phone code: {$this->uuid} => {$code}");

        if (config('auth.sms_send_enable')) {
            try {
                Twilio::message(
                    $this->phone,
                    "Auth code for DeliveryClub Couriers: {$code}",
                )->status;
            } catch (Throwable $exception) {
                Log::error($exception);
            }
        }

        $data = Cache::get($cacheKey);
        $data['code'] = $code;

        Cache::put($cacheKey, $data, now()->addSeconds(config('auth.sms_cool_down_after_seconds')));
    }
}
