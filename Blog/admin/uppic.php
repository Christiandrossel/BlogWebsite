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
    
     <!-- Marcdown Parser - https://github.com/erusev/parsedown -->
     <?php include'parsedown-1.7.1/Parsedown.php';
     $Parsedown = new Parsedown();?>
     
    <!-- JavaScript Bootstrap -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <!-- function dialog delete + forwarding to deltepost.php -->
        <script>
            function dialogDelete($url) {
                if (confirm("do you really want to delete this beautiful picture?")) {
                   window.location = $url;
                }
            }
            
            function validateForm(){
                var Pic=document.forms["New Pic"]["fileToUpload"].value;
            if (Pic===null || Pic==="")
            {
                alert("please select a file!");
                return false;
            }
            }
        </script>
        
    <title>all you need is cat</title>
    
  </head>
  <body>
      
      <?php
        if (isset($_POST['submit'])) {
        $error = '';
        // echo "<br><br><br><br><br>";
         if (isset($_FILES['fileToUpload'])) {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    if($check !== false) {                      
                      //  echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        $error = "file is not an image.";
                       // echo "File is not an image.";
                        $uploadOk = 0;
                    }
                }

                // Check if file already exists
                if (file_exists($target_file)) {
                    $error = "file already exists.";
                    //echo "Sorry, file already exists.";
                    $uploadOk = 0;
                } 

                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 2000000) { //2000kb
                    $error = "file is too large. max 2000kB.";
                    //echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                    $error = "only JPG, JPEG, PNG & GIF files are allowed.";
                    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                } 

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo '<script>alert("Sorry, ' . $error . '");</script>';
                    // echo "sorry, your file was not uploaded: " . $error;
                    //TODO Error notification an einem besseren Ort ausgeben

                // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        $message = "The file ". basename( $_FILES["fileToUpload"]["name"]). " was sucessfully uploaded.";                                  
                    } else {
                        $message = "sorry, there was an error uploading your file.";
                    }
                    echo '<script language="javascript">';
                    echo 'alert("' . $message . $error . '")';
                    echo '</script>';   
                }   
            }
        }
        ?>
      
      <header>
      <!-- Navbar - https://getbootstrap.com/docs/4.0/components/navbar -->
 
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark">
           <a class="navbar-brand" href="./">seven lifes</a>
           <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavToggled" aria-controls="navbarNavToggled" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
           </button>
           <div class="collapse navbar-collapse" id="navbarNavToggled">
               <ul class="navbar-nav mr-auto">
                   <li class="nav-item active">
                       <a class="nav-link" href="./">home<span class="sr-only">(current)</span></a>
                   </li>
               </ul>
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
           </div>
       </nav>  
      </header>
      
   
    <div class="container-fluid">
        <div class="row ml-1">
            <div class="col-lg-8">
                <h2>picture upload</h2>
                <hr class="line1">
                <br>
                <div class="row">
                    <form name="New Pic" action="uppic.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm();">
                        <div class="form-group row">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;select image to upload:&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="file" name="fileToUpload" id="fileToUpload">
                            <input class="btn float-right" type="submit" value="upload image" name="submit">
                            <p id="notification">  </p>
                        </div>
                        <div class="form-group">
                            
                        </div>
                    </form>
                </div> 
  
            </div>
        </div>
      
    <div id="galerie" class="col-lg-8">
        <br><h2>galery</h2>
        <hr class="line1"><br>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>picture</th>
                    <th>title</th>
                    <th>size</th>
                    <th>&nbsp;&nbsp;delete</th>
                </thead>
                <tbody>
                    <?php
                        //http://sevenx.de/blog/tutorial-einfach-mit-php-ordner-auslesen-und-dateien-und-bilder-anzeigen/
                        $ordner = "uploads"; 
                        $allebilder = scandir($ordner);         				
                        foreach ($allebilder as $bild) {
                        $bildinfo = pathinfo($ordner."/".$bild);
                        $size = ceil(filesize($ordner."/".$bild)/1024);
                        if ($bild != "." && $bild != ".."  && $bild != "_notes" && $bildinfo['basename'] != "Thumbs.db") { 
                    ?>
                    <tr>
                        <td><img src="<?php echo $bildinfo['dirname']."/".$bildinfo['basename'];?>" width="140" alt="preview" /></td> 
                        <td><?php echo $bildinfo['filename']; ?></td>
                        <td><?php echo $size ; ?>kb</td>
                        <?php   $url = "'deletepic.php?pic=uploads/" . $bildinfo['basename'] . "'";
                                    echo '<td class="float-center"><button class="btn" onclick="dialogDelete(' . $url . ')">delete</button></td></tr>'; ?></td>
                    </tr>
                    <?php
                    };
                    };
                    ?>
                </tbody>
            </table>
        </div>
    </div> 
   </div>
    
  </body>
</html>