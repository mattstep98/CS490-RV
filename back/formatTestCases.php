//formatTestCases.php, Matthew Stepnowski ...This was a testing file for working out a way for the front to send easy and readable test cases, not in use, found a better way.

$TESTCASE1IN = array();
$TESTCASE2IN = array();
$TESTCASE3IN = array();
$TESTCASE4IN = array();
$TESTCASE5IN = array();
$TESTCASE6IN = array();

$testCases1inputs = array(1,2,3);
$testCases2inputs = array(4,2,3);
$testCases3inputs = array(1,7,3);
$testCases4inputs = array(1,1,3);
$testCases5inputs = array(1,2,9);
$testCases6inputs = array(2,2,3);

$testCases1output = 1;
$testCases2output = 2;
$testCases3output = 4;
$testCases4output = 2;
$testCases5output = 4;
$testCases6output = 5;

foreach($testCases1inputs as $TC1in){
  $TESTCASE1IN[] = $TC1in;
}
foreach($testCases2inputs as $TC2in){
  $TESTCASE2IN[] = $TC2in;
}
foreach($testCases3inputs as $TC3in){
  $TESTCASE3IN[] = $TC3in;
}
foreach($testCases4inputs as $TC4in){
  $TESTCASE4IN[] = $TC4in;
}
foreach($testCases5inputs as $TC5in){
  $TESTCASE5IN[] = $TC5in;
}
foreach($testCases6inputs as $TC6in){
  $TESTCASE6IN[] = $TC6in;
}

$TESTCASE1IN = ("[".implode(",",$TESTCASE1IN)."],");
$TESTCASE2IN = ("[".implode(",",$TESTCASE2IN)."],");
$TESTCASE3IN = ("[".implode(",",$TESTCASE3IN)."],");
$TESTCASE4IN = ("[".implode(",",$TESTCASE4IN)."],");
$TESTCASE5IN = ("[".implode(",",$TESTCASE5IN)."],");
$TESTCASE6IN = ("[".implode(",",$TESTCASE6IN)."]");



$sendMe = "["."[".$TESTCASE1IN.$testCases1output."]".$TESTCASE2IN.$testCases2output."]".$TESTCASE3IN.$testCases3output."]".$TESTCASE4IN.$testCases4output."]".$TESTCASE5IN.$testCases5output."]".$TESTCASE6IN.$testCases6output."]"."]";



echo $sendMe;