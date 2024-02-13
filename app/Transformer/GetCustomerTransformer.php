<?php

namespace App\Transformer;

use Illuminate\Http\Client\Response;


/** make this transformer */
class GetCustomerTransformer
{

    private array $data = [];

    /**
     * @throws \Exception
     *
     * get tghe
     *
     */
    public function __construct(Response $data)
    {
        $result = ($data['results']) ?? [];
        $this->setResults($result);
    }

    /**
     * @throws \Exception
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

    public function getResults(): array
    {
        return $this->data;
    }
}
