<?php
/*
* @package JoomShopping for Joomla!
* @subpackage payment
* @author YandexMoney
* @copyright Copyright (C) 2012-2014 YandexMoney. All rights reserved.
* @license GNU General Public License version 2 or later
*/
defined('_JEXEC') or die('Restricted access');
?>

<script type="text/javascript">
	function yandex_validate_mode(){
		var yandex_mode = jQuery("#ym_mode").val();
		if (yandex_mode == 1){
			jQuery(".individ").show();
			jQuery(".org").hide();
		}else{
			jQuery(".org").show();
			jQuery(".individ").hide();
		}
	}
	window.addEvent('domready', function() {
		yandex_validate_mode();
	});
</script>

<div class="col100">
<fieldset class="adminform">
<table class="admintable" width = "100%" >

 <tr>
   <td style="width:250px;" class="key">
     <b> <?php echo _JSHOP_YM_TESTMODE_DESCRIPTION;?></b>
   </td>
   <td>
     <?php              
     print JHTML::_('select.booleanlist', 'pm_params[testmode]', 'class = "inputbox" size = "1"', $params['testmode']);
     ?>
   </td>
 </tr>

<tr>
   <td class="key">
     <b><?php echo _JSHOP_YM_MODE_DESCRIPTION;?></b>
   </td>
   <td>
     <?php   
	 $state = array();
	 $state[] = JHTML::_('select.option','1', _JSHOP_YM_MODE1_DESCRIPTION,  'value', 'text');
	 $state[] = JHTML::_('select.option','2', _JSHOP_YM_MODE2_DESCRIPTION);
	 echo JHTML::_('select.genericlist', $state, 'pm_params[mode]', 'style="width: 300px;" onchange="yandex_validate_mode()"', 'value', 'text', $params['mode'], 'ym_mode');
     ?>
   </td>
 </tr>
 <?php
  $uri = JURI::getInstance();        
  $liveurlhost = $uri->toString(array("scheme",'host', 'port'));
  
  $notify_url = $liveurlhost.SEFLink("index.php?option=com_jshopping&controller=checkout&task=step7&act=notify&js_paymentclass=pm_yandexmoney&no_lang=1");
  
  $return = $liveurlhost.SEFLink("index.php?option=com_jshopping&controller=checkout&task=step7&act=return&js_paymentclass=pm_yandexmoney");
  
  $cancel_return = $liveurlhost.SEFLink("index.php?option=com_jshopping&controller=checkout&task=step7&act=cancel&js_paymentclass=pm_yandexmoney");
?>
 <tr class="individ">
	<td></td>
	<td>
		<?php echo _JSHOP_YM_REG_IND;?>:<br/><br>
		<table style="border: 1px black solid;">
			  <tr>
				<td style="border: 1px black solid; padding: 5px;"><?php echo _JSHOP_YM_PARAM?></td>
				<td style="border: 1px black solid; padding: 5px;"><?php echo _JSHOP_YM_VALUE?></td>
			  </tr>
			  <tr>
				<td style="border: 1px black solid; padding: 5px;"><?php echo _JSHOP_YM_AVISO1?></td>
				<td style="border: 1px black solid; padding: 5px;"><?php echo $notify_url?></td>
			  </tr>
		</table>
	</td>
 </tr>

<tr class="org">
	<td></td>
	<td>
		<?php echo _JSHOP_YM_REG_ORG;?>:<br/><br/>
		<table style="border: 1px black solid;">
			 <tr>
				<td style="border: 1px black solid; padding: 5px;"><?php echo _JSHOP_YM_PARAM?></td>
				<td style="border: 1px black solid; padding: 5px;"><?php echo _JSHOP_YM_VALUE?></td>
			 </tr>
			<tr>
				<td style="border: 1px black solid; padding: 5px;"><?php echo _JSHOP_YM_AVISO2?></td>
				<td style="border: 1px black solid; padding: 5px;"><?php echo $notify_url?></td>
			</tr>
			<tr>
				<td style="border: 1px black solid; padding: 5px;">checkURL</td>
				<td style="border: 1px black solid; padding: 5px;"><?php echo $notify_url?></td>
			</tr>
			<tr>
				<td style="border: 1px black solid; padding: 5px;">successURL</td>
				<td style="border: 1px black solid; padding: 5px;"><?php echo $return?></td>
			</tr>
			<tr>
				<td style="border: 1px black solid; padding: 5px;">failURL</td>
				<td style="border: 1px black solid; padding: 5px;"><?php echo $cancel_return?></td>
			 </tr>
		</table>
	</td>
</tr>

<tr>
	<td class="key" colspan="2"><br/><br/><b><?php echo _JSHOP_YM_METHODS_DESCRIPTION; ?></b></td>
</tr>

<tr>
	<td><?php echo _JSHOP_YM_METHOD_YM_DESCRIPTION;?></td>
	<td>
		<?php              
		 print JHTML::_('select.booleanlist', 'pm_params[method_ym]', 'class = "inputbox"', $params['method_ym']);
		 ?>
	</td>
</tr>
<tr>
	<td><?php echo _JSHOP_YM_METHOD_CARDS_DESCRIPTION;?></td>
	<td>
		 <?php              
		 print JHTML::_('select.booleanlist', 'pm_params[method_cards]', 'class = "inputbox"', $params['method_cards']);
		 ?>
	</td>
