<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Loans\Utils\LoanUtil;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\Commands\Concerns\TenantAware;

class LoanScheduleUpdater extends Command
{
    use TenantAware;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loans:cron {--tenant=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar emprestimos.';

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

        $loan = new LoanUtil();
        $loan->loansDelayChecker();
        \Log::info('Loans checked!');
        //\Log::info(Tenant::current());
    }
}
