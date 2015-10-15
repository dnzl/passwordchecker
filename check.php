<?php
require_once 'spyc.php'; //YAML parser class
require_once 'passwordchecker.php';

$br=PHP_EOL;
if(isset($_SERVER['TERM'])){
  //run from terminal
  $verbose=(isset($argv[1]) && $argv[1]=='-v');
}else{
  //run from browser
  $verbose=(isset($_GET['v']) && $_GET['v']!='false');
  $br='<br>';
}

//load the config from the yaml and make the connection
$config=Spyc::YAMLLoad('config.yml');
$db=$config['database'];
$mysqli=new mysqli($db['host'],$db['user'],$db['pass'],$db['db']);
if($mysqli->connect_errno){
  die("Failed to connect to MySQL: (".$mysqli->connect_errno.") ".$mysqli->connect_error);
}

//instance my pass checker class and set the rules from the config yaml file
$PasswordChecker=new PasswordChecker();
$PasswordChecker->setRules($config['rules']);

$r=$mysqli->query("SELECT * FROM passwords");
while($row=$r->fetch_assoc()){
  $pass=$row['password'];
  if($verbose){echo 'Password "'.$pass.'" is ';}
  if($PasswordChecker->check($pass)){
    //is valid, update the field
    $mysqli->query("UPDATE `passwords` SET `valid` = 1 WHERE `id` = ".(int)$row['id']);
    if($verbose){
      echo ' VALID ';
    }
  }else{
    //invalid, nothing to do
    if($verbose){
      $err=$PasswordChecker->getErrors($pass);
      echo ' INVALID: '.$br
           .implode($br,$err); //show errors
    }
  }
  if($verbose){echo $br.'-----------------------------------'.$br;}
}

?>