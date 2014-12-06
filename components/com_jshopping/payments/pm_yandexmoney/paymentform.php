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

<b><?php echo _JSHOP_YM_MODE_DESCRIPTION; ?></b>
<table class="radio" style="margin-left: 50px;">
	   <tbody>
	   <?php if ($pmconfigs['method_ym']){?>
			<tr class="highlight">
				<td><input type="radio" name="params[pm_yandexmoney][ym-payment-type]" value="PC" checked id="ym1"></td>
				<td><label for="ym1"><?php echo _JSHOP_YM_METHOD_YM_DESCRIPTION;?></label></td>
			</tr>
		<?php } ?>
		<?php if ($pmconfigs['method_cards']){?>
		   <tr class="highlight">
				<td><input type="radio" name="params[pm_yandexmoney][ym-payment-type]" value="AC" id="ym2"></td><td><label for="ym2"><?php echo _JSHOP_YM_METHOD_CARDS_DESCRIPTION;?></label></td>
			</tr>
		<?php } ?>
		<?php if ($pmconfigs['method_cash'] && $pmconfigs['mode'] == 2){?>
			 <tr class="highlight">
				<td><input type="radio" name="params[pm_yandexmoney][ym-payment-type]" value="GP" id="ym3"></td><td><label for="ym3"><?php echo _JSHOP_YM_METHOD_CASH_DESCRIPTION;?></label></td>
			</tr>
		<?}?>
		<? if ($pmconfigs['method_phone']  && $pmconfigs['mode'] == 2){?>
		   <tr class="highlight">
				<td><input type="radio" name="params[pm_yandexmoney][ym-payment-type]" value="MC" id="ym4"></td><td><label for="ym4"><?php echo _JSHOP_YM_METHOD_PHONE_DESCRIPTION;?></label></td>
			</tr>
		<?php } ?>
		<? if ($pmconfigs['method_wm']  && $pmconfigs['mode'] == 2){?>
		   <tr class="highlight">
				<td><input type="radio" name="params[pm_yandexmoney][ym-payment-type]" value="WM" id="ym5"></td><td><label for="ym5"><?php echo _JSHOP_YM_METHOD_WM_DESCRIPTION;?></label></td>
			</tr>
		 <?php } ?>
		<? if ($pmconfigs['method_ab']  && $pmconfigs['mode'] == 2){?>
		   <tr class="highlight">
				<td><input type="radio" name="params[pm_yandexmoney][ym-payment-type]" value="AB" id="ym6"></td><td><label for="ym6"><?php echo _JSHOP_YM_METHOD_AB_DESCRIPTION;?></label></td>
			</tr>
		 <?php } ?>	 
		<? if ($pmconfigs['method_sb']  && $pmconfigs['mode'] == 2){?>
		   <tr class="highlight">
				<td><input type="radio" name="params[pm_yandexmoney][ym-payment-type]" value="AB" id="ym7"></td><td><label for="ym6"><?php echo _JSHOP_YM_METHOD_SB_DESCRIPTION;?></label></td>
			</tr>
		 <?php } ?>	 		 
		 </tbody>
 </table>

<script type="text/javascript">
function check_pm_yandexmoney(){
    jQuery('#payment_form').submit();
}
</script>