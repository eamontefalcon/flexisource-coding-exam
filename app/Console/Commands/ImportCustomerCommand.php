<?php

namespace App\Console\Commands;

use App\Services\Customer\CustomerImportService\CustomerImportService;
use Doctrine\ORM\EntityManagerInterface;
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
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //TODO make a param for how many customer want to import
        $importCount = 100;
        $nationality = 'au';

        /** @var CustomerImportService $customerImportService */
        $customerImportService = app(CustomerImportService::class);
        $customerImportService->handle($importCount, $nationality);

        $entityManager = app(EntityManagerInterface::class);
        $entityManager->flush();
        $entityManager->clear();
    }
}
