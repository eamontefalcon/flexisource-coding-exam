<?php

namespace App\Http\Resources;

use App\Entities\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Extract details of customer
     */
    private function extractCustomerDetails(Customer $customer): array
    {
        return [
            'username' => $customer->getUsername(),
            'gender' => $customer->getGender(),
            'city' => $customer->getCity(),
            'phone' => $customer->getPhone(),
        ];
    }

    /**
     * Get all the important data that needed
     */
    private function buildCustomerProfile(Customer $customer): array
    {
        return [
            'full_name' => $customer->getFullName(),
            'email' => $customer->getEmail(),
            'country' => $customer->getCountry(),
        ];
    }

    /**
     * Transform the resource into an array.
     *
     * This will extract all the data in customers
     *
     */
    public function toArray($request): array
    {

        if (!$this->resource instanceof Customer) {
            return [];
        }

        return $this->buildCustomerProfile($this->resource);
    }

    /**
     * Get all information in a specific customer
     */
    public function customerInformation(): array
    {

        if (!$this->resource instanceof Customer) {
            return [];
        }

        $profileData = $this->buildCustomerProfile($this->resource);
        $additionalDetails = $this->extractCustomerDetails($this->resource);

        return array_merge($profileData, $additionalDetails);
    }

}
