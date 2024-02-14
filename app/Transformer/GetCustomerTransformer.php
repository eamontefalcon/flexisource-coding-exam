<?php

namespace App\Transformer;

use Illuminate\Http\Client\Response;

class GetCustomerTransformer
{

    /**
     * Stores transformed customer data.
     *
     * This array holds the structured customer data
     * obtained from the third-party API response.
     */
    private array $data = [];

    /**
     * Constructs a new instance of GetCustomerTransformer.
     *
     * @throws \Exception
     */
    public function __construct(Response $data)
    {
        $result = ($data['results']) ?? [];
        $this->setResults($result);
    }

    /**
     * Sets the customer results extracted from the response data.
     *
     * This method processes each user in the results array obtained from the API response.
     * It extracts relevant fields such as first name, last name, email, username, password, gender,
     * country, city, and phone number from each user object and constructs an array of customer data.
     *
     * @throws \Exception If an error occurs during data processing.
     */
    public function setResults(array $results): void
    {
        // Process each user in the results array
        foreach ($results as $user) {
            try {
                $firstName = $user['name']['first'];
                $lastName = $user['name']['last'];
                $email = $user['email'];
                $username = $user['login']['username'];
                $password = $user['login']['password'];
                $gender = $user['gender'];
                $country = $user['location']['country'];
                $city = $user['location']['city'];
                $phone = $user['phone'];

                //we will return only what we needed
                $this->data[] = [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'username' => $username,
                    'password' => $password,
                    'gender' => $gender,
                    'country' => $country,
                    'city' => $city,
                    'phone' => $phone
                ];
            } catch (\Exception $exception) {
                throw new \Exception($exception->getMessage());
            }
        }
    }

    /**
     * Retrieves the transformed customer data.
     *
     * This method returns the array of customer data that has been transformed and structured
     * from the raw response data obtained from the third-party API.
     */
    public function getResults(): array
    {
        return $this->data;
    }
}
