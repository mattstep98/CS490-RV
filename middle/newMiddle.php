<?php
//Group 10 RC Middle
//Matthew Stepnowski

//POST Variables----------------
$username = $_POST["username"];
$password = $_POST["password"];
$message_type = $_POST["message_type"];
$studentAnswer = $_POST["studentAnswer"];
$examName = $_POST["examName"]; 
$examID = $_POST["examID"];
$examQuestionsAndPoints = $_POST["examQuestionsAndPoints"];
$questionID = $_POST["questionID"];
$points = $_POST["points"];
$questionLevel = $_POST["questionLevel"];
$questionTopic = $_POST["questionTopic"];
$questionConstraint = $_POST["questionConstraint"];
$questionDescription = $_POST["questionDescription"];
$comments = $_POST["comments"];
$testCasesInputs = $_POST["testCasesInputs"];
$testCasesOutputs = $_POST["testCasesOutputs"];
$grade = $_POST["grade"];

//Log File--------------------------------------------------------------
$log = fopen("logFile.txt", "a") or die("Unable to open Log File");
$logTxt = "messageType: $message_type".PHP_EOL. "\tusername: $username".PHP_EOL. "\tstudentAnswer: $studentAnswer".PHP_EOL. "\texamName: $examName".PHP_EOL. "\texamID: $examID".PHP_EOL. "\texamQuestionsAndPoints: $examQuestionsAndPoints".PHP_EOL. "\tquestionID: $questionID".PHP_EOL. "\tpoints: $points".PHP_EOL. "\tquestionLevel: $questionLevel".PHP_EOL. "\tquestionTopic: $questionTopic".PHP_EOL. "\tquestionDescription: $questionDescription".PHP_EOL. "\tquestionConstraint: $questionConstraint".PHP_EOL. "\tcomments: $comments".PHP_EOL. "\ttestCasesInputs: $testCasesInputs".PHP_EOL. "\ttestCasesOutputs: $testCasesOutputs".PHP_EOL. "\tgrade: $grade".PHP_EOL.PHP_EOL;
fwrite($log,$logTxt);
fclose($log);

//message_types-------------------------------------------------------
if ($message_type == "login_request"){ //login
  $res_login=login_backEnd($username,$password);
  echo $res_login;
  
}
elseif ($message_type == "create_exam"){ //requests to add an exam to the database
   $res_create_exam=create_exam($examName, $examQuestionsAndPoints); //adds the exam to the database
   echo $res_create_exam;
}

elseif ($message_type == "select_question"){ //selects a question from the question bank
   $res_select_question=select_question($questionID);
   echo $res_select_question;
}
elseif ($message_type == "list_exams"){ //lists all exams in the database
   $res_list_exams = list_exams();
   echo $res_list_exams;
}
elseif ($message_type == "view_results_teacher"){ //views results from back for teacher access
   $res_view_results_teacher = view_results_teacher($username,$examID);
   echo $res_view_results_teacher;
}
elseif ($message_type == "view_results_student"){ //views results from back for student access
   $res_results_student = view_results_student($username,$examID);
   echo $res_results_student;
}
elseif ($message_type == "take_exam"){ //Returns exam information
   $res_take_exam = take_exam($examID);
   echo $res_take_exam;
}
elseif ($message_type == "add_student_answer"){ //adds the students answer to the database and triggers autograding
   $res_add_student_answer = add_student_answer($examID, $questionID, $username, $studentAnswer);
   echo $res_add_student_answer;
}
elseif ($message_type == "get_questions"){ //views all questions in the question bank
   $res_get_questions = get_questions();
   echo $res_get_questions;
}
elseif ($message_type == "teacher_override"){ //Teacher overrides existing score with a new one
   $res_teacher_override = teacher_override($examID,$questionID,$username,$grade,$comments);
   echo $res_teacher_override;
}
elseif ($message_type == "create_question"){ //adds a question to the database
   $res_create_question=create_question($questionDescription, $questionTopic, $questionLevel, $questionConstraint, $testCasesInputs, $testCasesOutputs);
   echo $res_create_question;
}
elseif ($message_type == "release_scores"){ //releases scores for students given an exam
   $res_release_scores=release_scores($examID);
   echo $res_release_scores;
}
elseif ($message_type == "auto_grade"){ //trigger the autograding
  $res_auto_grade=autoGrade($examID, $questionID,$questionDescription, $username, $studentAnswer, $questionConstraint, $testCasesInputs, $testCasesOutputs, $points);
  echo $res_auto_grade;
}  
elseif ($message_type == "list_students_that_took_exam"){ //lists the students who took a certain exam
  $res_list_students_that_took_exam=list_students_that_took_exam($examID);
  echo $res_list_students_that_took_exam;
}  
elseif ($message_type == "list_students"){ //lists all the students
  $res_list_students=list_students();
  echo $res_list_students;
}  
elseif ($message_type == "student_overview"){ //Allow a student to see the grades that are released
  $res_student_overview=student_overview($username);
  echo $res_student_overview;
}  
else{
  echo '{"message_type": "error"}'; //display an error if message_type is not familiar
}

