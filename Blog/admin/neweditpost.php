<!doctype html>
<html lang="de">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Icon -->
    <!-- <div>Icons made by http://www.freepik.com Freepik from https://www.flaticon.com/ is licensed by http://creativecommons.org/licenses/by/3.0/ -->
    <link rel="shortcut icon" type="image/x-icon" href="cat.ico">
    
          
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <!-- Eigenes CSS -->
    <link rel="stylesheet" href="stylesheet.css">
    
    <!-- Markdown Editor - https://github.com/sparksuite/simplemde-markdown-editor -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    
    <!-- Mardown Parser - https://github.com/erusev/parsedown -->
    <?php include'../parsedown-1.7.1/Parsedown.php' ?>
    
    <!-- JavaScript Bootstrap -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <!-- read posts from file into array -->
    <?php
        $myfile = fopen("../posts.json", "r") or die ("Unable to read file");
        $arr = json_decode(fread($myfile, filesize("../posts.json")), true);
        krsort($arr);
        $key= key($arr);
        
        function trimText($string, $length) {
            if (strlen($string) > $length){
                $string = substr($string,0,$length)."...";
                $string_trimmed = strrchr($string, " ");
                $string = str_replace($string_trimmed,"...", $string);
            }
            return $string;
        }
    ?>  
    
    <!-- validate that form is not empty -->
    <script>
        function validateForm()
        {
            var Title=document.forms["New Post"]["title"].value;
            var Text=simplemde.value();
            if (Title===null || Title==="" || Text===null || Text==="")
            {
                alert("please fill all fields!");
                return false;
            }
        }
    </script>
    
    <title>Bienen</title>
  </head>
  <body>
      
      <header>
      <!-- Navbar - https://getbootstrap.com/docs/4.0/components/navbar -->
 
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark">
           <a class="navbar-brand" href="index.php">Bienen</a>
           <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavToggled" aria-controls="navbarNavToggled" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
           </button>
           <div class="collapse navbar-collapse" id="navbarNavToggled">
               <ul class="navbar-nav mr-auto">
                   <li class="nav-item">
                       <a class="nav-link" href="index.php">home<span class="sr-only">(current)</span></a>
                   </li>
               </ul>
               <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item active dropdown mt-2 mt-md-0">
                       <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">admin</a>
                       <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                           <a class="dropdown-item" href="neweditpost.php">new post</a>
                           <a class="dropdown-item" href="postoverview.php">edit post</a>
                           <a role="separator" class="line1"></a>
                           <a class="dropdown-item" href="uppic.php">upload pictures</a>
                       </div>
                    </li>
			   </ul>
           </div>
       </nav>  
      </header>
      
      <div class="container-fluid">
        <div class="row ml-1">
            <div class="col-lg-8">
                <h2 id="pagetitle">new post</h2>
                <hr class="line1">
                <br>
                <div class="row">
                     <div class="col-lg-12">
                        <form name="New Post" method="post" onsubmit="return validateForm()" action=<?php echo "savepost.php"; if (isset($_GET['postid'])){ echo "?postid=" . $_GET['postid'];} ?>>
                            <div class="form-group">
                                <input type="text" name='title' class="form-control" id="posttitle" placeholder="title of your post">
                            </div>
                            <div class="form-group">
                                <textarea id="markdownEditor" name="text" class="form-control"></textarea>
                                <button type="submit" value="continue" class="btn">submit</button>
                            </div>
                        </form>
                     </div>
                </div>
            </div>
        </div>
      </div>
      
      <!-- Markdown Editor -->
      <script>
        var simplemde = new SimpleMDE({ element: document.getElementById("markdownEditor"), placeholder: "write your post here!", hideIcons: ["side-by-side", "fullscreen"]});
        
        simplemde.value(
            <?php echo '"';
               //check if Editor should edit existing post
                if (isset($_GET['postid'])){
                    while($_GET['postid'] != $key){next($arr); $key= key($arr);}
                    echo str_replace("\n", "\\n", str_replace("\r", "\\r", str_replace("\t", "\\t", $arr[$key]["text"])));
                }
                echo '"';?>)
                document.getElementById("markdownEditor").focus();
      </script>
      
      <!-- Post title while edit post -->
      <script>
          if (<?php if (isset($_GET['postid'])){echo "true";} else {echo 'false';}?>) {
              document.getElementById("pagetitle").innerHTML = "edit post";
              document.getElementById("posttitle").value = <?php if (isset($_GET['postid'])){while($_GET['postid'] != $key){next($arr); $key= key($arr);}
                echo '"' . $arr[$key]["title"] . '"';} else {echo '""';}?>;
          }
          document.getElementById("posttitle").focus();
      </script>
          
          
          <?php
        
      ?>

      
      </body>
</html>