<?php
include('includes/application_top.php');

check_valid_type('CENTRE');

$action = $_POST['action_type'];

if (isset($action) && tep_not_null($action)) {
    $student_id = tep_db_prepare_input($_POST['student_id']);
    $centre_id = $_SESSION['sess_centre_id'];

    $moma_stage1_uploaded = tep_db_prepare_input($_POST['moma_stage1_uploaded']);
    $moma_sdms_number = tep_db_prepare_input($_POST['moma_sdms_number']);
    $moma_stage2_uploaded = tep_db_prepare_input($_POST['moma_stage2_uploaded']);

    $moma_stage1_uploaded = ($moma_stage1_uploaded == '1' ? '1' : '0');
    $moma_stage2_uploaded = ($moma_stage2_uploaded == '1' ? '1' : '0');

    $arr_db_values = array(
        'moma_stage1_uploaded' => $moma_stage1_uploaded,
        'moma_sdms_number' => $moma_sdms_number,
        'moma_stage2_uploaded' => $moma_stage2_uploaded
    );

    switch ($action) {
        case 'edit':
            tep_db_perform(TABLE_STUDENTS, $arr_db_values, "update", "student_id = '" . $student_id . "' and centre_id = '" . $centre_id . "'");

            change_student_status($student_id, '1');

            $msg = 'moma_stage1_uploaded_edited';
            break;
        case 'delete':
            $arr_db_values = array(
                'moma_stage1_uploaded' => '0',
                'moma_sdms_number' => '',
                'moma_stage2_uploaded' => '0'
            );

            tep_db_perform(TABLE_STUDENTS, $arr_db_values, "update", "student_id = '" . $student_id . "' and centre_id = '" . $centre_id . "'");
            break;
    }

    tep_redirect(tep_href_link(FILENAME_ENROLL_STUDENTS, tep_get_all_get_params(array('msg', 'int_id', 'actionType')) . 'msg=' . $msg));
}

