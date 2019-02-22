<?php
//Shortcode File Github First test
function kiprlms_grades_csv_sc( $atts ) {
	$a = shortcode_atts( array(
		'name' => 'world'
	), $atts );
	return 'Hello ' . $a['name'] . '!';
}



/*function kiprlms_display_grades_csv(){
	//Get the user
	$user_data = get_userdata(get_current_user_id());

	if($user_data->has_prop('nickname')){

		//Open file and get data, then close
		$url = "https://www.kipr.org/wp-content/uploads/2019 Botball/Documentation/Qatar/qatar-p1-grading-all-subs-2019-02-06.txt";
		$lines = file("https://www.kipr.org/wp-content/uploads/2019 Botball/Documentation/Qatar/qatar-p1-grading-all-subs-2019-02-06.txt");
		$data = array();
		if($lines !== FALSE){
			foreach($lines as &$line){
				$data[] = str_getcsv($line);
			}
		}
		else{echo "File not found";}
		//if(file_exists("https://www.kipr.org/wp-content/uploads/2019 Botball/Documentation/Qatar/qatar-p1-grading-all-subs-2019-02-06.csv")){
			//if($file !== FALSE){
				//while(($line = fgetcsv($file, 100000, ",")) !== FALSE){
					//$data[] = $line;	
				//}
				//echo "Found a file <br>";
			//}
			//else{echo "File not found";}
			//fclose($file);
		//}
		//else{echo "File not existable";}

		$team_num = $user_data->nickname;
		$teamnum_col; $grade_col; $col=0;
		$headers = $data[0];
		foreach($headers as &$header){
			if($header == "Team Name"){
				$teamnum_col = $col;
			}
			if($header == "Grade"){
				$grade_col = $col;
			}
			$col++;
		}

		//Checks to see if any of the graded submissions match the team's team number and then posts if they do
		for($s = 1; $s < sizeof($data); $s++){
			$teamsub = $data[$s];
			if($teamsub[$teamnum_col] == $team_num){
				//printf("How about here");
				//echo "<br>";
				if(!empty($teamsub[$grade_col])){
					echo "<br>";
					echo "<b>Team Name: </b>";echo $teamsub[$teamnum_col-1];
					echo "<br><b>Team Number: </b>";echo $teamsub[$teamnum_col];
					echo "<br><b>Grade: </b>";echo $teamsub[$grade_col];
					echo "<br>";echo "<br>";
					echo "<b>Rubric Scores by Item</b><br><br>";
					echo "	<style>
									table, th, td {
									  border: 1px solid black;
									  border-collapse: collapse;
									}
									th, td {
									  padding: 10px;
									  text-align: left;
									}
								</style>";
					echo "	<table>
									<tr>
										<th>Points Received</th>
										<th>Item</th>
									</tr>";
					for($g=$teamnum_col+1; $g<$grade_col; $g++){
						$print_value = $teamsub[$g];
						$print_label = $headers[$g];
						echo "	<tr>
										<td> $print_value </td>
										<td> $print_label </td>
									</tr>";
					}
					echo "</table><br>";
				}
				break;
			}
		}
	}
}*/

//Method to read in the CSV and process it out as an array.
//Prithviraj Kadiyala
$csv = array();
$lines = file('C:\\xampp\htdocs\wordpress\wp-content\plugins\kiprlms\Qatar.csv', FILE_IGNORE_NEW_LINES);

foreach ($lines as $key => $value)
{
    $csv[$key] = str_getcsv($value);
}

// echo '<pre>';
// print_r($csv);
// echo '</pre>';

function vertical_table($array){
	$html = '<table class="table table-condensed table-bordered neutralize">';   
	$html .='<tbody>';
	$html .='<tr>';
	$html .='<td><b>Question</td>';
	$html .='<td><b>Points</td>';
	$html .='</tr>';
	$rows = count($array[0]);
	echo $rows;
	for ($x = 4; $x <= $rows; $x++){
		$html .='<tr>';
		$html .='<td>'.$array[0][$x].'</td>';
		$html .='<td>'.$array[1][$x].'</td>';
		$html .='</tr>';
	}

	$html .='</tbody>';
	$html .='</table>';
	return $html;
}

echo vertical_table($csv);
?>