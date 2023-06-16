<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!--Font Link-->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap" rel="stylesheet">
		<title>
			Invoice
		</title>
		<style>
			* {
			padding: 0;
			margin: 0 auto;
			box-sizing: border-box;
			color: #000000;
			font-family: "Roboto", sans-serif;
			
			}
			.main_outer_container{
				width:80%;
				margin: 0 auto;
				background:#ffffff;
				border: 1px solid #e1e1e1;
				
			}
			
			table {
			  border-collapse: collapse;
			  border-spacing: 0;
			 
			  
		   }
		   th, td {
			  text-align: left;
			  padding: 8px;
		   }
		   
		    
@media  only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
	.main_outer_container{
				width:130%!important;
				overflow-x: auto!important;
	}
	

}
			
	
		</style>
	</head>
	<body> 
	<div class="main_outer_container">
	
		<table style="background: rgb(39, 174, 96); padding: 4px; width:100%; padding-left: 15px; padding-right: 15px">
			<tr>
				<td style="text-align: left;">
					
				</td>
				<td style="text-align: right; font-size: 14px; color: #ffffff;">
					
					<strong style="color: #ffffff">Welcome to Mastigram</strong>
				</td>
			</tr>
		</table>
		<table style="width:100%; padding: 10px; padding-left: 15px; padding-right: 15px; text-align: left; font-size: 14px;">
			<tr>
				<td style="padding-left: 0px; padding-right: 0px; text-align: left;">
					<h3 style="padding-bottom: 10px; font-weight: 600; font-size: 15px;padding-left: 25px; padding-top:10px"> Dear <?php echo e($data->name); ?>,</h3>
					<p style="font-size: 12px;"> Here is your login credentials for Mastigram. </p> 
				</td>
				<td style="padding-left: 0px; padding-right: 0px; text-align: right;">
					<h4 style="padding-bottom: 6px; font-weight: 400; font-size: 12px;">
					
					</h4>
					<h4 style="font-weight: 400; font-size: 12px;">
					
					</h4>
				</td>
			</tr>
		</table>
		<table style="background: #f5f9ff; width:96%; padding: 10px; padding-left: 15px; padding-right: 15px; margin: auto; border: 1px solid #e1e1e1;">
			<tr>
				<td style="vertical-align: top;">
					<ul style="list-style-type: none;">
						<li style="padding-top: 0px;">
							<div style=" margin-bottom: 0px; padding-top: 0px;">
								<h2 style="width: 25%; float: left; font-size: 14px; font-weight: 400;"> Email: </h2>
								
								<h2 style="width: 25%; float: left; font-size: 14px; font-weight: 800;"> <?php echo e($data->email); ?> </h2>
								
							</div>
							<p style="width: 100%; padding-top: 26px; font-size: 12px;">
							
							
							</p>
						</li>
						<li style="padding-bottom: 28px; padding-top: 8px;">
							<div style="width: 100%; margin-bottom: 10px; padding-top: 10px;">
								<h4 style="width: 25%; float: left; font-size: 14px; font-weight: 400;"> Password:</h4>
								
								<h4 style="width: 25%; float: left; font-size: 14px; font-weight: 800;"><?php echo e($data->show_password); ?></h4>
								
							</div>
						</li>
						
					</ul>
				</td>
				<td style="width:30%;">
					
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p style="padding-top: 10px; width: 100%; font-size: 11px;">Looking forward to your prompt action. 
				</td>
			</tr>
			
			<tr>
						<td>
						<p style="font-size:18px; line-height:20px; color:#000; padding:30px 20px 0 20px;">
						Best regards,<br />
							<?php echo e(config('global.email_regards')); ?>

						</p>
						</td>
					</tr>
		</table>
		
		 
		<br></br>
		<table style="text-align: center; background: rgb(39, 174, 96); border-top: 1px solid #e1e1e1; width: 100%; padding-top: 10px;">
				<tr>
                    <td valign="middle" style="color:#444444; font-size:15px; padding:10px 0 8px 0; font-family:Georgia, 'Times New Roman', Times, serif; text-align:center;">
                       <table class="socl" border="0" cellspacing="5" cellpadding="0" style="margin:0 auto;">
                                                       
                        </table>
                    </td>
                </tr>
			<tr>
				<td style="text-align: center; font-size: 13px; color: #ffffff;">
					<h4 style="padding-bottom: 4px;  font-size: 14px; color: #ffffff;">Thank you for connecting Mastigram!</h4>
					This message was sent to you by <?php echo e(config('global.website_title_camel_case')); ?>.<br />
                        If you didn't create this account, contact <?php echo e(config('global.website_title_camel_case')); ?> support
				</td>
			</tr>
			<tr>
				<td style="text-align: center; font-size: 11px; padding-top: 4px; padding-bottom: 20px; color: #ffffff;">
					
						This email was sent from a notification-only address that cannot accept incoming email. Please do not reply to this message.
					
				</td>
			</tr>
		</table>
	</div>
	
	</body>
	
</html>
<?php /**PATH E:\php8_1\htdocs\mastigram\resources\views/site/emails/user/verification.blade.php ENDPATH**/ ?>