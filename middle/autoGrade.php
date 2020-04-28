<?php
//autoGrade.php, Matthew Stepnowski
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
$correctAnswer = false;

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
while (($studentAnswer[$programFunctionCounter] != "(") && ($studentAnswer[$programFunctionCounter] != " ")) //goes through function name starting after "def " and ending when it hits a " " or (
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
if((empty($questionConstraint)) or (strpos($studentAnswer, $questionConstraint) !== false)){
  $hasConstraint = true;
}else{
  $hasConstraint = false;
}

//Checking if the student remembered to put a colon
$counter = 0;

while($studentAnswer[$counter] != "\n" and $counter < 100){
  if ($studentAnswer[$counter] == ")" and $studentAnswer[$counter+1]=="\n"){
    $studentAnswer = substr_replace($studentAnswer, ':', $counter+1,0);
    $hadColon = false;
    break;
  }
  $counter++;
}

//determine how many inputs we need to test
$testCaseCounter = 0;
$loopCouter = 0;
$inputCounter=0;
$inputs="";
$outputs="";
$overallGrade = 0;

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
  $correctAnswer = false;
  if (strcmp($pyOutput,$outputs)==0){
    $correctAnswer = true;
  }
  
//Grade results to put in array  
  $finalCorrectOutput = "";
  $finalCorrectName = "";
  $finalHadColon = "";
  $finalhadConstraint = "";
  $percentage = 1;
  
//Grading decisions
  if($correctAnswer==true){
    $finalCorrectOutput = "true";
  }
  else{
    $finalCorrectOutput = "false";
    $percentage -=0.25;
  }
  if($correctName==true){
    $finalCorrectName = "true";
  }
  else{
    $finalCorrectName = "false";
    $percentage -=0.25;
  }
  if($hadColon==true){
    $finalHadColon = "true";
  }
  else{
    $finalHadColon = "false";
    $percentage -=0.25;
  }
  if($hasConstraint==true){
    $finalHadConstraint = "true";
  }
  else{
    $finalHadConstraint = "false";
    $percentage -=0.25;
  }
  
  $grade = $percentage*($points/($numTestCases));
  $tcTotalGrade = $points/($numTestCases);
  $overallGrade += $grade;
  
  $finalGrading = array();
  $finalGrading["correctOutput"] = $finalCorrectOutput;
  $finalGrading["correctName"] = $finalCorrectName;
  $finalGrading["hadColon"] = $finalHadColon;
  $finalGrading["hadConstraint"] = $finalHadConstraint;
  $finalGrading["points"] = $grade;
  $finalGrading["totalPoints"] = $tcTotalGrade; 
  
  $testCaseCounter++;
  $keyName = ($testCaseCounter);
  $keyName = "TC$testCaseCounter"."Comments";
  $tcComments[$keyName] = $comments;
  
  $keyName = "TC$testCaseCounter"."Grade";
  $tcGrades[$keyName] = $finalGrading;
  
  $inputs = "";
  $loopCounter=0;
  $correctAnswer = false;
}

$tcGrades["totalPoints"] = $points;  

$row["examID"] = $examID;
$row["questionID"] = $questionID;
$row["username"] = $username;
$row["grade"] = $tcGrades;
$row["overallGrade"] = $overallGrade; 

$json = json_encode($row);
echo ($json);

$log = fopen("../rc/logFile.txt", "a") or die("Unable to open Log File"); //writes information to the log
$logTxt = "GRADING RESULT: ".$json.PHP_EOL.PHP_EOL;
fwrite($log,$logTxt);
fclose($log);

?>