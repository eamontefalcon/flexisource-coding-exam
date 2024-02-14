<?php

namespace Tests\Trait;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\Facades\Artisan;

trait RefreshDatabase
{
    public function createOrUpdateSchema(): void
    {
        //create or update schema
        try {
            Artisan::call('doctrine:schema:create');
        } catch (\Exception $exception) {
            Artisan::call('doctrine:schema:update');
        }

    }

    /**
     * @throws Exception
     */
    public function truncateTable(string $tableName): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = app(EntityManagerInterface::class);
        //truncate customer table data
        $connection = $entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();
        $sql = sprintf('TRUNCATE TABLE %s', $platform->quoteIdentifier($tableName));

        // Execute the SQL statement
        $connection->executeStatement($sql);
    }
}