if ($_GET['actionType'] == "edit") {
    $int_id = $_GET['int_id'];

    $info_query_raw = "select student_id, centre_id, course_id, moma_stage1_uploaded, moma_sdms_number, moma_stage2_uploaded, student_status from " . TABLE_STUDENTS . " where student_id='" . $int_id . "' and is_deactivated != '1' ";

    if ($_SESSION['sess_adm_type'] != 'ADMIN') {
        $info_query_raw .= " and centre_id = '" . $_SESSION['sess_centre_id'] . "'";
    }

    $info_query = tep_db_query($info_query_raw);

    $info = tep_db_fetch_array($info_query);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
    <head>
        <title><?php echo TITLE ?>: MOMA Upload Status</title>

        <?php include(DIR_WS_MODULES . 'common_head.php'); ?>

        <link href="<?php echo DIR_WS_CSS . 'blitzer/jquery-ui-1.8.23.custom.css' ?>" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="<?php echo DIR_WS_JS . 'jquery-ui-1.8.21.custom.min.js'; ?>"></script>

        <script language="javascript">
            <!--
			$(document).ready(function () {
                $.validator.messages.required = "";
                $("#frmDetails").validate();

            <?php if ($info['student_status'] == '1') { ?>
                    $('#frmDetails input, #frmDetails select, #frmDetails textarea, #frmDetails button').attr('disabled', true);
            <?php } ?>
            });

            function toggle_element(source_element, target_element) {
                if ($('#' + source_element + ':checked').val() == '1') {
                    $('.' + target_element).show();
                } else {
                    $('.' + target_element).hide();
                }
            }


            function delete_record(objForm) {
                if (confirm("Are you want to delete moma upload status details?")) {
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
                                if (isset($_GET['msg'])) {
                                    ?>
                                    <tr>
                                        <td valign="middle" class="<?php echo ($_GET['msg'] == 'deleted' ? 'error_msg' : 'success_msg' ); ?>" align="center"><?php echo $arrMessage[$_GET['msg']] ?></td>
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
                                                    if ($_GET['actionType'] == "edit") {
                                                        $action_type = 'edit';
                                                        ?>
                                                        <table cellpadding="2" cellspacing="0" border="0" width="100%" align="" class="tab">
                                                            <tr>
                                                                <td class="arial18BlueN">MOMA Upload Status</td>
                                                                <td align="right"><img src="images/left.png" align="absmiddle" width="25">&nbsp;&nbsp;<a href="<?php echo tep_href_link(FILENAME_ENROLL_STUDENTS, tep_get_all_get_params(array('msg', 'actionType', 'int_id'))); ?>" class="arial14LGrayBold">Student Listing</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <form name="frmDetails" id="frmDetails" action="<?php echo tep_href_link(CURRENT_PAGE, tep_get_all_get_params(array('msg', 'actionType')) . '&actionType=preview'); ?>" method="post" enctype="multipart/form-data">
                                                                        <input type="hidden" name="action_type" id="action_type" value="<?php echo $action_type; ?>">
                                                                        <input type="hidden" name="student_id" id="student_id" value="<?php echo $info['student_id']; ?>"> 
                                                                        <input type="hidden" name="document_id" id="document_id" value=""> 
                                                                        <table class="tabForm" cellpadding="3" cellspacing="0" border="0" width="100%">
                                                                            <tr>
                                                                                <td>
                                                                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                                        <tr>
                                                                                            <td class="arial14LGrayBold" colspan="2">
                                                                                                <fieldset>
                                                                                                    <legend>MOMA Upload Info</legend>
                                                                                                    <table cellpadding="5" cellspacing="5" border="0" width="100%">
                                                                                                        <tr>
                                                                                                            <td class="arial12LGrayBold" align="right">&nbsp;STAGE 1 UPLOADED<font color="#ff0000">*</font>&nbsp;:</td>
                                                                                                            <td class="arial12LGrayBold" colspan="5">
                                                                                                                <?php foreach ($arr_status as $k_status => $v_status) { ?>
                                                                                                                    <input type="radio" name="moma_stage1_uploaded" id="moma_stage1_uploaded" value="<?php echo $k_status; ?>" class="required" <?php echo ($info['moma_stage1_uploaded'] == $k_status ? 'checked="checked"' : ''); ?>  style="width:auto;" onclick="javascript: toggle_element('moma_stage1_uploaded', 'moma_sdms_number');">&nbsp;<?php echo $v_status; ?>&nbsp;
                                                                                                                <?php } ?>&nbsp;

                                                                                                                <span class="arial12LGrayBold moma_sdms_number" align="right">
                                                                                                                    &nbsp;SDMS number&nbsp;<font color="#ff0000">*</font>&nbsp;:
                                                                                                                    &nbsp;<input type="text" name="moma_sdms_number" id="moma_sdms_number" maxlength="50" value="<?php echo ($dupError ? $_POST['moma_sdms_number'] : $info['moma_sdms_number']) ?>" class="required moma_sdms_number">
                                                                                                                </span>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td class="arial12LGrayBold" align="right">&nbsp;STAGE 2 UPLOADED<font color="#ff0000">*</font>&nbsp;:</td>
                                                                                                            <td class="arial12LGrayBold" colspan="5">
                                                                                                                <?php foreach ($arr_status as $k_status => $v_status) { ?>
                                                                                                                    <input type="radio" name="moma_stage2_uploaded" id="moma_stage2_uploaded" value="<?php echo $k_status; ?>" class="required" <?php echo ($info['moma_stage2_uploaded'] == $k_status ? 'checked="checked"' : ''); ?>  style="width:auto;" onclick="javascript: toggle_element('moma_stage2_uploaded', '');">&nbsp;<?php echo $v_status; ?>&nbsp;
                                                                                                                <?php } ?>&nbsp;
                                                                                                            </td>
                                                                                                        </tr>


                                                                                                        <script type="text/javascript">
                                                                                                            <!--
                                                                                                                toggle_element('moma_stage1_uploaded', 'moma_sdms_number');
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
                                                                        <?php if ($info['student_status'] == '0') { ?>
                                                                            <table cellpadding="5" cellspacing="4" border="0" width="100%" align="center">
                                                                                <tr>
                                                                                    <td>&nbsp;<input type="submit" value="UPADTE" name="cmdSubmit" id="cmdSubmit" class="groovybutton">&nbsp;&nbsp;&nbsp;<input type="reset" value="RESET" name="cmdReg" id="cmdReg" class="groovybutton">
                                                                                        <?php if ($info['student_id'] != '') { ?>
                                                                                            &nbsp;&nbsp;&nbsp;<input type="button" value="DELETE" name="cmdDel" id="cmdDel" class="groovybutton" onclick="javascript: delete_record(document.frmDetails);">
                                                                                        <?php } ?>
                                                                                    </td>
                                                                                    <td >&nbsp;</td>
                                                                                <tr>
                                                                            </table>
                                                                        <?php } ?>
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