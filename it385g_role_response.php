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
    if(isset($_POST['author_role'])){
      $author_role=$_POST['author_role'];
    }else
    $author_role="ALL";

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";


    $xml = file_get_contents("https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/authors/?role=".$author_role);
    $dom = new DomDocument;
    $dom->preserveWhiteSpace = FALSE;
    $dom->loadXML($xml);

    
    $fname = $dom->getElementsByTagName('FIRSTNAME');
    $lname = $dom->getElementsByTagName('LASTNAME');
    $img = $dom->getElementsByTagName('IMGURL');
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
      
      /* echo "<td>";
      $lname = $dom->getElementsByTagName('LASTNAME');
      foreach ($lname as $lastname){ 
        foreach ($lastname->childNodes as $child){
          $text=trim($child->nodeValue);
          if($text!=""){
              echo "<td>".$text."</td>"; 
          }
        }
        
      }
           */
        /* foreach ($authors as $author){
          foreach ($author->childNodes as $child){
            echo "<tr>";
            $attributes = $child->attributes;
            foreach ($child->childNodes as $text){
              if($text->tagName == "FIRSTNAME"){
                foreach($text->childNodes as $fname){
                  echo "<h3>";
                  echo $fname->nodeValue;
                  echo "</h3>";
                }
              }
            }
          }
        }     */
      
?>
</table>
</body>
</html>
