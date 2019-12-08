<!doctype html>
<html lang="de">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Icon -->
    <!-- <div>Icons made by http://www.freepik.com Freepik from https://www.flaticon.com/ is licensed by http://creativecommons.org/licenses/by/3.0/ -->
    <link rel="shortcut icon" type="image/x-icon" href="bee.ico">
    
          
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <!-- Eigenes CSS -->
    <link rel="stylesheet" href="stylesheet.css">

     <!-- Mardown Parser - https://github.com/erusev/parsedown -->
     <?php 
     include'parsedown-1.7.1/Parsedown.php';
     $Parsedown = new Parsedown();
     
     ?>
     
    
    <title>Mein BloG</title>
    
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
    
  </head>
  <body style="background-color: #ffecac">
      
      <header>
      <!-- Navbar - https://getbootstrap.com/docs/4.0/components/navbar -->
 
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark" style="background-color: #bd9616;">
           <a class="navbar-brand" href="./">Bienen</a>
           <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavToggled" aria-controls="navbarNavToggled" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
           </button>
           <div class="collapse navbar-collapse" id="navbarNavToggled">
               <ul class="navbar-nav mr-auto">
                   <li class="nav-item active">
                       <a class="nav-link" href="./">Startseite<span class="sr-only">(current)</span></a>
                   </li>
               </ul>
                <!--
               <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item dropdown mt-2 mt-md-0">
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
      
      
      <!-- headline -->
     <div class="container-fluid">
        <div class="row ml-1">
            <div class="col-lg-8">
                <h2>Aktuelle Beiträge</h2>
                <hr class="line1">
                <br>
                <div class="row">
                <!-- print the newest 3 posts to site -->                     
                <?php
                    reset($arr); $key= key($arr);
                    $countp = count($arr);
                    
                    //pages
                    if (isset($_GET['page'])){
                        
                        $page = $_GET['page'];
                    }
                    else {
                        $page = 0;
                    }
                    
                    for ($i=0; $i<$page*3; $i++){
                        next($arr);
                    }
                    $key= key($arr);
                    
                    for ($i=0; $i<3; $i++){
                        if($i+($page*3) >= $countp) { break; }
                        
                        echo '<div class="col-lg-12"><div class="card"><div class="card-header" id="purple" style="background-color: #bd9616"><h4>';
                        echo $arr[$key]["title"] ;
                        echo '</h4><h6 class="text-right align-top"><p class="small">';
                        echo date("d.m.o, H:i", ($key+2*60*60)) . "&nbsp&nbsp&nbsp&nbsp";
                        if ($arr[$key]['comment'] !== null) {
                            echo count($arr[$key]['comment']);
                            if (count($arr[$key]['comment']) === 1) {echo " Kommentar";} else {echo " Kommentare";}
                        } else {
                            echo "0 Kommentare";
                        }
                        echo '</p></h6></div><p><div class="card-body">';
                        echo trimText(str_replace("\n", '<br />', $Parsedown->text($arr[$key]["text"])), 200) . '  '.'<a class="btn card-link float-right" href = "showpost.php?postid=' . $key . '">Ganzen Artikel lesen</a>';
                        echo '</p></div></div><br></div>';
                        next($arr); $key= key($arr);
                    }
                    
                    echo '<div class="col-lg-8">';
                    if ((($countp/3)-1) > $page){
                        echo '<a href=' . '"index.php?page=' . ($page+1) . '"' . '>< Ältere Beiträge</a>';
                    }
                    echo '</div><div class="col-lg-4">';
                    if (0 < $page){
                        echo '<a class="float-right" href=' . '"index.php?page=' . ($page-1) . '"' . '>Neuere Beiträge ></a>';
                    }
                    echo '</div>';
                ?>
                
                </div>
            </div>
            
            <!-- table with up to 10 newestest posts -->
            <div class="col-sm-4">
            <h2>Letzten Beiträge</h2>
            <hr class="line1">
            <br>
            <table class="table table-borderless">
                    <thead>
                        <th>Titel</th>
                        <th>Datum</th>
                    </thead>
                    <tbody>
                      <?php 
                        
                        reset($arr);
                        $key= key($arr);
                      
                        for ($i = 0; $i < 10; $i++) {
                            if($i >= $countp) { break; }
                            
                            echo '<tr><td>' . '<a href = "showpost.php?postid='; echo $key; echo '">' . trimText($arr[$key]["title"], 30) . '</a></td>';
                            echo '<td>' . date("d.m.o, H:i", ($key+2*60*60)) . '</td></tr>';
                            next($arr);
                            $key=key($arr);
                        }
                            
                      ?>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  </body>
</html>