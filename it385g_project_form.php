<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bookservice</title>
  <style>
     #head {
        background-color: #fdf3ea;
        color:darkslategrey;
        width:100%;
        font-size: 200%;
        font-weight: bold;
        letter-spacing: 5px;
        text-align: center;
        text-shadow: 2px 2px rgba(0, 0, 0, 0.1);
        padding:10px;
        margin-top:0px;
        margin-bottom:10px;
    }

    #form_body {
        Width:800px;
        background-color: #fdf3ea;
        margin:auto;
        font-weight:bold;
        font-size:15px;
        box-shadow: 2px 2px 4px 2px;
        padding: 20px;
    }
    fieldset {
      width: 600px;
      margin: auto;
      margin-bottom:20px;
      
    }
 

  </style>
</head>
<body>
    <h1 id='head'>Bookservice</h1>
    
    <div id=form_body>
      <fieldset>
      <legend>Select</legend>
      
<?php
 
      $xml = file_get_contents('https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/category/?categorysearch=ALL');
      $dom = new DomDocument;
      $dom->preserveWhiteSpace = FALSE;
      $dom->loadXML($xml);

      $xml = file_get_contents('https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/authors?role=Author');
      $dom2 = new DomDocument;
      $dom2->preserveWhiteSpace = FALSE;
      $dom2->loadXML($xml);

      $xml = file_get_contents('https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/authors?role=ALL');
      $dom3 = new DomDocument;
      $dom3->preserveWhiteSpace = FALSE;
      $dom3->loadXML($xml);


      echo "<form method='POST' action='it385g_project_categoryresponse.php'>";
      echo "<label> Category </label>";
      echo "<select name='category'>";
      echo "<option value=''>---";
      $categories= $dom->getElementsByTagName('CATEGORY');
      foreach ($categories as $category){
        foreach ($category->childNodes as $child){
        $text=trim($child->nodeValue);
        if($text!=""){
          echo "<option value=$text>";
            echo $text;
            echo "</option>";
        }
        }
      }
      echo "<input style='margin:10px'; type='submit' name='submitbutton' value='Show result'>";
      echo "</select>";
      
      echo "</form>";
      echo "<h4 style='margin:5px;'>Or</h4>";
      echo "<form method='POST' action='it385g_author_response.php'>";
      echo "<label> Author </label>";
      echo "<select name='author'>";
      echo "<option value=''>---";
      $authors= $dom2->getElementsByTagName('AUTHOR');
      foreach ($authors as $author){
        foreach ($author->childNodes as $child){
          if($child->nodeName=="FIRSTNAME"){
            $first = $child->nodeValue;
              
          }else if($child->nodeName=="LASTNAME"){
            $last = $child->nodeValue;
                   
          }         
        }       
        echo "<option value='firstname=$first&lastname=$last'>";
        echo $first;
        echo " "; 
        echo $last;    
        echo "</option>";
      }

      echo "<input style='margin:10px'; type='submit' name='submitbutton' value='Show result'>";
      echo "</select>";
      echo "</form>";
      echo "</fieldset>";
          
?>
    <div>
          <fieldset>
          <legend>search by</legend>
          <form method='POST' action='it385g_title_response.php'>
          <label>Booktitle</label>
          <input type='text' name='title' placeholder=" Searchfield"/>
          <input style='margin:10px'; type='submit' name='submitbutton' value='Show result'>
          </form>  
          <h4 style='margin:5px;'>Or</h4>
          <form method='POST' action='it385g_role_response.php'>
          <label>Author role</label>
          <input type='text' name='author_role' placeholder=" Author/Editor/Translator"/>
          <input style='margin:10px'; type='submit' name='submitbutton' value='Show result'>
          </form>  
          </fieldset>
      </div>

      
    </div>
    
    
</body>
</html>