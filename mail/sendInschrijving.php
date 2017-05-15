<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\DeelnemersEvent;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>

<html>
	<head></head>
	<body>
		Hallo <?php echo $mailUsersName; ?>,<br>

		Je ontvangt deze mail omdat <?php echo $mailUsersNameSender ?> je heeft ingeschreven
		op www.kiwi.run voor de hike <?php echo $mailEventName ?>.

		Je bent ingeschreven als <?php echo $mailRolText;
		if ($mailRol == DeelnemersEvent::ROL_deelnemer){
			echo ", voor de groep " . $mailGroupName . ".";
		} else {
			".";
		}?>

		Als je vragen hebt kun je mailen naar de organisatie van de hike <?php echo $mailUsersEmailSender?>.
        <br>
        <br>
		Met vriendelijke groet,<br>
		<br>
		www.kiwi.run<br>
 	</body>
</html>
