<html>
<head><title>Login to my cool application</title>
</head>
<body>
	
	
	<div align="center">
		<a href=/Home/employeeLogin><button> CLICK HERE TO LOGIN AS EMPLOYEE</button></a>
		<?php
			echo $data['errorMessage'];
		?>
	</br>

		Enter your login information below
		<form action='' method="post">
			<input type="radio" id="business" name="user_type" value="Site">
	  		<label for="business">Business</label>
	  		<input type="radio" id="customer" name="user_type" value="Customer">
	  		<label for="customer">Customer</label><br>
			Username:<input type='text' name='username' /><br />
			Password:<input type='password' name='password' /><br />
			<input type="submit" name="action" value="Login">
		</form>

		<a href='/Home/Register'>Register here</a><br>

	</div>
</body>
</html>