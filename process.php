<?php
	session_start();
	extract($_POST);

	//Calculations for deciding search criteria.
	$_SESSION['fats'];
	$_SESSION['proteins'];
	$_SESSION['carbs'];
	$_SESSION['message'];

	$daily_carbs = 250;
	$daily_proteins = 100;
	$daily_fats = 55;

	$missing_proteins = $proteins / $daily_proteins;
	$missing_fats = $fats / $daily_fats;
	$missing_carbs = $carbs / $daily_carbs;

	$_SESSION['fats'] = $fats / 55;
	$_SESSION['proteins'] = $proteins / 100;
	$_SESSION['carbs'] = $carbs / 250;

	//Retrieve data from parser.
	$json = file_get_contents("./food_list.json");
	$_SESSION['output'];
	$result = array();
	$temp = array();

	$someArray = json_decode($json, true);
	foreach($someArray["report"]["foods"] as $value) {
		array_push($temp, $value['name']);
		foreach($value['nutrients'] as $vals) {
			array_push($temp, $vals['gm']);
		}
		array_push($result, $temp);
		$temp = array();
	}/*
	foreach($result as $entry) {
		foreach($entry as $val){
		  echo "<p>" . $val . "</p>";
		}
	}*/
		
	$_SESSION['output'] = selection_sort($result);

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	//Selection Sort
	$fpcArr = [0, 0, $protein, $fats, $carbs];
	
	//Calculates which one we need to search for
	$fatPercent = $_SESSION['fats'];
	$proteinPercent = $_SESSION['proteins']; 
	$carbPercent = $_SESSION['carbs'];

	$searchCriteria; 

	function selection_sort($data) {
	
	//Stores the results
	$temp = $data;
	$results = array();	
	
	//Checks which percentage is highest and gives it a flag variable, 3 being fat, 2 being protein, 4 being carb
	if($_SESSION['fats'] < $_SESSION['proteins'] && $_SESSION['fats'] < $_SESSION['carbs']){
		//echo "You need more fats.";
		$searchCriteria = 3;
	} else if($_SESSION['proteins'] < $_SESSION['fats'] && $_SESSION['proteins'] < $_SESSION['carbs']){
		//echo "You need more proteins.";
		$searchCriteria = 2;
	} else if($_SESSION['carbs'] < $_SESSION['proteins'] && $_SESSION['carbs'] < $_SESSION['proteins']){
		//echo "You need more carbs.";
		$searchCriteria = 4;
	} else{
		//echo "You have a good diet.";
		$searchCriteria = rand(2, 4);
	}
	/*
	if ($searchCriteria < $proteinPercent) {
		$searchCriteria = 2;
		if ($searchCriteria < $carbPercent) {
			$searchCriteria = 4;
		}
	} else if($searchCriteria < $carbPercent) {
		$searchCriteria = 4;
	}*/

	//Selection sort
	//$max = rand(0, 100);
	for($i=0; $i<count($temp)-1; $i++) {
		$max = $i;
		for($j=$max+1; $j<count($temp); $j++) {

			//Checks for the highest amount of nutrient that is within + 50 limit
			if ($temp[$j][$searchCriteria]>$temp[$max][$searchCriteria] /*&& $temp[$max][$searchCriteria] < $fpcArr[$searchCriteria] + 50*/) {
				$max = $j;
			}
		}
		
	    $temp = swap_positions($temp, $i, $max);

	}
	
    for ($n=0;$n<400;$n+=40) {
		array_push($results, $temp[$n]);
    }
	return $results;

	}

	//Swaps position
	function swap_positions($data1, $left, $right) {
		$backup_old_data_right_value = $data1[$right];
		$data1[$right] = $data1[$left];
		$data1[$left] = $backup_old_data_right_value;
		return $data1;
	}

	header('Location: index.php');
?>