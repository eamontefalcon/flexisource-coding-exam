<?php

namespace App\Console\Commands;

use App\Services\Customer\CustomerImportService\CustomerImportService;
use Illuminate\Console\Command;

class ImportCustomerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:customer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import customers from api';
    private CustomerImportService $customerImportService;

    public function __construct(CustomerImportService $customerImportService)
    {
        parent::__construct();

        $this->customerImportService = $customerImportService;
    }


    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        $importCount = 1;
        $nationality = 'au';

        $this->customerImportService->handle($importCount, $nationality);
    }
}
