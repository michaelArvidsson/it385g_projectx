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
    if(isset($_POST['title'])){
      $titles=$_POST['title'];
    }else
      $titles="ALL";

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    echo "<pre>";
    print_r($titles);
    echo "</pre>";

    $xml = file_get_contents("https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/books/?titlesearch=".$titles);
    $dom = new DomDocument;
    $dom->preserveWhiteSpace = FALSE;
    $dom->loadXML($xml);

    $books = $dom->getElementsByTagName('BOOK');

    echo "<th>Booktitle</th><th>ID</th><th>Author(s)</th><th>Category</th><th>Link</th><th>Preface</th>";
    foreach ($books as $book){
      echo "<tr>";
      echo "<td>".$book->getAttribute("TITLE")."</td>";
      echo "<td>".$book->getAttribute("ID")."</td>";
      foreach ($book->childNodes as $child){
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
