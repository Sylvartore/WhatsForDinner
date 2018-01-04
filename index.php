<?php
	session_start();
?>
<html lang="en">
	<head>
		<meta content="utf-8">
		<title>What's for dinner?</title>
        <link href="css/superhero/bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="css/style.css">
		<link href="http://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet" type="text/css">
		<link href="http://fonts.googleapis.com/css?family=Vollkorn" rel="stylesheet" type="text/css">
		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script> 
	</head>
	<body>
	    <div class="container">
	    	<div class="row">
	    		<div class="col-xs-12">
	    			<div class="jumbotron">
	    				<h1>What's for dinner?</h1>
	    				<h4>A nutrient-based food recommendation app</h4>
	    			</div>
	    		</div>
	    	</div>
			
			<p>The following table lists the daily recommended allowance of macronutrients</p> <br />
			<table class="table upper-table">
				<tr>
					<td>Fats(g)</td>
					<td>Carbohydrates(g)</td>
					<td>Proteins(g)</td>
				</tr>
				<tr>
					<td>55</td>
					<td>250</td>
					<td>100</td>
				</tr>
			</table>
			<p class="sub">Enter the consumed macronutrients below:</p>
            <form class="form-inline text-center" role="form" method="post" action="process.php">
	        	<div class="form-group">
	            	<label class="control-label" for="number">Fats:</label>
	            	<input name="fats" class="right" type="number" id="number" placeholder="0" required="required">
	            </div>
	            <div class="form-group">
	            	<label class="control-label">Carbohydrates:</label>
	            	<input name="carbs" class="right" type="number" id="number" placeholder="0" required="required">
	            </div>
	            <div class="form-group">
            		<label class="control-label">Proteins:</label>
            		<input name="proteins" class="right" type="number" id="number" placeholder="0" required="required">
            	</div>
				<div class="row text-center">
	            	<button name="submit" type="submit" class="btn btn-primary">Find Food</button>
		       	</div>
			</form>
	       	<hr />
	       	<?php

	       		//echo $_SESSION['output'];
	       		//table for output

				$table = '<div><table class="table table-stripe table-hover"><tr><td>Name</td><td>Energy(cal)</td><td>Protein(g)</td><td>Fats(g)</td><td>Carbs(g)</td></tr>';
				for ($y = 0; $y < count($_SESSION['output']); $y++) {
					$table .= '<tr>';
					for ($x = 0; $x < count($_SESSION['output'][$y]); $x++ ) {
						$table .= '<td>' .  $_SESSION['output'][$y][$x] . '</td>';
					}
					$table .= '</tr>';
				}
				$table .= '</table></div>';
				echo $table;
				
				session_destroy();
			?>
       	</div>
	</body>
</html>