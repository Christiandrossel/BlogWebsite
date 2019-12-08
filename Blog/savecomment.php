<?php
  //read file into array
  $myfile = fopen("posts.json", "r") or die ("Unable to read file");
  $arr = json_decode(fread($myfile, filesize("posts.json")), true);
  $key= key($arr);

  //post into array
  while($_GET['postid'] != $key){next($arr); $key= key($arr);}
  $ckey = time();
  $arr[$key]['comment'][$ckey] = [
      "cname" => $_POST['cname'],
      "cmail" => $_POST['cmail'],
      "ctext" => $_POST['ctext']
  ];

  $pjson = json_encode($arr, JSON_PRETTY_PRINT);
  file_put_contents("posts.json", $pjson);

  //echo $pjson;
  
  http_response_code(200);
?>
