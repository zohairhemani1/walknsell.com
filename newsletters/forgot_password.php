<?php

$subject = "WalkNSell: Password Recovery";
$headers = "From: " . "info@walknsell.com" . "\r\n";
$headers .= "Reply-To: ". "info@walknsell.com" . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


$message = '<table cellspacing="0" cellpadding="0" style="padding:30px 10px;background:#eee;width:100%;font-family:arial;">
		
		<tbody>
			<tr>
				<td>
					<table align="center" cellspacing="0" style="max-width:650px;min-width:320px;">
						<tbody>
							<tr>
								<td style="text-align:left;padding-bottom:14px;">
									<img align="left" alt="WalknSell" src="http://walknsell.com/img/walk_sell_logo_f.png">
								</td>
							</tr>
							<tr>
								<td align="center" style="background:#fff;border:1px solid #e4e4e4;padding:50px 30px;">

											<table align="center">
			<tbody>
				<tr>
					<td style="color:#666;text-align:center;">
					
						<table align="center" style="">
    <tbody>

        <tr>
            <td style="color:#666;font-size:20px;font-weight:bold;text-align:center;font-family:arial;">

                Forgot password
            </td>
        </tr>
    </tbody>
</table>
		
						
					</td>
				</tr>
				<tr>
					<td style="color:#666;padding:15px;font-size:14px;line-height:18px;text-align:left;">
					
						<div style="">
							<p>Hi, We&#39;ve received a request to reset your WalknSell password.</p><p>To initiate the process, please click the following link:<br><a href='.$link.' style="color:#00b22c;text-decoration:none;" target="_blank">http://www.walknsell.com/forget_password.php</a></p><p>Your new password, after you visit the link: <b>'.$newPass.'</b></p><p>If clicking the link above does not work, copy and paste the URL in a new browser window. If you did not make this request, simply ignore this message.</p>
						</div>

						


		<div style="padding-top:10px;text-align:center;font-family:arial;">
            <p>Thanks</p>
			<br>
			The WalknSell Team
		</div>

					</td>
				</tr>
			</tbody>
		</table>


								</td>
							</tr>


							
  <!--                          <tr>
                                <td align="center" style="background:#f8f8f8;border:1px solid #e4e4e4;border-top:none;padding:24px 10px;">

                                    <table align="center" style="width:100%;max-width:650px;">
                                        <tbody>
                                            <tr>
                                                <td style="font-size:20px; color:#000; line-height:27px;text-align:center;max-width:650px;padding-bottom:20px;">
                                                    <a href="https://www.fiverr.com/ios_app?from_email=true" style="text-decoration:none;color:black;" target="_blank">
                                                        All the Deals you need also in your pocket
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

						</tbody>
					</table>
				</td>
			</tr>
			-- !>
			<tr>
				<td>
					<table align="center" style="max-width:650px;">
						
						<tbody><tr>
							<td style="color:#b4b4b4;font-size:11px;padding-top:10px;line-height:15px;font-family:arial;">

								© Avialdo 2014-2016, WalkNSell®, Deal®, DealS®
							</td>

						</tr>
					</tbody></table>
				</td>
			</tr>
		</tbody>
	</table>';
?>