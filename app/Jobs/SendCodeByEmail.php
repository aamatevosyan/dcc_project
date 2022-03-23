<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use Illuminate\Support\Facades\{Cache, Mail};
use Log;

class SendCodeByEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $email;
    public string $uuid;

    /**
     * Create a new job instance.
     *
     * @param  string  $email
     * @param  string  $uuid
     */
    public function __construct(string $email, string $uuid)
    {
        $this->email = $email;
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
        $cacheKey = "auth.sendcode.email.$this->uuid";

        Log::debug("Phone code: {$this->uuid} => {$code}");

        Mail::send('auth.email-confirm', compact('code'),
            fn($m) => $m->to($this->email)->subject('Email Code Validation'));

        $data = Cache::get($cacheKey);
        $data['code'] = $code;

        Cache::put($cacheKey, $data, now()->addDay());
    }
}
