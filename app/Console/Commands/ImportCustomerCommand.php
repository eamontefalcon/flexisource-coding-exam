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
    private CustomerImportService $customerImportService;
    private EntityManagerInterface $entityManager;

    public function __construct(CustomerImportService $customerImportService, EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->customerImportService = $customerImportService;
        $this->entityManager = $entityManager;
    }


    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        //TODO make a param for how many customer want to import
        $importCount = 5000;
        $nationality = 'au';

        $this->customerImportService->handle($importCount, $nationality);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }
}
