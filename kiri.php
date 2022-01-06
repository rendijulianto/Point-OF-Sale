<?php
if ($_GET['module']=='home'){
		echo "<div id='loginForm'>
				<div class='headLoginForm'>Login Administrator</div>
					<div class='fieldLogin'>
						<form method=POST name='formku' onSubmit='return valid()' action=cek_login.php>
						<label>Username</label><br>
						<input type='text' class='login' name='id_user'><br>
						<label>Level</label><br>
						<select style='margin:4px 0px 9px 0px' name=level class='login'>
							<option value='0' selected>&nbsp; &nbsp; - &nbsp; &nbsp; Pilih Level &nbsp; &nbsp; - &nbsp; &nbsp;</option>
							<option value='kasir'>Kasir</option>
							<option value='Admin'>Admin</option>
						</select><br>
						<label>Password</label><br>
						<input type='password' class='login' name='password'><br>
						<input type='submit' class='button' value='Login'>
						</form>
					</div>
			</div>";  
}
?>