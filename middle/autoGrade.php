<?php
$examID = $_POST["examID"];
$questionID = $_POST["questionID"];
$questionDescription = $_POST["questionDescription"];
$username = $_POST["username"];
$studentAnswer = $_POST["studentAnswer"];
$testCasesInputs = $_POST["testCasesInputs"];
$testCasesOutputs = $_POST["testCasesOutputs"];
$points = $_POST["points"];
$questionConstraint = $_POST["questionConstraint"];


//Graded Vars------------------------------------
$correctName = false;
$tcComments= array();
$tcGrades = array();
$comments = "";
$testCaseGrade = 0;
$hasConstraint = false;
$hadColon = true;



//----------------------------------------------





$explodedInput = array();
$explodedInput = explode(",",$testCasesInputs);
$explodedOutput = array();
$explodedOutput = explode(",",$testCasesOutputs);

$numInputs = (sizeof($explodedInput)/sizeof($explodedOutput)); //determines how many inputs there are for each output
$numTestCases = sizeof($explodedOutput); //determines how many test cases there are


$inputCounter = 0;
$programFunctionCounter = 23;
$programFunctionName = "";


//Checking if the name of the written function matches what was given in the question
while($questionDescription[$programFunctionCounter] != ' '){
  $programFunctionName .=$questionDescription[$programFunctionCounter];
  $programFunctionCounter++;
}

$programFunctionCounter = 4;
$studentFunctionName = "";
while (($studentAnswer[$programFunctionCounter] != "(") && ($studentAnswer[$programFunctionCounter] != " ")) //goes through function name starting after "def " and ending when it hits a " " or {
{
  $studentFunctionName = $studentFunctionName .= $studentAnswer[$programFunctionCounter];
  $programFunctionCounter++;
}
$studentFunctionName = str_replace(' ', '', $studentFunctionName);
if ($studentFunctionName == $programFunctionName)
{
  $correctName = true;
}

//Checking if the studentAnswer has the constraint in it

if(strpos($studentAnswer, $questionConstraint) != false){
  $hasConstraint = true;
}

//Checking if the student remembered to put a colon
$counter = 0;
while($studentAnswer[$counter] != "\n" and $counter != 100){
  if ($studentAnswer[$counter] == ")" and $studentAnswer[$counter+1]=="\n"){
    $studentAnswer = substr_replace($studentAnswer, ':', $counter+1,0);
    $hadColon = false;
    break;
  }
  $counter++;
}

//determines how much to deduct per incorrect test case test
$deduction = $points/$numTestCases;
$deduction = round($deduction,2,PHP_ROUND_HALF_UP);



//determine how many inputs we need to test
$testCaseCounter = 0;
$loopCouter = 0;
$inputCounter=0;
$inputs="";
$outputs="";
$correctAnswer = false;

while($testCaseCounter < $numTestCases){
  for($loopCounter=0;$loopCounter<$numInputs;$loopCounter++){
    $inputs .= $explodedInput[$inputCounter].",";
    $inputCounter++;
  }
  $outputs = ($explodedOutput[$testCaseCounter]);
  $inputs = substr($inputs,0,-1);
  
  $pythonHeader = "#!/usr/bin/env python \nimport sys\n";
  $str_code = $studentAnswer.PHP_EOL."print(".$studentFunctionName."(".$inputs."));";
  $myfile = fopen('pyCode.py', 'w') or die("Unable to open file!");
  $txt = $pythonHeader.$str_code;
  fwrite($myfile, $txt);
  fclose($myfile);
  
  $pyOutput = shell_exec('python ./pyCode.py');
  $pyOutput = substr($pyOutput,0,-1);
  $comments = "";
  $grade = $points;
  

  if (strval($pyOutput) == strval($outputs)){
    $correctAnswer = true;
  }
  
  
  
  
  if($correctAnswer==true){
    $comments .= "Correct Output!\n";
  }
  else{
    $comments .= "Wrong Output\n";
    $grade = $grade - $deduction;
  }
  if($correctName==true){
    $comments .= "You put the correct Function Name\n";
  }
  else{
    $comments .= "You put the wrong Function Name\n";
    $grade = $grade - $deduction;
  }
  
  if($hadColon==true){
    $comments .= "You remembered your colon\n";
  }
  else{
    $comments .= "You forgot your colon\n";
    $grade = $grade - $deduction;
  }
  
  if($hasConstraint==true){
    $comments .= "You used the correct restraint\n";
  }
  else{
    $comments .= "You did not use the correct restraint\n";
    $grade = $grade - $deduction;
  }
  
  if($grade > $points){
    $grade = $points;
  }
  elseif($grade > $points-2){
    $grade = $points;
  }
  
  $testCaseCounter++;
  $keyName = ($testCaseCounter);
  $keyName = "TC$testCaseCounter"."Comments";
  $tcComments[$keyName] = $comments;
  
  $keyName = "TC$testCaseCounter"."Grade";
  $tcGrades[$keyName] = $grade;
  
  
  
  
  $inputs = "";
  $loopCounter=0;
  $correctAnswer = false;
  
  
}

$row["examID"] = $examID;
$row["questionID"] = $questionID;
$row["username"] = $username;
$row["grade"] = $tcGrades;
$row["comments"] = $tcComments;
 


$json = json_encode($row);
echo $json;





?>