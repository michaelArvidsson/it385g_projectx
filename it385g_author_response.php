<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Arapey&display=swap" rel="stylesheet">
  <title>Bookservice</title>
  <style>
     body{
      background-color:#00693e;
       font-family: 'Arapey', serif;
     }
     #head {
        background-color: #f8f9f5;
        color:darkslategrey;
        width:100%;
        font-size: 200%;
        font-weight: bold;
        letter-spacing: 5px;
        text-align: center;
        text-shadow: 2px 2px rgba(0, 0, 0, 0.1);
        padding:10px;
        margin-top:0px;
        margin-bottom:40px;
    }
    #form_body {
        Width:500px;
        background-color: #f8f9f5;
        margin:auto;
        font-weight:bold;
        font-size:15px;
        box-shadow: 2px 2px 4px 2px;
        padding: 20px;
        margin-bottom:30px;
        border-radius: 3px;
    }
    table {
      background-color: #f8f9f5;
      border-collapse: collapse;
      margin:auto;
      box-shadow: 2px 2px 4px 2px;
      border-radius: 3px;
      margin-bottom:30px;
    }
    td {
      padding: 0px;
      margin: 0px;
    }
  </style>
</head>
<body>
<h1 id='head'>Bookservice / Author details</h1>
<table border='1'>
<?php

    //Check POST if empty show nothing
    if(isset($_POST['author'])){
      $namn = explode("&", $_POST['author']);
        $firstname=  $namn[0];
        $lastname =  $namn[1]; 
    }

  /*   echo "<pre>";
    print_r($_POST);
    echo "</pre>"; */

    $url="https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/authors/?firstname=".urlencode($firstname)."&lastname=".urlencode($lastname);
    $xml = file_get_contents($url);
    $dom = new DomDocument;
    $dom->preserveWhiteSpace = FALSE;
    $dom->loadXML($xml);

    $xml = file_get_contents('https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/authors?role=Author');
    $dom2 = new DomDocument;
    $dom2->preserveWhiteSpace = FALSE;
    $dom2->loadXML($xml);

    $authors = $dom->getElementsByTagName('AUTHOR');
    $authors2 = $dom2->getElementsByTagName('AUTHOR');

    /* echo "<pre>";
    print_r($url);
    echo "</pre>"; */

      echo "<div id=form_body>";
      echo "</form>";
      echo "<div style='width:480px; margin:auto;'>";
      echo "<form method='POST' action='it385g_author_response.php'>";
      echo "<label> Select another author </label>";
      echo "<select name='author'>";
      echo "<option value=''>---";
      $authors2 = $dom2->getElementsByTagName('AUTHOR');
      foreach ($authors2 as $author){
        foreach ($author->childNodes as $child){
          if($child->nodeName=="FIRSTNAME"){
            $first = $child->nodeValue;
              
          }else if($child->nodeName=="LASTNAME"){
            $last = $child->nodeValue;
                   
          }         
        }       
        echo "<option value='$first&$last'>";
        echo $first;
        echo " "; 
        echo $last;    
        echo "</option>";
      }
      echo "<input style='margin:10px; border-radius:5px;' type='submit' name='submitbutton' value='Show result'>";
      echo "</select>";
      echo "</div>";
      echo "</form>";
      echo "</div>";
    echo "<th>Author</th><th>Lived</th><th>Image</th><th>About</th><th>Signature</th>";
    foreach ($authors as $author){
      echo "<tr>";
      foreach ($author->childNodes as $child){
        if($child->nodeName=='FIRSTNAME'){
          echo "<td><div style='width:150px; text-align: center;'>";
          echo $child->nodeValue;
          echo " ";
        }else if ($child->nodeName=='LASTNAME'){
          echo $child->nodeValue;
          echo "<br>";
          echo "<span>Role:".$author->getAttribute("ROLE")."</span>";
          echo "</div></td>";
        }else if ($child->nodeName=='BIRTHYEAR'){
          $birth=$child->nodeValue;
          echo "<td><span style='Width:100px; white-space: nowrap; padding:10px;'>";
          echo $child->nodeValue;
          echo " - ";
        }else if ($child->nodeName=='DEATHYEAR'){
          $death=$child->nodeValue;
          echo $child->nodeValue;
          echo "</span></td>";
        }else if ($child->nodeName=='IMGURL'){
          echo "<td><div style='width:200px; height:200px; overflow:hidden;'>";
          echo "<a href='$child->nodeValue'>";
          echo "<img style='width:200px;' src='$child->nodeValue'alt=''>";
          echo "</a>";          
          echo "</div></td>";
        }else if ($child->nodeName=='ABOUT'){
          echo "<td><div style='Width:400px; padding:10px;'><p>";
          echo $child->nodeValue;
          echo "</p></div></td>";
        }else if ($child->nodeName=='SIGNATURE'){
          echo "<td><div style='width:200px; height:200px;padding:5px;'>";
          echo "<a href='$child->nodeValue'>";
          echo "<img style='width:200px; height:200px' src='$child->nodeValue'alt=''>";
          echo "</a>";          
          echo "</div></td>";
        }
      }  
      echo "</tr>";
    }     
    echo "</table>";
    echo "<div id=form_body>";
    echo "<h3 style='width:300px; margin:auto; margin-bottom:10px; text-align:center;'>The auhtor lived between</h3>";
    echo "<div class='graph'style='width:420px; margin:auto; position:relative;'>";
    echo "<div style='width:100px; text-align:center; padding:10px; margin:auto;'>".$birth. "  -  " .$death."</div>";
    $year = $death - $birth;
    $start = ($birth-1700)+100;
    $end = ($start + $year); 
    
    echo "<img style='width:410px;'src='flourish2.svg'>";
    echo "<svg style='position:absolute; left:0px; top:55px;'height='50' width='400'>";
    echo "<line x1='$start' y1='15' x2='$end' y2='15' style='stroke:rgb(255,0,0);stroke-width:3'/>";
    echo "<circle cx='$start' cy='15' r='3' style='stroke:red; stroke-width:2; fill:white; fill-opacity: 1.0;' />";
    echo "<circle cx='$end' cy='15' r='3' style='stroke:red; stroke-width:2; fill:white; fill-opacity: 1.0;' />";
    echo "</svg>";
    echo "</div>";
    echo "</div>";
?>

</body>
</html>
