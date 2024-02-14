<?php

namespace App\Console\Commands;

use App\Services\Customer\CustomerDataSyncService\CustomerDataSyncService;
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

    /**
     * Import customers from third-party api and save it to database
     */
    private CustomerDataSyncService $customerImportService;

    /**
     * Initialize instance
     */
    public function __construct(CustomerDataSyncService $customerImportService)
    {
        parent::__construct();

        $this->customerImportService = $customerImportService;
    }

    /**
     * Process bulk import of customers
     *
     * @throws \Exception
     */
    public function handle(): void
    {
        $importCount = 500;
        $nationality = 'au';

        $this->customerImportService->handle($importCount, $nationality);
    }
}
