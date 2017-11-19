<html>
	<head>
		<title>STMIK Mahakarya</title>
		<style>
			.login-box	{
				margin:0;padding:0;
				border: 0px solid white;
				width : 40%;height:290px;
				padding:5px;margin:0 auto;
                                margin-top:8em;
				text-align : center;
			}
			.neon	{
				background-color : #0134c5;
				background : -moz-radial-gradient(top,grey,black);
				-moz-box-shadow : inset 0px 0px 10px 5px grey, 0px 5px 20px 0px silver; 
				//-moz-box-shadow : 0px 0px 10px 5px silver; 
			}
			.radius10	{
				border-radius : 10px;
			}
			.login-box legend	{
				color : white;
				font-family : comic sans ms;
                                font-size: 1.5em;font-weight:bold;
				background:  #0134c5;
                                border-radius: 40%;
				//text-shadow: 2px 1px 0px silver;
                                padding : 10px;
                                width: 400px;
			}
			.frm	{
				padding : 0;margin-top:5%;
				height : 80%;
			}
			.frm input[type=text],input[type=password]	{
				padding : 8px;
				width : 92%;border-radius: 4px;
				font-family : arial;
			}
			.frm input	{
				margin-top : 20px;
                                font-family: sans-serif;
			}
			.frm-action	{
				margin-right: 4%;
			}
			.frm-action input[type=submit]	{
				padding : 10px;
				//background : -moz-linear-gradient(top,green,silver);
                                background : #00cc33;
                                color: white;
                                border: 0px solid white;
				//border-radius : 4px;
				//box-shadow : inset 0px 0px 5px 1px silver, 0 0 1px 1px grey;
				font-weight: bold;font-family: arial;
			}
			.text-left	{
				text-align: left;
			}
			.text-center	{
				text-align: center;
			}
			.text-right	{
				text-align: right;
			}
		</style>
	</head>
	<body bgcolor="white">
		<fieldset class="login-box neon radius10">
			<legend>STMIK Mahakarya</legend>
			<form action="<?php echo base_url('login/proses_login'); ?>" method="post" class="frm">
				<input type="text" placeholder="Username" name="username" title="Place Your Username Here">
				<br/>
				<input type="password" placeholder="Password" name="password" title="Place Your Password Here">
				<br/>
				<div class="frm-action text-right">
					<input type="submit" name="submit" value="Login">
				</div>
			</form>
		</fieldset>
	</body>
</html>