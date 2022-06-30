<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sms;

class UpdateStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Sms::where('status','pending')->update(array('status' => 'sent'));

    }
}
