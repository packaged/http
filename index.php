<pre><?php
require_once 'vendor/autoload.php';

$request = new \Packaged\Http\Requests\GlobalsRequest();
var_dump($request->withAddedHeader('Host', 'google.com')->getHeaders());
var_dump((string)$request->getUri());
var_dump((string)$request->getBody());
?>
  </pre>
<form method="post" action="/">
  <input type="text" name="user"/>
  <button type="submit"/>
</form>
