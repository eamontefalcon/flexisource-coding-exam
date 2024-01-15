<?php

namespace App\DTO;

class GetCustomerDTO
{

    private array $data = [];

    public function __construct($data)
    {
        ['results' => $results] = $data;
        $this->setResults($results);
    }

    public function setResults($results): void
    {
        // Process each user in the results array
        foreach ($results as $user) {
            //destructure data from api response
            /**
             * We can use the other variable here later if we needed so other developers can easily add without
             * checking the api response in actual or checking the docs
            **/
            [
                'gender' => $gender,
                'name' => ['title' => $title, 'first' => $first, 'last' => $last],
                'location' => [
                    'street' => ['number' => $streetNumber, 'name' => $streetName],
                    'city' => $city,
                    'state' => $state,
                    'country' => $country,
                    'postcode' => $postcode,
                    'coordinates' => ['latitude' => $latitude, 'longitude' => $longitude],
                    'timezone' => ['offset' => $timezoneOffset, 'description' => $timezoneDescription],
                ],
                'email' => $email,
                'login' => [
                    'uuid' => $uuid,
                    'username' => $username,
                    'password' => $password,
                    'salt' => $salt,
                    'md5' => $md5,
                    'sha1' => $sha1,
                    'sha256' => $sha256,
                ],
                'dob' => ['date' => $dobDate, 'age' => $dobAge],
                'registered' => ['date' => $registeredDate, 'age' => $registeredAge],
                'phone' => $phone,
                'cell' => $cell,
                'id' => ['name' => $idName, 'value' => $idValue],
                'picture' => ['large' => $pictureLarge, 'medium' => $pictureMedium, 'thumbnail' => $pictureThumbnail],
                'nat' => $nat,
            ] = $user;

            //we will return only what we needed
            $this->data[] = [
                'first_name' => $first,
                'last_name' => $last,
                'email' => $email,
                'username' => $username,
                'password' => $password,
                'gender' => $gender,
                'country' => $country,
                'city' => $city,
                'phone' => $phone
            ];
        }

    }

    public function getResults(): array
    {
        return $this->data;
    }
}
