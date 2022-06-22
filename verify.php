<?php

//verify.php

include 'database_connection.php';

include 'function.php';

include 'header.php';

if(isset($_GET['code']))
{
	$data = array(
		':user_verificaton_code'		=>	trim($_GET['code'])
	);

	$query = "
	SELECT user_verification_status FROM lms_user 
	WHERE user_verificaton_code = :user_verificaton_code
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	if($statement->rowCount() > 0)
	{
		foreach($statement->fetchAll() as $row)
		{
			if($row['user_verification_status'] == 'No')
			{
				$data = array(
					':user_verification_status'		=>	'Yes',
					':user_verificaton_code'		=>	trim($_GET['code'])
				);

				$query = "
				UPDATE lms_user 
				SET user_verification_status = :user_verification_status 
				WHERE user_verificaton_code = :user_verificaton_code
				";

				$statement = $connect->prepare($query);

				$statement->execute($data);

				echo '<div class="alert alert-success">Your email successfully verify, now you can <a href="user_login.php">login</a> into system.</div>';
			}
			else
			{
				echo '<div class="alert alert-info">Your email already verify</div>';
			}
		}
	}
	else
	{
		echo '<div class="alert alert-danger">Invalid URL</div>';
	}
}

include 'footer.php';

?>