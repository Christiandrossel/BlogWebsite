<?php
    $target_dir = "../images/";
    $target_file = $_POST["id"];
    
    $file_directory = "$target_dir" . "$target_file";

    if(isset($file_directory)){
        
        if(unlink($file_directory)){
            echo "Das Bild wurde gelöscht!";
        } else {
            echo "Error 1";                                         // Error 1: unlink has failed! The File hasn´t been removed!
        }
    } else{
        echo "Error 2";                                             // Error 2: is not isset! The File is not available!
    }
?>
