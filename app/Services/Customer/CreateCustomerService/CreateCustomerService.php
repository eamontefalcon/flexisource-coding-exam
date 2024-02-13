<?php

namespace App\Services\Customer\CreateCustomerService;

use App\Entities\Customer;
use Doctrine\DBAL\Driver\Exception;
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
     * @throws Exception
     */
    public function createBulkCustomer(array $customersData): void
    {
        $size = 500;
        $batches =  array_chunk($customersData, $size);

        foreach ($batches as $batch) {
            $sql = 'INSERT INTO customers (first_name, last_name, email, username, password, gender, country, city, phone) VALUES ';
            $values = [];
            $updateValues = [];

            foreach ($batch as $item) {
                $sql .= '(?, ?, ?, ?, ?, ?, ?, ?, ?), ';
                $values[] = $item['first_name'];
                $values[] = $item['last_name'];
                $values[] = $item['email'];
                $values[] = $item['username'];
                $values[] = md5($item['password']);
                $values[] = $item['gender'];
                $values[] = $item['country'];
                $values[] = $item['city'];
                $values[] = $item['phone'];

                // Prepare the update part
                $updateValues[] = 'first_name = VALUES(first_name)';
                $updateValues[] = 'last_name = VALUES(last_name)';
                $updateValues[] = 'email = VALUES(email)';
                $updateValues[] = 'username = VALUES(username)';
                $updateValues[] = 'password = VALUES(password)';
                $updateValues[] = 'gender = VALUES(gender)';
                $updateValues[] = 'country = VALUES(country)';
                $updateValues[] = 'city = VALUES(city)';
                $updateValues[] = 'phone = VALUES(phone)';
            }

            $sql = rtrim($sql, ', ');
            $sql .= ' ON DUPLICATE KEY UPDATE ' . implode(', ', $updateValues);

            // Prepare and execute the statement
            try {
                // Prepare and execute the statement
                $stmt = $this->entityManager->getConnection()->prepare($sql);
                $stmt->executeStatement($values);
            } catch (\Exception $e) {
                Log::error("Error while inserting/updating customers batch: " . $e->getMessage());
                throw $e;
            }
        }
    }

}
