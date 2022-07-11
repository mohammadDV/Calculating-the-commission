<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PaymentHandler\PaymentHandlerService;

class RunService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Running PaymentHandlerService';

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
        $service    = new PaymentHandlerService();
        $result     = $service->run();
        foreach ($result as $item){
            echo $this->format_commission($item) . PHP_EOL;
        }
    }

    /**
     * Add number_format.
     *
     * @return float 
     */
    private function format_commission($val): string{
        return number_format($val, 2, '.', '');
    }

}
