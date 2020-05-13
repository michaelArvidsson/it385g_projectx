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
    if(isset($_POST['category'])){
      $categories=$_POST['category'];
    }else
      $categories="ALL";
    
    if(isset($_POST['author'])){
      $authors=$_POST['author'];
    }else
      $authors="ALL";

    if(isset($_POST['title'])){
      $titles=$_POST['title'];
    }else
      $titles="ALL";

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    echo "<pre>";
    print_r($categories);
    echo "</pre>";

    echo "<pre>";
    print_r($authors);
    echo "</pre>";

    echo "<pre>";
    print_r($titles);
    echo "</pre>";

    $xml = file_get_contents("https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/category/?categorysearch=".$categories);
    $dom = new DomDocument;
    $dom->preserveWhiteSpace = FALSE;
    $dom->loadXML($xml);

    $xml = file_get_contents("https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/books/?titlesearch=".$titles);
    $dom2 = new DomDocument;
    $dom2->preserveWhiteSpace = FALSE;
    $dom2->loadXML($xml);

    $xml = file_get_contents("https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/authors/?lastname=".$authors);
    $dom3 = new DomDocument;
    $dom3->preserveWhiteSpace = FALSE;
    $dom3->loadXML($xml);

    /* echo "<pre>";
    print_r($dom2);
    echo "</pre>"; */

    $cat= $dom->getElementsByTagName('CATEGORY');
    foreach ($cat as $category){
      echo "<tr>";
      foreach ($category->childNodes as $child){
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
