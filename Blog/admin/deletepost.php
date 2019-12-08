<!DOCTYPE html>
<html>
    <head>
        <title>Forwarding to home....</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Icon -->
        <!-- <div>Icons made by http://www.freepik.com Freepik from https://www.flaticon.com/ is licensed by http://creativecommons.org/licenses/by/3.0/ -->
        <link rel="shortcut icon" type="image/x-icon" href="cat.ico">
    
        
       
    </head>
    <body>
      
      <?php
        //read file into array
        $myfile = fopen("posts.json", "r") or die ("Unable to read file");
        $arr = json_decode(fread($myfile, filesize("posts.json")), true);
       
         unset($arr[$_GET['postid']]);
        
        //sort array from newest to oldest
        krsort($arr);
        
        $pjson = json_encode($arr, JSON_PRETTY_PRINT);
        file_put_contents("posts.json", $pjson);
        
        //forward to home
        header("Location: ./postoverview.php");
      ?>
    </body>
</html>
