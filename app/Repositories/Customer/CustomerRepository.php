<?php

namespace App\Repositories\Customer;

use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Facades\Log;

class CustomerRepository extends EntityRepository implements CustomerRepositoryInterface
{
    /**
     *
     * Upsert customer
     * if email already exist just update it's existing record
     * if email is not yet exist insert it
     */
    public function createBulkCustomer(array $customersData, $batchSize = 500): void
    {
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();

        $batches = array_chunk($customersData, $batchSize);

        try {
            // Start the transaction
            $connection->beginTransaction();

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
                $stmt = $connection->prepare($sql);
                $stmt->executeStatement($values);
            }

            // Commit the transaction
            $connection->commit();
        } catch (Exception $e) {
            // Rollback the transaction on error
            $connection->rollBack();
            Log::error("Error while inserting/updating customers batch: " . $e->getMessage());
        } catch (ConnectionException $e) {
            Log::error("Connection Exception Error: " . $e->getMessage());
        } catch (\Doctrine\DBAL\Exception $e) {
            Log::error("Doctrine Exception Error " . $e->getMessage());
        }
    }
}
