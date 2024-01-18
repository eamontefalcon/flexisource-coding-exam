<?php

namespace Tests;

use App\Entities\Customer;
use App\Services\Customer\CreateCustomerService\CreateCustomerService;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Tests\Dummy\CustomerDummy;
use Tests\Trait\RefreshDatabase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws \Exception
     */
    private function generateData(): void
    {
        $this->createOrUpdateSchema();
        $this->truncateTable('customers');

        /** @var CustomerDummy $customerDummy */
        $customerDummy = app(CustomerDummy::class);
        $totalCountToGenerate = 10;

        /** @var EntityManagerInterface $entityManager */
        $entityManager = app(EntityManagerInterface::class);

        /** @var CreateCustomerService $createCustomer */
        $createCustomer = app(CreateCustomerService::class);

        $count = 1;
        $dummyCustomers = [];
        // Define the while loop condition
        while ($count <= $totalCountToGenerate) {
            $dummyCustomers[] = $customerDummy->create();
            $count++;
        }

        $createCustomer->createBulkCustomer($dummyCustomers);
        $entityManager->flush();
        $entityManager->clear();

    }

    /**
     * @throws \Exception
     */
    public function test_all_customers()
    {

        $this->generateData();
        $response = $this->json('GET', '/customers');

        $response->seeJsonStructure([
            'data' => [
                [
                    'full_name',
                    'email',
                    'country',
                ],
            ]
        ]);

        $response->assertResponseStatus(200);
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function test_all_customers_empty_array()
    {
        $this->createOrUpdateSchema();
        $this->truncateTable('customers');
        $response = $this->json('GET', '/customers');

        $response->seeJsonStructure([
            'data' => []
        ]);

        $response->assertResponseStatus(200);
    }

    public function test_find_customer()
    {
        $this->generateData();

        $response = $this->get('/customers/1');

        $response->seeJsonStructure([
            'data' => [
                'full_name',
                'email',
                'username',
                'gender',
                'country',
                'city',
                'phone'
            ],
        ]);

        $response->seeStatusCode(200);
    }

    public function test_find_customer_404()
    {
        $this->generateData();

        $customerId = 'dummyId';

        $response = $this->get('/customers/'.$customerId);


        $response->seeStatusCode(404);
    }

}
