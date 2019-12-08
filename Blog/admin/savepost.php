<!DOCTYPE html>
<html>
    <head>
        <title>Forwarding to home....</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Icon -->
        <!-- <div>Icons made by http://www.freepik.com Freepik from https://www.flaticon.com/ is licensed by http://creativecommons.org/licenses/by/3.0/ -->
        <link rel="shortcut icon" type="image/x-icon" href="bee.ico">
    
        
       
    </head>
    <body>
      
      <?php
        //read file into array
        $myfile = fopen("../posts.json", "r") or die ("Unable to read file");
        $arr = json_decode(fread($myfile, filesize("../posts.json")), true);
        $key= key($arr);
        
        if (isset($_GET['postid'])){
            //edited post
            while($_GET['postid'] != $key){next($arr); $key= key($arr);}
            $arr[$key] = [
                "author" => "Admin",
                "title" => $_POST['title'],
                "text" => $_POST['text'],
                "comment" => $arr[$key]['comment']
            ];
        }
        else {
            //new post
            $key = time();
            //post into array
            $arr[$key] = [
                "author" => "Admin",
                "title" => $_POST['title'],
                "text" => $_POST['text'],
                "comment" => $carr[$ckey]
            ];
        }
        
        
        
        //sort array from newest to oldest
        krsort($arr);
        
        $pjson = json_encode($arr, JSON_PRETTY_PRINT);
        file_put_contents("../posts.json", $pjson);
        
        //forward to home
        header("Location: ./");
      ?>
    </body>
</html>