//functions----------------------------------------------------------------------------------------------------
function login_backEnd($username,$password)
{
 	$data = array('username' => $username, 'password' => $password);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/login.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); 
  curl_close ($curl);
  return $res;
}

function create_exam($examName, $examQuestionsAndPoints)
{
 	$data = array('examName' => $examName, 'examQuestionsAndPoints' => $examQuestionsAndPoints);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/createExam.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); 
  curl_close ($curl);
  return $res;
}

function create_question($questionDescription, $questionTopic, $questionLevel, $questionConstraint, $testCasesInputs, $testCasesOutputs)
{
 	$data = array('questionDescription' => $questionDescription, 'questionTopic' => $questionTopic, 'questionLevel' => $questionLevel, 'questionConstraint' => $questionConstraint, 'testCasesInputs' => $testCasesInputs, 'testCasesOutputs' => $testCasesOutputs);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/createQuestion.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); 
  curl_close ($curl);
  return $res;
}

function select_question($questionID)
{
 	$data = array('questionID' => $questionID);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/selectQuestion.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); 
  curl_close ($curl);
  return $res;
}

function list_exams()
{
 	$data = array();
 	$url = "https://web.njit.edu/~mjs239/CS490/database/listExams.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); 
  curl_close ($curl);
  return $res;
}

function take_exam($examID)
{
 	$data = array('examID' => $examID);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/takeExam.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); 
  curl_close ($curl);
  return $res;
}

function add_student_answer($examID, $questionID, $username, $studentAnswer)
{
 	$data = array('examID' => $examID,'questionID' => $questionID,'username' => $username,'studentAnswer' => $studentAnswer);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/addStudentAnswer.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); 
  curl_close ($curl);
  return $res;
}

function teacher_override($examID,$questionID,$username,$grade,$comments)
{
 	$data = array('examID' => $examID, 'questionID' => $questionID,'username' => $username,'grade' => $grade,'comments' => $comments);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/teacherOverride.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); 
  curl_close ($curl);
  return $res;
}

function list_students_that_took_exam($examID)
{
 	$data = array('examID' => $examID);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/listStudentsThatTookExam.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); 
  curl_close ($curl);
  return $res;
}

function list_students()
{
 	$data = array();
 	$url = "https://web.njit.edu/~mjs239/CS490/database/listStudents.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); 
  curl_close ($curl);
  return $res;
}

function view_results_teacher($username,$examID)
{
 	$data = array('examID' => $examID, 'username' => $username);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/viewResultsTeacher.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); 
  curl_close ($curl);
  return $res;
}

function view_results_student($username,$examID)
{
 	$data = array('examID' => $examID, 'username' => $username);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/viewResultsStudent.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); 
  curl_close ($curl);
  return $res;
}

function get_questions()
{
 	$data = array();
 	$url = "https://web.njit.edu/~mjs239/CS490/database/allQuestions.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); 
  curl_close ($curl);
  return $res;
}

function release_scores($examID)
{
 	$data = array('examID' => $examID);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/releaseScores.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); 
  curl_close ($curl);
  return $res;
}

function autoGrade($examID, $questionID,$questionDescription, $username, $studentAnswer, $questionConstraint, $testCasesInputs, $testCasesOutputs, $points)
{
  $data = array('examID' => $examID, 'questionID' => $questionID,'questionDescription' => $questionDescription, 'username' => $username, 'studentAnswer' => $studentAnswer, 'questionConstraint' => $questionConstraint, 'testCasesInputs' => $testCasesInputs, 'testCasesOutputs' => $testCasesOutputs, 'points' => $points);
 	$url = "https://web.njit.edu/~mjs239/CS490/rc/autoGrade.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); 
  curl_close ($curl);
  return $res;
}

function student_overview($username)
{
  $data = array('username' => $username);
 	$url = "https://web.njit.edu/~mjs239/CS490/database/studentOverview.php";
 	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 	$res = curl_exec($curl); 
  curl_close ($curl);
  return $res;
}
?>