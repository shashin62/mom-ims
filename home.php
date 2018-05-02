<?php
	include('includes/application_top.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title><?php echo TITLE ?>: Home</title>
		<?php include(DIR_WS_MODULES . 'common_head.php'); ?>
	</head>
	<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
		<table cellpadding="0" cellspacing="0" border="0" width="98%" align="center">
			<?php
				include( DIR_WS_MODULES . 'header.php' );
			?>
			<tr>
				<td valign="top" colspan="2">
					<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
						<tr>
							<td valign="top" colspan="2">
								<?php
									include( DIR_WS_MODULES . 'top_menu.php' );
								?>
							</td>
						</tr>
						<tr>
							<td><img src="images/pixel.gif" height="5"></td>
						</tr>
						<tr>
							<td valign="top">
								<table class="backgroundBgMain" cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tr>
										<td colspan="3"><img src="images/pixel.gif" height="10"></td>
									</tr>
								</table>
								<table class="backgroundBgMain" cellpadding="5" cellspacing="2" border="0" width="100%" align="center">
									<tr>
										<td valign="top">
											<table cellpadding="5" cellspacing="2" border="0" width="100%" align="center">
												<tr>
													<td class="backgroundBgMain">
														<table cellpadding="0" cellspacing="5" border="0" width="100%" align="">
															<?php
																if( $_SESSION['sess_adm_type'] == 'ADMIN'){
															?>
															<tr>
																<td align="center" class="brdr" height="110" width="100">
																	<a href="<?php echo tep_href_link(FILENAME_USERS); ?>" class="link2">
																		<img src="<?php echo DIR_WS_IMAGES?>prospect.png" alt="User" border="0" title="User" width="80">
																		<br><span class="verdana12BlackB">User</span>
																	</a>
																</td>
																<td align="center" class="brdr" height="110" width="100">
																	<a href="<?php echo tep_href_link(FILENAME_CITIES); ?>" class="link2">
																		<img src="<?php echo DIR_WS_IMAGES?>cities.png" alt="City" border="0" title="City" width="80">
																		<br><span class="verdana12BlackB">City</span>
																	</a>
																</td>
																<td align="center" class="brdr" height="110" width="100">
																	<a href="<?php echo tep_href_link(FILENAME_CENTERS); ?>" class="link2">
																		<img src="<?php echo DIR_WS_IMAGES?>centre.png" alt="Centre" border="0" title="Centre" width="80">
																		<br><span class="verdana12BlackB">Centre</span>
																	</a>
																</td>
																<td align="center" height="110" width="100">
																	<a href="<?php echo tep_href_link(FILENAME_COURSES); ?>" class="link2">
																		<img src="<?php echo DIR_WS_IMAGES?>courses.png" alt="Course" border="0" title="Course" width="80">
																		<br><span class="verdana12BlackB">Course</span>
																	</a>
																</td>
															</tr>
															<?php }else{ ?>
															<tr>
																<td align="center" class="brdr" height="110" width="100">
																	<a href="<?php echo tep_href_link(FILENAME_PROS_STUDENTS); ?>" class="link2">
																		<img src="<?php echo DIR_WS_IMAGES?>cities.png" alt="Student Prospect" border="0" title="Student Prospect" width="80">
																		<br><span class="verdana12BlackB">Prospect</span>
																	</a>
																</td>
																<td align="center" class="brdr" height="110" width="100">
																	<a href="<?php echo tep_href_link(FILENAME_ENROLL_STUDENTS); ?>" class="link2">
																		<img src="<?php echo DIR_WS_IMAGES?>student.png" alt="Enroll Student" border="0" title="Enroll Student" width="80">
																		<br><span class="verdana12BlackB">Student</span>
																	</a>
																</td>
																<td align="center" class="brdr" height="110" width="100">
																	<a href="<?php echo tep_href_link(FILENAME_COMPANIES); ?>" class="link2">
																		<img src="<?php echo DIR_WS_IMAGES?>company.png" alt="Companies" border="0" title="Companies" width="80">
																		<br><span class="verdana12BlackB">Companies</span>
																	</a>
																</td>
																<td align="center" class="brdr" height="110" width="100">
																	<a href="<?php echo tep_href_link(FILENAME_FACULTIES); ?>" class="link2">
																		<img src="<?php echo DIR_WS_IMAGES?>teacher.png" alt="Faculty" border="0" title="Faculty" width="80">
																		<br><span class="verdana12BlackB">Faculty</span>
																	</a>
																</td>
																<td align="center" class="brdr" height="110" width="100">
																	<a href="<?php echo tep_href_link(FILENAME_BATCHES); ?>" class="link2">
																		<img src="<?php echo DIR_WS_IMAGES?>people.png" alt="Batch" border="0" title="Batch" width="80">
																		<br><span class="verdana12BlackB">Batch</span>
																	</a>
																</td>
																<td align="center" class="brdr" height="110" width="100">
																	<a href="<?php echo tep_href_link(FILENAME_LECTURES); ?>" class="link2">
																		<img src="<?php echo DIR_WS_IMAGES?>lessons.png" alt="Lecture" border="0" title="Lecture" width="80">
																		<br><span class="verdana12BlackB">Lecture</span>
																	</a>
																</td>
																<td align="center" height="110" width="100">
																	<a href="<?php echo tep_href_link(FILENAME_STUDENT_ATTENDANCE); ?>" class="link2">
																		<img src="<?php echo DIR_WS_IMAGES?>attendace.png" alt="Attendance" border="0" title="Attendance" width="80">
																		<br><span class="verdana12BlackB">Attendance</span>
																	</a>
																</td>
															</tr>
															<?php } ?>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
								<!-- Main contant starts here-->
							</td>
						</tr>
						<?php include( DIR_WS_MODULES . 'footer.php' ); ?>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
