<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!--Font Link-->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap" rel="stylesheet">
		<title>
			Mastigram+
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
				width:60%;
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
		   
		    
@media only screen and (max-width: 760px),
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
	
		<table style="background: #ffffff; width:80%; padding:30px 0 30px 0">
			<tr>
				<td style="text-align: left; color:#F65C00; padding: 30px 0;">
					<img  src="{{asset('images/site/zoetic_logo.png')}}" width="200px">
				</td>
				<td style="text-align: right; font-size: 14px; color: #000000; padding: 30px 0;">
					
					<strong style="color: #000000"><a href="https://mastigramapp.com/" style="color: #000000;">View in Browser</a></strong> 
				</td>
			</tr>
		</table>
		
		<table style="background: #000000; width:100%; margin: auto;">
				
				
				<tr><td style="color:#ffffff; text-align: padding-top:60px;font-size: 22px; ">Dear {{$data->name}}, Welcome to Mastigram+. Your login credential:</td></tr>
				
				<tr><td style="color:#ffffff; text-align: padding-top:60px;font-size: 22px; ">
				
				<p style="color:#ffffff;">Email: {{$data->email}}</p>
				<p style="color:#ffffff;">Password: {{$data->show_password}}</p>
				</td></tr>
				
				<tr><td ><h2 style="color:#F65C00;text-align:center;font-size:28px;">MASTIGRAM+</h2></td></tr>
				<tr><td style="color:#ffffff; text-align:center;font-size: 22px; "></td></tr>
				
				<tr>
				<td style="color:#ffffff; text-align:center;padding-bottom:40px">
				
				<img  src="{{asset('images/site/email.png')}}" width="200px">
				
				</td></tr>
			
			
			
			
			
		</table>
		<table style="background: #ffffff; width:80%; ">
			<tr>
				<td style="text-align: left; padding: 30px 0;">
				<p style="color:#7F7F7F;font-size: 12px;text-align: justify;">IMPORTANT SAFETY INFORMATION: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut iaculis dui, id sollicitudin dolor. Nullam nec luctus nisl. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Etiam eget arcu sit amet lorem condimentum fermentum id ac felis References: 1. Quisque id diam vel quam elementum pulvinar etiam non quam. ultrices mi tempus imperdiet nulla malesuada. Diam quam nulla porttito 2. At consectetur lorem donec massa sapien faucibus. Ipsum a arcu cursus vitae congue mauris
				</p>
				<br>
				<p style="color:#7F7F7F;font-size: 12px;text-align: justify;">
					Zoetis 2023 - All rights reserved. MM-XXXXX. To view ou	r privacy policy, click here. You can contact us at xxxx@zoetis.com or at [insert address here]. Click here to unsubscribe.
					</p>
				</td>
				
			</tr>
		</table>
	</div>
	
	</body>
	
</html>

