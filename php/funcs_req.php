<?php

function post_request($url, array $params) {
  $query_content = http_build_query($params);
  $fp = fopen($url, 'r', FALSE, // do not use_include_path
    stream_context_create([
    'http' => [
      'header'  => [ // header array does not need '\r\n'
        'Content-type: application/x-www-form-urlencoded',
        'Content-Length: ' . strlen($query_content)
      ],
      'method'  => 'POST',
      'content' => $query_content
    ]
  ]));
  if ($fp === FALSE) {
    return json_encode(['error' => 'Failed to get contents...']);
  }
  $result = stream_get_contents($fp); // no maxlength/offset
  fclose($fp);
  return $result;
}

?>
