<!DOCTYPE html>
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

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Time -->
    <script src="https://cdn.rawgit.com/jacwright/date.format/master/date.format.js"></script>

    <title>Mein BloG</title>
</head>
<body>
    
    <!-- Auslesen der JSON Datei in Array -->
   <?php
        $myfile = fopen("posts.json", "r") or die ("Unable to read file");
        $arr = json_decode(fread($myfile, filesize("posts.json")), true);
        
        function trimText($string, $length) {
            if (strlen($string) > $length){
                $string = substr($string,0,$length)."...";
                $string_trimmed = strrchr($string, " ");
                $string = str_replace($string_trimmed,"...", $string);
            }
            return $string;
        }
   ?>
    
     <!-- Mardown Parser - https://github.com/erusev/parsedown -->
        <?php include'parsedown-1.7.1/Parsedown.php';
        $Parsedown = new Parsedown();
        ?>
        
     <!-- validate that form is not empty -->
    <script>
        function validateForm()
        {
            var cname =document.forms["Comment"]["cname"].value;
            var cmail =document.forms["Comment"]["cmail"].value;
            var ctext =document.forms["Comment"]["ctext"].value;
            if (cname===null || cname==="" || ctext===null || ctext==="" || cmail===null || cmail==="")
            {
                alert("Bitte alle Felder ausfüllen!");
                return false;
            }
        }
    </script>
    
    <header>
      <!-- Navbar - https://getbootstrap.com/docs/4.0/components/navbar -->
 
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark">
           <a class="navbar-brand" href="./">Bienen</a>
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
    
      <!-- Überschrift -->
     <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <h2><?php echo $arr[$_GET['postid']]["title"] . "&nbsp&nbsp<small> " //. $arr[$_GET['postid']]["author"] . "</small>"; ?></h2>
                <hr class="line1">
                <div class="row">
                    <div class="col-lg-9">
                        <p class ="post_author"><?php echo date("d.m.o, H:i", ($_GET['postid']+2*60*60)) . "&nbsp&nbsp&nbsp&nbsp"; ?></P>
                        <p class = "post"> <?php echo str_replace("<img" , "<img class='img-fluid'", str_replace("\n", '<br />', $Parsedown->text($arr[$_GET['postid']]["text"]))); ?></p>
                    </div>     
                </div>
                <br>
                <a href= "./"> Zurück zur Startseite</a>
                <br><br>                
                <div class="card">
                    <div class="card-header"><h4>Neuer Kommentar</h4></div>
                    <div class="card-body text-center">
                        <form name="Comment" method="post" id="formcomment" onsubmit="return validateForm()" action=<?php echo "savecomment.php?postid=" . $_GET['postid'];?>>
                            <div class="form-group">
                                <input type="text" name='cname' class="form-control" id="comname" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name='cmail' class="form-control" id="commail" placeholder="E-Mail" required>
                            </div>
                            <div class="form-group">
                                <textarea name="ctext" class="form-control" id="comtext" placeholder="Kommentar" required></textarea>
                            </div>
                            <button type="submit" value="submit" class="btn btn-primary btn-dark">Senden</button>
                        </form>
                    </div> 
                </div>
                <br>
                
                <div class="row" id="comments">
                    <h4 style="padding-left: 15px;">Kommentare</h4>
                    <br><br>                    
                        <?php 
                            reset($arr);
                            if($arr[$_GET['postid']]['comment'] !== null){
                                foreach ($arr[$_GET['postid']]['comment'] as $key => $value) {
                                    echo '<div class="col-lg-12"><div class="card" id="com"><div class="card-header" style="background-color: #EAF2F8; color: black;">';
                                    echo $value['cname'] . ' on ' . date("d.m.o, H:i", ($key+2*60*60)) . '</div><div class="card-body">';
                                    echo $value['ctext'];
                                    echo '</div></div></div><br>';
                                }
                                echo '</br></br><p/>';
                            }
                            else {
                                echo '<div class="col-lg-12"><p>Zur Zeit keine kommentare</p></br></br></div>';
                            }
                        ?>
                    </div>
                </div>
                    
                
            
                <div class="col-sm-4">
                <h2>Letzten Beiträge</h2> 
                <hr class="line1">
            <br>
            <table class="table table-borderless">
                    <thead>
                        <th>post</th>
                        <th>date</th>
                    </thead>
                    <tbody>
                      <?php 
                        
                        reset($arr);
                        $key= key($arr);
                        $countp = count($arr);
                      
                        for ($i = 0; $i < 10; $i++) {
                            if($i >= $countp) { break; }
                            
                            echo '<tr><td>' . '<a href = "showpost.php?postid='; echo $key; echo '">' . trimText($arr[$key]["title"], 30) . '</a></td>';
                            echo '<td>' . date("d.m.o, H:i", ($key+2*60*60)) . '</td></tr>';
                            next($arr);
                            $key= key($arr);
                        }
                            
                      ?>
                    </tbody>
                  </table>
                </div>
            </div>     
      </div>
      
    <script>
        $(function() {
            // Get the form.
            var form = $('#formcomment');

            // Set up an event listener for the contact form.
            $(form).submit(function(event) {
                // Stop the browser from submitting the form.
                event.preventDefault();

                // Serialize the form data.
                var formData = $(form).serialize();
                // Submit the form using AJAX.
                $.ajax({
                    type: 'POST',
                    url: $(form).attr('action'),
                    data: formData
                });
               
                var data;
                
                $.ajax({
                    url: 'getcomments.php?postid=' + <?php echo $_GET['postid'];?>,
                    data: data,
                    success: function(data){
                        var comcontent = '<h4 style="padding-left: 15px;">comments</h4><br><br>';
                        var i = 0;
                        
                        $.each(JSON.parse(data), function( i1, object1 ) {
                            $.each(object1.comment, function( i2, object2 ) {
                                $.each(object2, function( i3, value ) {
                                    if (i1 == <?php echo $_GET['postid'];?>){
                                        switch(i%3){
                                            case 0:
                                              comcontent = comcontent + '<div class="col-lg-12"><div class="card" id="com"><div class="card-header" style="background-color: #EAF2F8; color: black;">' + value; i++; break;
                                          case 1:
                                              comcontent = comcontent + ' on ' + ((new Date(i2*1000)).format("d.m.Y, H:i")) + '</div><div class="card-body">'; i++; break;
                                          case 2:
                                              comcontent = comcontent + value + '</div></div></div><br>'; i++; break;
                                        }
                                    }
                                });
                            });
                        });                         
                        document.getElementById("comments").innerHTML = comcontent;
                        document.getElementById("comname").value = "";
                        document.getElementById("commail").value = "";
                        document.getElementById("comtext").value = "";

                    }
                  });
            });
        });
    </script>

    
    
</body>
</html>