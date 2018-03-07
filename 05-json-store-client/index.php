<?php require __DIR__ . '/vendor/autoload.php'; ?>
<!doctype html>
<html>
  <head>
    <meta charset="UTF8">
    <title>JSON Store Client</title>
  </head>
    <body>
    <h1>JSON Store Client</h1>
    <?php
    // Create a new Guzzle client
    $client = new \GuzzleHttp\Client();

    // Send a POST request to Myjson
    $body = '{"name":"Garfield","type":"Cat","age":39}';
    $response = $client->request(
      'POST',
      'https://api.myjson.com/bins',
      [
        'body' => $body,
        'headers' => [
          'Content-Type' => 'application/json; charset=utf-8'
        ]
      ]
    );

    // Decode the response body
    $obj = json_decode($response->getBody());

    // Assign the URI to a variable
    $uri = $obj->uri;

    // Send a PUT request to Myjson
    $body = '{"name":"Garfield","type":"Immortal","age":39}';
    $response = $client->request(
      'PUT',
      $uri,
      [
        'body' => $body,
        'headers' => [
          'Content-Type' => 'application/json; charset=utf-8'
        ]
      ]
    );

    // Make a GET request to Myjson using the new URI
    $json = $client->request('GET', $uri);

    // Echo out the response body
    echo $json->getBody();
    ?>
  </body>
</html>
