<?php
//Funktion um die Bilder anzuzeigen
function show_pic_in_table(){
  //if($alledatein = scandir("/home/rex/fi3/im16/s75931/public_html/images/")){
    if($alledatein = scandir("./images/")){

    foreach ($alledatein as $datei) {

      if("$datei" != "." && "$datei" != ".."){
        echo '<tr>
                <td><img src=images/' ."$datei". ' style="width:100px; height:100px; margin-left:5px; margin-top:5px; margin-bottom:5px; margin-right:20px;">
                </td>
                <td><a href="images/' . $datei . '">'."$datei".'</a></td>
                <td text-align:center;"><input type="button" class="btn_delete" value="Löschen" id="'."$datei".'" /></td>
              </tr>';
      }
    }
  }else{
    echo "Directory not available!";
  }
}

?>