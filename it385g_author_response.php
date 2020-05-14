<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bookservice</title>
</head>
<body>
<table border='1'>
<?php

    //Check POST if empty show nothing
    if(isset($_POST['author'])){
      $authors=$_POST['author'];
    }else
      $authors="ALL";

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    echo "<pre>";
    print_r($authors);
    echo "</pre>";

    $xml = file_get_contents("https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/authors/?".$authors);
    $dom = new DomDocument;
    $dom->preserveWhiteSpace = FALSE;
    $dom->loadXML($xml);

    $authors = $dom->getElementsByTagName('AUTHOR');

    echo "<th>Firstname</th><th>Lastname</th><th>Born</th><th>Deceased</th><th>Image</th><th>About</th><th>Signature</th>";
    foreach ($authors as $author){
      echo "<tr>";
      foreach ($author->childNodes as $child){
        $text=trim($child->nodeValue);
        if($text!=""){
          echo "<td>".$text."</td>";
        }
      }  
      echo "</tr>";
    }
 /*    $tit = $dom3->getElementsByTagName('TITLE');
    foreach ($tit as $title){
      echo "<tr>";
      foreach ($title->childNodes as $child){
          $text=trim($child->nodeValue);
          if($text!=""){
              echo "<td>".$text."</td>";
          }
      }      
    
      echo "</tr>";  
    }

    $name = $dom3->getElementsByTagName('FIRSTNAME');
    foreach ($name as $firstname){
      echo "<tr>";
      foreach ($firstname->childNodes as $child){
          $text=trim($child->nodeValue);
          if($text!=""){
              echo "<td>".$text."</td>";
          }
      }      
    
      echo "</tr>";  
    } */
?>
</table>
</body>
</html>
