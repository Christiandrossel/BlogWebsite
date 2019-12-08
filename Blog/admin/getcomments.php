<?php
    //read file into array
  $myfile = fopen("posts.json", "r") or die ("Unable to read file");
  $arr = json_decode(fread($myfile, filesize("posts.json")), true);
  echo json_encode($arr, JSON_PRETTY_PRINT);
?>
