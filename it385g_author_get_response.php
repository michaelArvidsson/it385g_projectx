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
        Width:400px;
        background-color: #f8f9f5;
        margin:auto;
        font-weight:bold;
        font-size:15px;
        box-shadow: 2px 2px 4px 2px;
        padding: 10px;
        margin-bottom:30px;
        margin-top:30px;
        border-radius:5px;
    }
    table {
      background-color: #f8f9f5;
      border-collapse: collapse;
      margin:auto;
      box-shadow: 2px 2px 4px 2px;
      border-radius: 5px;
    }
    td {
      padding: 0px;
      margin: 0px;
    }
    #submit_button {
      margin: auto;
      padding: 3px;
      width: 70px;
      border-radius:5px;
    }
  </style>
</head>
<body>
<h1 id='head'>Bookservice / Author details</h1>
<table border='1'>
<?php

    //Check POST if empty show nothing
    if(isset($_GET['firstname'])){
      $firstname=$_GET['firstname'];
    }
    if(isset($_GET['lastname'])){
      $lastname=$_GET['lastname'];
    }else
      $writer="ALL";

    $url="https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/authors/?firstname=".urlencode($firstname)."&lastname=".urlencode($lastname);
    $xml = file_get_contents($url);
    $dom = new DomDocument;
    $dom->preserveWhiteSpace = FALSE;
    $dom->loadXML($xml);

    $authors = $dom->getElementsByTagName('AUTHOR');

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
          echo "<span>Role: ".$author->getAttribute("ROLE")."</span>";
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
<div id=form_body>
    <h3 style='width:300px; margin:auto; margin-bottom:10px; text-align:center;'>click on the button to get back to the previous page</h3>
    <div style='width:80px; margin:auto;'>
    <button id="submit_button" onclick="goBack()">Back</button>

      <script>
          function goBack() {
            window.history.back();
          }
      </script>
    </div>
</body>
</html>
