<?php

$subject = "WalkNSell: Sold Deal Report";
$headers = "From: " . "info@walknsell.com" . "\r\n";
$headers .= "Reply-To: ". "info@walknsell.com" . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message = "<table cellspacing='0' cellpadding='0' style='padding:30px 10px;background:#eee;width:100%;font-family:arial'>
			  <tbody>
				<tr>
				  <td><table align='center' cellspacing='0' style='max-width:650px;min-width:320px'>
					  <tbody>
						<tr>
						  <td style='text-align:left;padding-bottom:14px'><img align='left' alt='WalkNSell' src='http://walknsell.com/img/walk_sell_logo_f.png'></td>
						</tr>
						<tr>
						  <td align='center' style='background:#fff;border:1px solid #e4e4e4;padding:50px 30px'><div>
							  <div>
								<div> </div>
							  </div>
							</div>
							<table align='center'>
							  <tbody>
								<tr>
								  <td style='border-bottom:1px solid #dfdfd0;color:#666;text-align:center;padding-bottom:30px'><table align='center' style='margin:auto'>
									  <tbody>
										<tr>
										  <td style='color:#666;font-size:20px;font-weight:bold;text-align:center;font-family:arial'> Hi {$username}, Welcome to WalkNSell! </td>
										</tr>
									  </tbody>
									</table>
									<table align='center' style='margin:auto'>
									  <tbody>
										<tr>
										  <td style='color:#666;font-size:16px;padding-bottom:30px;text-align:center;font-family:arial'> Are you ready to get started? </td>
										</tr>
									  </tbody>
									</table>
									<table align='center' style='margin:auto'>
									  <tbody>
										<tr>
										  <td style='background-color:#00b22d;border:1px solid #028a25;border-radius:3px;text-align:center'><a href='http://www.walknsell.com/cate_desc.php?korkID={$korkID}' style='padding:16px 20px;display:block;text-decoration:none;color:#fff;font-size:16px;text-align:center;font-family:arial;font-weight:bold' target='_blank'>Check The Deal</a></td>
										</tr>
									  </tbody>
									</table></td>
								</tr>
								<tr>
								  <td style='color:#aaa;padding:15px;font-size:11px;line-height:15px;text-align:left'><div style='color:#aaa;padding-bottom:15px;font-family:arial'> If clicking the link above does not work, copy and paste the following URL in a new browser window: <a href='http://www.walknsell.com/cate_desc.php?korkID={$korkID}' style='color:#00b22c' target='_blank'>http://www.walknsell.com/cate_desc.php?id={$korkID}</a> </div>
									<div style='color:#aaa;font-family:arial'> It is also a good idea to add <a style='color:#aaa'>info@walknsell.com</a> to your address book to ensure that you receive our messages (no spam, we promise!). </div></td>
								</tr>
							  </tbody>
							</table></td>
						</tr>
						<tr>
						  <td align='center' style='background:#f8f8f8;border:1px solid #e4e4e4;border-top:none;padding:24px 10px'><table align='center' style='width:100%;max-width:650px'>
							  <tbody>
				              <!--<tr>
								  <td style='text-align:center'><a href='' style='text-decoration:none;margin-bottom:10px;display:inline-block' target='_blank'> <img width='208' height='40' border='0' src='https://ci4.googleusercontent.com/proxy/M_xRJOsxVu5vjZUDPUoNXxNeTRuJ_Uxl6VtV08YA445t4a-tL5o9O988ei5aF4H3LSuaxHBBMDPGX38sXKDS8iFTRcEL-8bv6-Lhr6r9TwF2pVPVl4cGEXPSHKc_rRuJZgDQSou84g4i7KCAxy3PCsUirec=s0-d-e1-ft#https://d7l5bbi2x5xo4.cloudfront.net/cloud_files/974/original/email-footer-app-store-space.gif'> </a> <a href='' style='text-decoration:none;display:inline-block' target='_blank'> <img width='208' height='40' border='0' src='https://ci5.googleusercontent.com/proxy/iHE7QUvx2J2u1njfDH8CCQJrx7-pX2SzKOkUqEeTf6wQ80DUjPnm8jQlxB7be9hRgqT0SJ-F6Gzo5iShZzjDtVHXMVArxbJcZaBbkLZAxQ-j7En1gNki1BQnrM91_5LaOvMgFACWEhZ1pOe6LF898JdsuGkz=s0-d-e1-ft#https://d7l5bbi2x5xo4.cloudfront.net/cloud_files/975/original/email-footer-play-store-space.gif'> </a></td>
								</tr>-->
								
							  </tbody>
							</table></td>
						</tr>
					  </tbody>
					</table></td>
				</tr>
				<tr>
				  <td><table align='center' style='max-width:650px'>
					  <tbody>
						<tr>
						  <td style='color:#b4b4b4;font-size:11px;padding-top:10px;line-height:15px;font-family:arial'> © Avialdo 2014-2016, WalkNSell®, Deal®, DealS®, WalkNSell graphics, logos, scripts, terms of use, instructions, designs and others service names are the trademarks and copyright of Avialdo.</td>
						</tr>
					  </tbody>
					</table></td>
				</tr>
			  </tbody>
			</table>";

/* Fiverr® is located at 460 Park Avenue, New York, NY10016. <br>
							Apple, the Apple logo and iPhone are trademarks of Apple Inc., registered in the U.S. and other countries. App Store is a service mark of Apple Inc.*/
echo $message;
?>