<?php
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use League\OpenAPIValidation\PSR7\ValidatorBuilder;

beforeEach(function () {
    $this->path = '/api/register';
    $this->method = 'post';
});

it('follows open api spec', function () {
    $client = new Client(['base_uri' => getenv('APP_URL')]);

    $request = new Request(
        method: $this->method,
        uri: $this->path,
        headers: [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ],
        body: json_encode([
            'name' => fake()->name,
            'email' => fake()->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ], JSON_THROW_ON_ERROR));


    expect($request)->toMatchOpenApiSpecRequest();

   $response = $client->send($request);

   expect($response)
       ->toMatchOpenApiSpecResponse($this->path, $this->method);
});
