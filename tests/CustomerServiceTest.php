<?php

namespace Tests;

use App\Services\Customer\CustomerService;
use Illuminate\Support\Facades\Http;
class CustomerServiceTest extends TestCase
{

    public function getCustomerDummyData()
    {

        return                 [
            'results' => [
                [
                    'gender' => 'female',
                    'name' => ['title' => 'Mrs', 'first' => 'Pamela', 'last' => 'Breitenberg'],
                    'location' => [
                        'street' => ['number' => 6491, 'name' => 'Smokey Ln'],
                        'city' => 'Bendigo',
                        'state' => 'Queensland',
                        'country' => 'Australia',
                        'postcode' => 8090,
                        'coordinates' => ['latitude' => '10.4197', 'longitude' => '-146.1116'],
                        'timezone' => ['offset' => '-4:00', 'description' => 'Atlantic Time (Canada), Caracas, La Paz'],
                    ],
                    'email' => 'leila.von@hotmail.com',
                    'login' => [
                        'uuid' => '4375cfe8-4493-41ba-85e0-18ee23b6332c',
                        'username' => 'bernard55',
                        'password' => 'toledo',
                        'salt' => 'qLpgTNWw',
                        'md5' => '01cac1e5ef1ecc445aa516665bb8163f',
                        'sha1' => '5b2dffcc7d2afe009659bcb8d1200a350b2da528',
                        'sha256' => '737f738acf16fde181837c6828d8bbc4b7b6978fdacd03b69e119100d6aa2e36',
                    ],
                    'dob' => ['date' => '1967-07-11T13:37:13.243Z', 'age' => 30],
                    'registered' => ['date' => '2020-09-27T11:00:10.733Z', 'age' => 10],
                    'phone' => '09-7946-4705',
                    'cell' => '0478-043-977',
                    'id' => ['name' => 'SID', 'value' => '2463398T'],
                    'picture' => [
                        'large' => 'https://randomuser.me/api/portraits/women/15.jpg',
                        'medium' => 'https://randomuser.me/api/portraits/med/women/15.jpg',
                        'thumbnail' => 'https://randomuser.me/api/portraits/thumb/women/15.jpg'],
                    'nat' => 'RS',
                ]
            ],
            'info' => [
                'seed' => '8145bc60dc2cddbc',
                'results' => 1,
                'page' => 1,
                'version' => '1.4'
            ]
        ];
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_get_customer_from_third_party_api_request()
    {

        Http::fake([
            config('customer.base_url').'?results=1&nat=au' => Http::response(
                $this->getCustomerDummyData()
            ),
        ]);

        /** @var  CustomerService $customerService */
        $customerService = app(CustomerService::class);

        $response = $customerService->getCustomers(1, 'au');

        $expectedJson = [
            [
                'first_name' => 'Pamela',
                'last_name' => 'Breitenberg',
                'email' => 'leila.von@hotmail.com',
                'username' => 'bernard55',
                'password' => 'toledo',
                'gender' => 'female',
                'country' => 'Australia',
                'city' => 'Bendigo',
                'phone' => '09-7946-4705',
            ]
        ];


        $this->assertJson(json_encode($response));
        $this->assertJsonStringEqualsJsonString(json_encode($expectedJson), json_encode($response));

    }

    /**
     * @throws \Exception
     */
    public function test_get_customer_from_third_party_api_request_500_error()
    {

        Http::fake([
            config('customer.base_url').'?results=1&nat=au' => Http::response(
                [
                    'error' => 'Uh oh, something has gone wrong. Please tweet us @randomapi about the issue. Thank you.'
                ], 500
            ),
        ]);

        /** @var  CustomerService $customerService */
        $customerService = app(CustomerService::class);

        $response = $customerService->getCustomers(1, 'au');
        $this->assertSame(500, $response->status());

    }
}
