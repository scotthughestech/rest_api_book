<?php require __DIR__ . '/vendor/autoload.php'; ?>
<!doctype html>
<html>
  <head>
    <meta charset="UTF8">
    <title>Yes/No API Client</title>
  </head>
    <body>
    <h1>Yes/No</h1>
    <?php
    $client = new \GuzzleHttp\Client();
    $json = $client->request('GET', 'http://www.server.com');
    $obj = json_decode($json->getBody());
    echo $obj->answer;
    ?>
  </body>
</html>
