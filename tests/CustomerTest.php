<?php

namespace Tests;

use App\Repositories\Customer\CustomerRepositoryInterface;
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

        /** @var CustomerRepositoryInterface $createCustomer */
        $createCustomer = app(CustomerRepositoryInterface::class);

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

//    public function test_rollback_on_exception()
//    {
//        // Create a mock EntityManagerInterface
//        $entityManager = $this->createMock(EntityManagerInterface::class);
//        // Create a mock Connection
//        $connection = $this->createMock(Connection::class);
//
//        // Set up expectations for the EntityManager to return the mock Connection
//        $entityManager->method('getConnection')->willReturn($connection);
//
//        $customerRepository = app(CustomerRepositoryInterface::class);
//        $importCustomer = app(ImportCustomerInterface::class);
//
//        // Create an instance of CustomerImportService and inject the mock EntityManager
//        $customerImportService = new CustomerImportService($customerRepository, $importCustomer);
//
//        // Set up data for bulk insertion (example)
//        $customersData = [
//            'results' => [
//                [
//                    'gender' => 'female',
//                    'name' => ['title' => 'Mrs', 'first' => 'Pamela', 'last' => 'Breitenberg'],
//                    'location' => [
//                        'street' => ['number' => 6491, 'name' => 'Smokey Ln'],
//                        'city' => 'Bendigo',
//                        'state' => 'Queensland',
//                        'country' => 'Australia',
//                        'postcode' => 8090,
//                        'coordinates' => ['latitude' => '10.4197', 'longitude' => '-146.1116'],
//                        'timezone' => ['offset' => '-4:00', 'description' => 'Atlantic Time (Canada), Caracas, La Paz'],
//                    ],
//                    'email' => 'leila.von@hotmail.com',
//                    'login' => [
//                        'uuid' => '4375cfe8-4493-41ba-85e0-18ee23b6332c',
//                        'username' => 'bernard55',
//                        'password' => 'toledo',
//                        'salt' => 'qLpgTNWw',
//                        'md5' => '01cac1e5ef1ecc445aa516665bb8163f',
//                        'sha1' => '5b2dffcc7d2afe009659bcb8d1200a350b2da528',
//                        'sha256' => '737f738acf16fde181837c6828d8bbc4b7b6978fdacd03b69e119100d6aa2e36',
//                    ],
//                    'dob' => ['date' => '1967-07-11T13:37:13.243Z', 'age' => 30],
//                    'registered' => ['date' => '2020-09-27T11:00:10.733Z', 'age' => 10],
//                    'phone' => '09-7946-4705',
//                    'cell' => '0478-043-977',
//                    'id' => ['name' => 'SID', 'value' => '2463398T'],
//                    'picture' => [
//                        'large' => 'https://randomuser.me/api/portraits/women/15.jpg',
//                        'medium' => 'https://randomuser.me/api/portraits/med/women/15.jpg',
//                        'thumbnail' => 'https://randomuser.me/api/portraits/thumb/women/15.jpg'],
//                    'nat' => 'RS',
//                ]
//            ],
//            'info' => [
//                'seed' => '8145bc60dc2cddbc',
//                'results' => 1,
//                'page' => 1,
//                'version' => '1.4'
//            ]
//        ];
//
//        // Set up expectations for the mock Connection to throw an exception during execution
//        $connection->expects($this->once())
//            ->method('beginTransaction');
//        $connection->expects($this->once())
//            ->method('rollBack');
//        // Set up an expectation that the EntityManager's flush method will not be called
//        $entityManager->expects($this->never())
//            ->method('flush');
//
//        // Call the method that should trigger the exception
//        $customerImportService->handle($customersData);
//    }

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
