<?php	
	include('includes/application_top.php');

	check_valid_type('CENTRE');

	$action = $_POST['action_type'];
	
	if(isset($action) && tep_not_null($action))
	{
		$student_id = tep_db_prepare_input($_POST['student_id']);
		$centre_id = $_SESSION['sess_centre_id'];
		$ministry_training_status = tep_db_prepare_input($_POST['ministry_training_status']);
		$ministry_training_status = (isset($ministry_training_status) && $ministry_training_status == '1' ? $ministry_training_status : '0');
		$ministry_training_on = tep_db_prepare_input($_POST['ministry_training_on']);
		$ministry_placement_status = tep_db_prepare_input($_POST['ministry_placement_status']);
		$ministry_placement_status = (isset($ministry_placement_status) && $ministry_placement_status == '1' ? $ministry_placement_status : '0');
		$ministry_placement_on = tep_db_prepare_input($_POST['ministry_placement_on']);
		$ministry_training_on = input_valid_date($ministry_training_on);
		$ministry_placement_on = input_valid_date($ministry_placement_on);

		$arr_db_values = array(
			'ministry_training_status' => $ministry_training_status,
			'ministry_training_on' => $ministry_training_on,
			'ministry_placement_status' => $ministry_placement_status,
			'ministry_placement_on' => $ministry_placement_on
		);


		switch($action){
			case 'edit':
				tep_db_perform(TABLE_STUDENTS, $arr_db_values, "update", "student_id = '" . $student_id . "'");
				$msg = 'ministry_edited';
			break;
			case 'delete':
				$arr_db_values = array(
					'ministry_training_status' => '0',
					'ministry_training_on' => '',
					'ministry_placement_status' => '0',
					'ministry_placement_on' => ''
				);

				tep_db_perform(TABLE_STUDENTS, $arr_db_values, "update", "student_id = '" . $student_id . "'");
			break;
		}
		
		tep_redirect(tep_href_link(FILENAME_ENROLL_STUDENTS, tep_get_all_get_params(array('msg','int_id','actionType')) . 'msg=' . $msg));
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title><?php echo TITLE ?>: Ministry Status</title>
		
		<?php include(DIR_WS_MODULES . 'common_head.php'); ?>

		<link href="<?php echo DIR_WS_CSS . 'blitzer/jquery-ui-1.8.23.custom.css' ?>" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="<?php echo DIR_WS_JS . 'jquery-ui-1.8.21.custom.min.js';?>"></script>

		<script language="javascript">
		<!--
			function toggle_element(source_element, target_element, is_reverse){
				var check_value = (is_reverse == '0' ? '1' : '1');
				if($('input[id="'+source_element+'"]:checked').val() == check_value){
					$('.'+target_element).show();
				}else{
					$('.'+target_element).hide();
				}
			}

			$(document).ready(function(){
				$.validator.messages.required = "";
				$("#frmDetails").validate();

				$('#ministry_training_on').datepicker({
					dateFormat: "dd-mm-yy",
					changeMonth: true,
					changeYear: true
				});
				$('#ministry_placement_on').datepicker({
					dateFormat: "dd-mm-yy",
					changeMonth: true,
					changeYear: true
				});
			});

			function delete_record(objForm){
				if(confirm("Are you want to delete ministry status details?")){
					objForm.action_type.value = 'delete';
					objForm.submit();
				}
			}
		//-->
		</script>
	</head>
	<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
		<table cellpadding="0" cellspacing="0" border="0" width="98%" align="center">
			<tr>
				<td><?php include( DIR_WS_MODULES . 'header.php' ); ?></td>
			</tr>
			<tr>
				<td valign="top" colspan="2">
					<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
						<tr>
							<td valign="top" colspan="2"><?php include( DIR_WS_MODULES . 'top_menu.php' ); ?></td>
						</tr>
						<tr>
							<td><img src="<?php echo DIR_WS_IMAGES ?>pixel.gif" height="10"></td>
						</tr>
						<?php
							if(isset($_GET['msg']))
							{
						?>
							<tr>
								<td valign="middle" class="<?php echo ($_GET['msg'] == 'deleted' ? 'error_msg' : 'success_msg' );?>" align="center"><?php echo $arrMessage[$_GET['msg']]?></td>
							</tr>
							<tr>
								<td><img src="<?php echo DIR_WS_IMAGES ?>pixel.gif" height="10"></td>
							</tr>
						<?php
							}	
						?>
						<tr>
							<td class="backgroundBgMain" valign="top">
								<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tr>
										<td valign="top">
											<?php
												if($_GET['actionType'] == "edit")
												{
													$int_id = $_GET['int_id'];

													$info_query_raw = "select student_id, centre_id, ministry_training_status,date_format(ministry_training_on, '%d-%m-%Y') as ministry_training_on, ministry_placement_status, date_format(ministry_placement_on, '%d-%m-%Y') as ministry_placement_on from " . TABLE_STUDENTS . " where student_id='" . $int_id . "' ";

													if($_SESSION['sess_adm_type'] != 'ADMIN'){
														$info_query_raw .= " and centre_id = '" . $_SESSION['sess_centre_id'] . "'";
													}

													$info_query = tep_db_query($info_query_raw);

													$info = tep_db_fetch_array($info_query);

													$action_type = 'edit';
											?>
												<table cellpadding="2" cellspacing="0" border="0" width="100%" align="" class="tab">
													<tr>
														<td class="arial18BlueN">Ministry Status Details</td>
														<td align="right"><img src="images/left.png" align="absmiddle" width="25">&nbsp;&nbsp;<a href="<?php echo tep_href_link(FILENAME_ENROLL_STUDENTS, tep_get_all_get_params(array('msg','actionType','int_id'))); ?>" class="arial14LGrayBold">Student Listing</a></td>
													</tr>
													<tr>
														<td colspan="2">
															<form name="frmDetails" id="frmDetails" action="<?php echo tep_href_link(CURRENT_PAGE, tep_get_all_get_params(array('msg','actionType')) . '&actionType=preview'); ?>" method="post" enctype="multipart/form-data">
																<input type="hidden" name="action_type" id="action_type" value="<?php echo $action_type;?>">
																<input type="hidden" name="student_id" id="student_id" value="<?php echo $info['student_id']; ?>"> 
																<table class="tabForm" cellpadding="3" cellspacing="0" border="0" width="100%">
																	<tr>
																		<td>
																			<table cellpadding="0" cellspacing="0" border="0" width="100%">
																				<tr>
																					<td class="arial14LGrayBold" colspan="2">
																						<fieldset>
																							<legend>Ministry Status</legend>
																							<table cellpadding="5" cellspacing="5" border="0" width="100%">
																								<tr>
																									<td class="arial12LGrayBold">&nbsp;Ministry Training Status&nbsp;<font color="#ff0000">*</font>&nbsp;:</td>
																									<td class="arial12LGrayBold">
																										<?php foreach($arr_status as $k_status=>$v_status){?>
																											<input type="radio" name="ministry_training_status" id="ministry_training_status" value="<?php echo $k_status;?>" <?php echo ($info['ministry_training_status'] == $k_status ? 'checked="checked"' : '');?>  onclick="javascript: toggle_element('ministry_training_status', 'ministry_training_on', '1');">&nbsp;<?php echo $v_status;?>&nbsp;
																										<?php } ?>
																									</td>
																								</tr>
																								<tr class="ministry_training_on">
																									<td class="arial12LGrayBold" valign="top">&nbsp;Ministry Training Date&nbsp;<font color="#ff0000">*</font>&nbsp;:</td>
																									<td class="arial12LGrayBold">
																										<input type="text" name="ministry_training_on" id="ministry_training_on" value="<?php echo  ($dupError ? $_POST['ministry_training_on'] : $info['ministry_training_on']) ?>">
																									</td>
																								</tr>
																								<tr>
																									<td class="arial12LGrayBold">&nbsp;Ministry Placement Status&nbsp;<font color="#ff0000">*</font>&nbsp;:</td>
																									<td class="arial12LGrayBold">
																										<?php foreach($arr_status as $k_status=>$v_status){?>
																											<input type="radio" name="ministry_placement_status" id="ministry_placement_status" value="<?php echo $k_status;?>" <?php echo ($info['ministry_placement_status'] == $k_status ? 'checked="checked"' : '');?>  onclick="javascript: toggle_element('ministry_placement_status', 'ministry_placement_on', '1');">&nbsp;<?php echo $v_status;?>&nbsp;
																										<?php } ?>
																									</td>
																								</tr>
																								<tr class="ministry_placement_on">
																									<td class="arial12LGrayBold" valign="top">&nbsp;Ministry Placement Date&nbsp;<font color="#ff0000">*</font>&nbsp;:</td>
																									<td class="arial12LGrayBold">
																										<input type="text" name="ministry_placement_on" id="ministry_placement_on" value="<?php echo  ($dupError ? $_POST['ministry_placement_on'] : $info['ministry_placement_on']) ?>">
																									</td>
																								</tr>
																								<script type="text/javascript">
																								<!--
																									toggle_element('ministry_training_status', 'ministry_training_on', '1');
																									toggle_element('ministry_placement_status', 'ministry_placement_on', '1');
																								//-->
																								</script>
																								
																							</table>
																						</fieldset>
																					</td>
																				</tr>
																			</table>
																		</td>
																	</tr>
																</table>
																<table cellpadding="5" cellspacing="4" border="0" width="100%" align="center">
																	<tr>
																		<td>&nbsp;<input type="submit" value="UPADTE" name="cmdSubmit" id="cmdSubmit" class="groovybutton">&nbsp;&nbsp;&nbsp;<input type="reset" value="RESET" name="cmdReg" id="cmdReg" class="groovybutton">
																		<?php if($info['student_id'] != ''){ ?>
																		&nbsp;&nbsp;&nbsp;<input type="button" value="DELETE" name="cmdDel" id="cmdDel" class="groovybutton" onclick="javascript: delete_record(document.frmDetails);">
																		<?php } ?>
																		</td>
																		<td >&nbsp;</td>
																	<tr>
																</table>
															</form>
														</td>
													</tr>
												</table>	
											<?php 
												}
											?>
										</td>
									</tr>
									<?php include( DIR_WS_MODULES . 'footer.php' ); ?>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>