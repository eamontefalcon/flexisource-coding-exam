<?php

namespace App\Services\Customer\CreateCustomerService;

use App\Entities\Customer;
use Doctrine\ORM\EntityManagerInterface;

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

        foreach($customersData as $aCustomer) {
            $customer = $this->entityManager->getRepository(Customer::class)->findOneBy(['email' => $aCustomer]);

            $firstName = $aCustomer['first_name'];
            $lastName = $aCustomer['last_name'];
            $email = $aCustomer['email'];
            $username = $aCustomer['username'];
            $password = md5($aCustomer['password']);
            $gender = $aCustomer['gender'];
            $country = $aCustomer['country'];
            $city = $aCustomer['city'];
            $phone = $aCustomer['phone'];

            if (null === $customer) {
                $customer = new Customer(
                    $firstName,
                    $lastName,
                    $email,
                    $username,
                    $password,
                    $gender,
                    $country,
                    $city,
                    $phone
                );
                $this->entityManager->persist($customer);
                $this->entityManager->flush(); //we need to flush here to avoid email duplication
            } else {
                $this->update($customer, $aCustomer);
            }
        }

    }
}
