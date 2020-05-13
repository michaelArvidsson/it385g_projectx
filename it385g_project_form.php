<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bookservice</title>
  <style>
     #head {
        background-color: #EDECE8;
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
  form {
        width:800px;
        background-color: #EDECE8;
        padding:50px;
        margin:auto;      
        box-shadow: 2px 2px 4px 2px;
    }
    #form_body {
        Width:700px;
        margin:auto;
        font-weight:bold;
        font-size:15px;
    }

  </style>
</head>
<body>
    <h1 id='head'>Bookservice</h1>
    <form method='POST' action='it385g_project_response.php'>
    <div id=form_body>
      <h3>Select and search stuff</h3>
      <div>
          <label>Category</label>
          <input type='text' name='category' placeholder="Searchfield"/>
      </div>
      <div>
          <label>Title</label>
          <input type='text' name='title' placeholder="Searchfield" />
      </div>
      
    
<?php
 
      $xml = file_get_contents('https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/books/?id=ALL');
      $dom = new DomDocument;
      $dom->preserveWhiteSpace = FALSE;
      $dom->loadXML($xml);

      $xml = file_get_contents('https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/authors?role=Author');
      $dom2 = new DomDocument;
      $dom2->preserveWhiteSpace = FALSE;
      $dom2->loadXML($xml);

   /*    echo "<label> ID </label>";
      echo "<select name='ID'>";
      echo "<option value=''>---"; */
  /*     $books= $dom->getElementsByTagName('BOOK');
      foreach ($books as $book){
        echo "<option value='".$book->getAttribute("ID")."'>";
        echo $book->getAttribute("ID");       
        echo "</option>";
      } */
      echo "<div>";
      echo "</select>";
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
        echo "<option value='$last'>";
        echo $first;
        echo " "; 
        echo $last;    
        echo "</option>";
      }
      echo "</select>";
      echo "</div>";
?>
      
      <input style='margin:10px'; type='submit' name='submitbutton' value='Show result'>
    </div>
    </form>
    
</body>
</html>