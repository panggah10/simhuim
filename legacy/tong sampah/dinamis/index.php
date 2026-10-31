<?php require('config.php');?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Dynamically binding select menus with PHP & jQuery</title>
  <style type="text/css">
  <!--
  p {
    color: #555555;
    font-size: 0.9em;
    line-height: 1.9em;
    margin: 3px 3px 10px;
  }

  a {
    color: #EF1F2F;
    text-decoration: none;
  }

  a:hover {
    text-decoration: underline;
  }

  form input {
    border: 1px solid #999999;
    border-bottom-color: #cccccc;
    border-right-color: #cccccc;
    padding: 5px;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 1.0em;
    margin: 2px;
  }

  #wrapper {
    margin:auto;
    width:900px;
  }
  -->
  </style>
</head>
<body> 

<div id="wrapper">

    <h1>Dynamically binding select menus with PHP & jQuery</h1>

    <p>This demo shows two select menus the second is determined by the first.</p>
 
	<form action='' method='post'>

		<p><label>Book Type:</label>
      <select name='list-select' id='list-select'>
      <option value=''>Pilih Departemen</option>
      <?php
      $stmt = $conn->query('SELECT distinct departemen FROM tbl_dokter');
      while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
          echo "<option value='$row->departemen'>$row->departemen</option>";
      }
      ?>
     </select>
    </p>

    <p><label>Book:</label>
      <select name='list-target' id='list-target'></select>

      <input type="text" id="biaya" name="biaya" value="" readonly required />
	</form>

  <p>Read the full <a href="http://www.daveismyname.com/tutorials/php-tutorials/dynamically-binding-select-menus-with-php-jquery/">Dynamically binding select menus with PHP & jQuery</a> Tutorial</p>

</div>
 
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function($) {
  var list_target_id = 'list-target'; //first select list ID
  var list_select_id = 'list-select'; //second select list ID
  var initial_target_html = '<option value="">Pilih Dokter</option>'; //Initial prompt for target select
 
  $('#'+list_target_id).html(initial_target_html); //Give the target select the prompt option
 
  $('#'+list_select_id).change(function(e) {
    //Grab the chosen value on first select list change
    var selectvalue = $(this).val();
    

    //Display 'loading' status in the target select list
    $('#'+list_target_id).html('<option value="">Loading...</option>');
 
    if (selectvalue == "") {
        //Display initial prompt in target select if blank value selected
       $('#'+list_target_id).html(initial_target_html);
    } else {
      //Make AJAX request, using the selected value as the GET
      $.ajax({url: 'ajax-get-values.php?svalue='+selectvalue,
             success: function(output) {
                //alert(output);
                $('#'+list_target_id).html(output);
            },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status + " "+ thrownError);
          }});

      $.ajax({url: 'get-tarif-rj.php?departemen='+selectvalue,
             success: function(output) {
                //alert(output);
                document.getElementById('biaya').value=output; 
            },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status + " "+ thrownError);
          }});
        }
    });
});
</script>
</body>
</html>