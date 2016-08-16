<?php

include "setup.php";

use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();

header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
  <body>

    <p>form data</p>
    <pre><?php print_r($request->get('mirtrik-registration')); ?></pre>

    <p>recapcha tocken</p>
    <pre><?php print_r($request->get('g-recaptcha-response')); ?></pre>

  </body>
</html>