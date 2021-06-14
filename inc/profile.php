

		<?php
		if (isset($_GET['id'])) {
		  $userstafid2 = getStafIDByUserID(htmlspecialchars($_GET['id'], ENT_QUOTES));
		} else {
		  $userstafid2 = $row_user['user_stafid'];
		}
		?>
        <div class="profileview">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="150" rowspan="3" align="center" valign="top"><?php echo viewProfilePic($userstafid2);?></td>
              <td width="90%" class="name in_cappitalize line_b4"><?php echo strtoupper(getFullNameByStafID($userstafid2)); ?></td>
            </tr>
            <tr>
              <td class="line_b4">Staf ID : <span class="in_upper"><strong><?php echo $userstafid2;?></strong></span> &nbsp; <span class="txt_color1">&bull;</span> &nbsp; No. KP / Passport : <strong><?php echo getICNoByStafID($userstafid2);?></strong></td>
            </tr>
            <tr>
              <td><?php echo getAgeByUserID($userstafid2);?> Tahun &nbsp; <span class="txt_color1">&bull;</span> &nbsp; <span class="in_cappitalize"><?php echo getGender(getGenderIDByUserID($userstafid2));?></span> &nbsp; <span class="txt_color1">&bull;</span> &nbsp; <span class="in_cappitalize"><?php echo getRace(getRaceByUserID($userstafid2));?> (<?php echo getReligion(getReligionByUserID($userstafid2));?>)</span></td>
            </tr>
          </table>
        </div>