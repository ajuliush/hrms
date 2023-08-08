<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class InternEmployment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:internEmployment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the status of intern employees based on their intern date';

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
        $employees = User::where('employment_type', 'Intern')->whereDate('in_trine_month', today())->get();

        foreach ($employees as $employee) {
                $employee->employment_type = "Permanent" ;
                $employee->save();

        }
    }
}
