<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\PostPublished;
use Mail;

class SendEmailToSubscriber implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = new PostPublished($this->data);
        $receivers = [];
        $subscribers = Subscriber::select('email')->where('website_id', $this->data['website_id'])->get();
        foreach ($subscribers as $subscriber) {
            $receivers[] = $subscriber->email;
        }
        if (count($receivers) > 0) {
            Mail::to($receivers)->send($email);
        }

    }
}
