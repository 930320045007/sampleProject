<script src="<?php echo $url_main;?>SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<link href="<?php echo $url_main;?>SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
		<div class="header">
			<div class="logo">
            	<img src="<?php echo $url_main;?>img/msn1.png" heigh="70" width="90" alt="Logo MSN" />
            </div>
			<div class="header1">
            	<div class="title w100">
                	Sistem Pengurusan Sumber Manusia (SPSM)
                </div>
                <div class="fl w100">
                	Cawangan Sumber Manusia, Majlis Sukan Negara Malaysia.
                </div>
            </div>
			<?php if(isset($_SESSION['user_stafid']) && isset($menu) && $menu != '0'){?>
            <div class="header2">
                <div class="fr">
					<div><?php echo viewProfilePicIcon($_SESSION['user_stafid']);?></div>
                </div>
            	<div class="fr padr">
                    <div class="name in_capitalize">
                        <?php echo ucwords(strtolower(getShortNameByStafID($_SESSION['user_stafid'])));?> ( <?php echo $_SESSION['user_stafid'];?> )
                    </div>
                    <div><span class="cursorpoint" onclick="toggleview2('formPassword'); return false;">Tukar Kata Laluan</span> &nbsp; | &nbsp; <a href="<?php echo $logoutAction ?>">Log Out</a>
                    </div>
                </div>
            </div>
			<?php }; ?>
        </div>
        <?php if(isset($_SESSION['user_stafid']) && isset($menu) && $menu != '0'){ // Penukaran Kata Laluan?>
        <div id="formPassword" class="passbox_back <?php if(getComparePassByUserID($_SESSION['user_stafid'])) echo "hidden"; else echo "hidden2"; ?>">
        <div class="passbox_form">
        	  <form id="formpass" class="back_white" name="formpass" method="post" action="<?php echo $url_main;?>sb/update_pass.php">
        	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
        	      <tr>
        	        <td colspan="2" class="title">Tukar Kata Laluan</td>
      	        </tr>
                <?php if(!getComparePassByUserID($_SESSION['user_stafid'])){?>
        	      <tr>
        	        <td colspan="2" class="back_white"><span class="note">Sila lakukan penukaran Kata Laluan terlebih dahulu.</span></td>
      	        </tr>
                <?php }; ?>
        	      <tr>
        	        <td nowrap="nowrap" class="back_white label">Kata Laluan Lama</td>
        	        <td width="100%" class="back_white">
        	          <input type="password" name="kl_old" id="kl_old" />
                    </td>
      	        </tr>
        	      <tr>
        	        <td nowrap="nowrap" class="back_white label">Kata Laluan Baru</td>
        	        <td nowrap="nowrap" class="back_white">
      				<span id="sprypassword1">
                    <span class="passwordRequiredMsg">Maklumat diperlukan.</span>
                    <input type="password" name="kl_new" id="kl_new" />
                      <div class="inputlabel2">Hanya huruf dan nombor sahaja, tiada penggunaan simbol atau ruang kosong.</div>
       	            </span>
                    </td>
      	        </tr>
        	      <tr>
        	        <td nowrap="nowrap" class="back_white label">Ulangi Kata Laluan Baru</td>
        	        <td class="back_white"><input type="password" name="kl_new2" id="kl_new2" /></td>
      	        </tr>
        	      <tr>
        	        <td class="back_white">
                    <input name="date" type="hidden" id="date" value="<?php echo date('d/m/Y');?>" />
       	            <input name="MM_update_pass" type="hidden" id="MM_update_pass" value="formpass" />
       	            <input name="url" type="hidden" id="url" value="<?php echo $_SERVER["PHP_SELF"]; ?>" /></td>
        	        <td nowrap="nowrap">
                    <input type="submit" name="button" id="button" value="Tukar" class="submitbutton" />
                    <?php if(getComparePassByUserID($_SESSION['user_stafid'])){?>
       	            <input type="button" name="button2" id="button2" value="Batal" class="cancelbutton" onclick="toggleview2('formPassword'); return false;" />
                    <?php }; ?>
                    </td>
      	        </tr>
        	      <tr>
        	        <td colspan="2" class="back_white"><?php echo notePass('1');?></td>
      	        </tr>
      	      </table>
      	      </form>
        </div>
        </div>
        <?php }; ?>        
        
        <script type="text/javascript">
		var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {maxSpecialChars:0, minSpecialChars:0, validateOn:["change"]});
        </script>
