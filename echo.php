<?php
$file = fopen("input.txt","r");
/*
*Read file line by line and process it
*/
$supported_staranger_id_count = 0;
while(($line = fgets($file)) !== false) {
	$continue = false;

	/*
	* using regular expression to extract the text inside the square bracket
	*/
	preg_match_all("/\[(.*?)\]/", $line, $matches);
	//loop through the strings inside all the square brackets
	// print_r($matches);
	if(isset($matches[1]) && !empty($matches[1])){
		foreach ($matches[1] as $inner_string) {
			switch(strlen($inner_string)<>4){
				case 0:
					/*
					* 	if length of inner string in bracket is 4 and is of "baab" type 
					*	go to next line and count for this line is zero
					*/

					if($inner_string[0]!=$inner_string[1] && $inner_string == strrev($inner_string)){
						$continue = true;
					}
					break;
				case 1:
					/* 
					*   if length of inner string in bracket is greater than 4 and is of "baab" type 
					*   go to next line and count for this line is zero
					*/
					for($i=0;$i<strlen($inner_string)-4;$i++){
						$substr_inner = substr($inner_string,$i,4);
						if($substr_inner == strrev($substr_inner) && $substr_inner[0] != $substr_inner[1]){
							$continue = true;
							break;
						}
					}
					break;
			} //end switch
			/*
			*  break the foreach loop if any "baab" type substring occurs inside bracket 
			*  no need to check further 
			*/
			if($continue){
				break;
			}
		} // end foreach

	}else{
		switch(strlen($line)<>4){
			case 0:
				/*
				* 	if length of line is 4 and is of "baab" type and has no brackets 
				*	count it as one , this is a match
				*/

				if($line[0]!=$line[1] && $line == strrev($line)){
					$supported_staranger_id_count++;
					$continue = true;
					// echo $line."\n";
				}
				break;
			case 1:
				/*
				* 	if length of line is greater than 4 and is of "baab" type and has no brackets 
				*	count it as one , this is a match
				*/
				for($i=0;$i<strlen($line)-4;$i++){
					$substr_inner = substr($line,$i,4);
					if($substr_inner == strrev($substr_inner) && $substr_inner[0] != $substr_inner[1]){
						$supported_staranger_id_count++;
						$continue = true;
						// echo $line."\n";
						break;
					}
				}
				break;
		} //end switch
	}
	if($continue){
		/*
		*  break the foreach loop if any "baab" type substring occurs inside bracket 
		*  no need to check further and go to next line
		*/
		continue;
	}else{  
		/* 
		*	if sub-strings inside square bracket is not "baab" type  
		*	Check sub-strings outside the bracket , if "baab" type 
		*/
		$outer_matches = preg_split("/\[(.*?)\]/", $line);
		foreach ($outer_matches as $outer_string) {
			switch(strlen($outer_string)<>4){
				case 0:
					/*
					* 	if length of outer string is 4 and is of "baab" type 
					*	count it as one , this is a match
					*/

					if($outer_string[0]!=$outer_string[1] && $outer_string == strrev($outer_string)){
						$supported_staranger_id_count++;
						$continue = true;
						// echo $line."\n";
					}
					break;
				case 1:
					/*
					* 	if length of outer string is greater than 4 and is of "baab" type 
					*	count it as one , this is a match
					*/
					for($i=0;$i<strlen($outer_string)-4;$i++){
						$substr_inner = substr($outer_string,$i,4);
						if($substr_inner == strrev($substr_inner) && $substr_inner[0] != $substr_inner[1]){
							$supported_staranger_id_count++;
							$continue = true;
							// echo $line."\n";
							break;
						}
					}
					break;
			} //end switch
			if($continue){
				break;
			}
		} // end foreach
	}//end
} // end while
echo "Total Number of Valid StangerID : ".$supported_staranger_id_count;
fclose($file);
?>