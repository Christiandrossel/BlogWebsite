<!DOCTYPE html>
<html>
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

        <!-- JavaScript Bootstrap -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <!-- read posts from file into array -->
        <?php
            $myfile = fopen("posts.json", "r") or die ("Unable to read file");
            $arr = json_decode(fread($myfile, filesize("posts.json")), true);
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
        
        <!-- function dialog delete + forwarding to deltepost.php -->
        <script>
            function dialogDelete($url) {
                if (confirm("do you really want to delete this post?")) {
                   window.location = $url;
                }
            }
        </script>

        <title>all you need is cat</title>
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
                           <a class="nav-link" href="./">Startseite<span class="sr-only">(current)</span></a>
                       </li>
                   </ul>
                    <!--
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
                    -->
               </div>
           </nav>  
        </header>
 
        <!-- table with all posts -->
            <div class="col-sm-11">
            <h2>edit posts</h2>
            <hr class="line1">
                <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>post</th>
                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;date</th>
                        <th>&nbsp;&nbsp;&nbsp;edit</th>
                        <th>&nbsp;&nbsp;delete</th>
                    </thead>
                    <tbody>
                      <?php 
                        $countp = count($arr);
                        reset($arr);
                        $key= key($arr);
                      
                        for ($i = 0; $i < $countp; $i++) {
                            echo '<tr><td>' . '<a href = "showpost.php?postid=' . $key . '">' . $arr[$key]["title"] . '</a></td>';
                            echo '<td>' . date("d.m.o, H:i", ($key+2*60*60)) . '</td>';
                            echo '<td><a href="neweditpost.php?postid=' . $key . '">edit post</a></td>';
                            $url = "'deletepost.php?postid=" . $key . "'";
                            echo '<td class="float-center"><button class="btn" onclick="dialogDelete(' . $url . ')">delete</button></td></tr>';
                            next($arr);
                            $key= key($arr);
                        }
                            
                      ?>
                    </tbody>
                  </table>
                </div>
            </div>

    </body>
</html>
