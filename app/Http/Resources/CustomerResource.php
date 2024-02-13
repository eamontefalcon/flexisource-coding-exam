<?php

namespace App\Http\Resources;

use App\Entities\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     **/
    public function toArray($request): array
    {
       /** @var Customer $customer */
        $customer = $this;

        return [
            'full_name' => $customer->getFullName(),
            'email' => $customer->getEmail(),
            'country' => $customer->getCountry(),
        ];
    }

    public function show(): array
    {
        /** @var Customer $customer */
        $customer = $this;

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

}