</tr>
<tr class="org">
	<td><?php echo _JSHOP_YM_METHOD_CASH_DESCRIPTION;?></td>
	<td>
		 <?php              
		 print JHTML::_('select.booleanlist', 'pm_params[method_cash]', 'class = "inputbox"', $params['method_cash']);
		 ?>
	</td>
</tr>
<tr class="org">
	<td><?php echo _JSHOP_YM_METHOD_PHONE_DESCRIPTION;?></td>
	<td><?php              
		 print JHTML::_('select.booleanlist', 'pm_params[method_phone]', 'class = "inputbox"', $params['method_phone']);
		 ?>
	</td>
</tr>
<tr class="org">
	<td><?php echo _JSHOP_YM_METHOD_WM_DESCRIPTION;?></td>
	<td>
		 <?php              
		 print JHTML::_('select.booleanlist', 'pm_params[method_wm]', 'class = "inputbox"', $params['method_wm']);
		 ?>
	</td>
</tr>

<tr>
   <td  class="key">
     <b><?php echo _JSHOP_YM_PASSWORD;?></b>
   </td>
   <td>
     <input type = "text" class = "inputbox" name = "pm_params[password]" size="45" value = "<?php echo $params['password']?>" />
   </td>
</tr>

<tr class="org">
   <td  class="key">
     <b><?php echo _JSHOP_YM_SHOPID;?></b>
   </td>
   <td>
     <input type = "text" class = "inputbox" name = "pm_params[shopid]" size="45" value = "<?php echo $params['shopid']?>" />
   </td>
</tr>

<tr class="org">
   <td  class="key">
     <b><?php echo _JSHOP_YM_SCID;?></b>
   </td>
   <td>
     <input type = "text" class = "inputbox" name = "pm_params[scid]" size="45" value = "<?php echo $params['scid]']?>" />
   </td>
</tr>

<tr class="individ">
	<td  class="key">
		 <b><?php echo _JSHOP_YM_ACCOUNT_DESCRIPTION;?></b>
	</td>
	<td>
		<input type = "text" class = "inputbox" name = "pm_params[account]" size="45" value = "<?php echo $params['account']?>" />
	</td>
</tr>

 <tr>
   <td class="key">
     <?php echo _JSHOP_YM_TRANSACTION_END;?>
   </td>
   <td>
     <?php              
     print JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_end_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_end_status'] );
     ?>
   </td>
 </tr>

<?/*
 <tr>
   <td  class="key">
     <?php echo _JSHOP_PAYPAL_EMAIL;?>
   </td>
   <td>
     <input type = "text" class = "inputbox" name = "pm_params[email_received]" size="45" value = "<?php echo $params['email_received']?>" />
     <?php echo JHTML::tooltip(_JSHOP_PAYPAL_EMAIL_DESCRIPTION);?>
   </td>
 </tr>
 <tr>
   <td class="key">
     <?php echo _JSHOP_TRANSACTION_END;?>
   </td>
   <td>
     <?php              
     print JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_end_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_end_status'] );
     echo " ".JHTML::tooltip(_JSHOP_PAYPAL_TRANSACTION_END_DESCRIPTION);
     ?>
   </td>
 </tr>
 <tr>
   <td class="key">
     <?php echo _JSHOP_TRANSACTION_PENDING;?>
   </td>
   <td>
     <?php 
     echo JHTML::_('select.genericlist',$orders->getAllOrderStatus(), 'pm_params[transaction_pending_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_pending_status']);
     echo " ".JHTML::tooltip(_JSHOP_PAYPAL_TRANSACTION_PENDING_DESCRIPTION);
     ?>
   </td>
 </tr>
 <tr>
   <td class="key">
     <?php echo _JSHOP_TRANSACTION_FAILED;?>
   </td>
   <td>
     <?php 
     echo JHTML::_('select.genericlist',$orders->getAllOrderStatus(), 'pm_params[transaction_failed_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_failed_status']);
     echo " ".JHTML::tooltip(_JSHOP_PAYPAL_TRANSACTION_FAILED_DESCRIPTION);
     ?>
   </td>
 </tr>
 <tr>
   <td class="key">
     <?php echo _JSHOP_CHECK_DATA_RETURN;?>
   </td>
   <td>
     <?php              
     print JHTML::_('select.booleanlist', 'pm_params[checkdatareturn]', 'class = "inputbox"', $params['checkdatareturn']);     
     ?>
   </td>
 </tr>
 <tr>
   <td class="key">
     <?php echo _JSHOP_USE_SSL;?>
   </td>
   <td>
     <?php              
     print JHTML::_('select.booleanlist', 'pm_params[use_ssl]', 'class = "inputbox"', $params['use_ssl']);     
     ?>
   </td>
 </tr>
 <tr>
   <td class="key">
     <?php echo _JSHOP_OVERRIDING_ADDRESSES?>
   </td>
   <td>
     <?php              
     print JHTML::_('select.booleanlist', 'pm_params[address_override]', 'class = "inputbox"', $params['address_override']);
     ?>
   </td>
 </tr> 
 */?>
</table>
</fieldset>
</div>
<div class="clr"></div>


