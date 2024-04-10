<?php

namespace App\Console\Commands;

use App\Mail\GreetingMail;
use Illuminate\Console\Command;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Mail;

class GreetingMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:greeting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command send greeting to user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Mail::to('huynquose.12@gmail.com')->send(new GreetingMail);
    }
}
