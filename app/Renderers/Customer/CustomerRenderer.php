<?php

namespace App\Renderers\Customer;

use App\Entities\Customer;

class CustomerRenderer
{

    public function render(Customer $customer): array
    {
        return [
            'full_name' => $customer->getFullName(),
            'email' => $customer->getEmail(),
            'username' => $customer->getUsername(),
            'gender' => $customer->getGender(),
            'country' => $customer->getCountry(),
            'city' => $customer->getCity(),
            'phone' => $customer->getPhone(),
        ];
    }

    public function renderArray(array $customers): array
    {
        $base = [];

        /** @var Customer $aCustomer */
        foreach ($customers as $aCustomer) {
            $base[] = [
                'full_name' => $aCustomer->getFullName(),
                'email' => $aCustomer->getEmail(),
                'country' => $aCustomer->getCountry(),
            ];
        }

        return $base;
    }

}
