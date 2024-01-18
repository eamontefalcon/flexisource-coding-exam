<?php

namespace App\Services\Customer\CreateCustomerService;

use App\Entities\Customer;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\Facades\Log;

class CreateCustomerService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws \Exception
     */
    public function update(Customer $customer, $data): void
    {
        $customer->setFirstName($data['first_name']);
        $customer->setLastName($data['last_name']);
        $customer->setUsername($data['username']);
        $customer->setPassword(md5($data['password']));
        $customer->setGender($data['gender']);
        $customer->setCountry($data['country']);
        $customer->setCity($data['city']);
        $customer->setPhone( $data['phone']);

    }

    /**
     * @throws \Exception
     */
    public function createBulkCustomer(array $customersData): void
    {
        $size = 500;
        $batches =  array_chunk($customersData, $size);

        foreach ($batches as $batch) {
            $sql = 'INSERT INTO customers (first_name, last_name, email, username, password, gender, country, city, phone) VALUES ';

            foreach ($batch as $item) {
                $sql .= sprintf(
                    '("%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s"), ',
                    $item['first_name'],
                    $item['last_name'],
                    $item['email'],
                    $item['username'],
                    $item['password'],
                    $item['gender'],
                    $item['country'],
                    $item['city'],
                    $item['phone']
                );
            }
            $sql = rtrim($sql, ', ');
            $sql .= ' ON DUPLICATE KEY UPDATE
            first_name=VALUES(first_name),
            last_name=VALUES(last_name),
            email=VALUES(email),
            username=VALUES(username),
            password=VALUES(password),
            gender=VALUES(gender),
            country=VALUES(country),
            city=VALUES(city),
            phone=VALUES(phone)';

            // Execute the SQL query
            $this->entityManager->getConnection()->executeStatement($sql);
        }
    }

}
