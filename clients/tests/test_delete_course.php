<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: add on course
* @param integer $client
* @param string $sesskey
* @param string $value
* @param string $id
* @return  editCoursesOutput
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->delete_course($lr->getClient(),$lr->getSessionKey(),'','');
print_r($res);
print($res->getCourses());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
