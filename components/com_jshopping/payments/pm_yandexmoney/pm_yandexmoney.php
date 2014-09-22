<?php
/*
* @package JoomShopping for Joomla!
* @subpackage payment
* @author YandexMoney
* @copyright Copyright (C) 2012-2014 YandexMoney. All rights reserved.
* @license GNU General Public License version 2 or later
*/
defined('_JEXEC') or die('Restricted access');

class pm_yandexmoney extends PaymentRoot{
    var $existentcheckform = TRUE;
	var $ym_org_mode, $ym_test_mode, $ym_password, $ym_shopid, $ym_scid;

    function showPaymentForm($params, $pmconfigs){
		$this->loadLanguageFile(); 
        include(dirname(__FILE__)."/paymentform.php");
    }

	//function call in admin
	function showAdminFormParams($params){
	  $array_params = array('testmode', 'mode', 'method_ym', 'method_cards', 'method_cash', 'method_phone', 'method_wm', 'password', 'shopid', 'scid', 'account', 'transaction_end_status');
	  foreach ($array_params as $key){
	  	if (!isset($params[$key])) {
			$params[$key] = '';
		}
	  }
      if (!isset($params['use_ssl'])) {
		  $params['use_ssl'] = 0;
	  }
	  $this->loadLanguageFile(); 
      $orders = JModelLegacy::getInstance('orders', 'JshoppingModel'); //admin model
      include(dirname(__FILE__)."/adminparamsform.php");	  
	}

	//ôóíêöèÿ ïîäêëþ÷àåò ÿçûêîâûé ôàéë
	function loadLanguageFile(){
		$lang = JFactory::getLanguage();
		$langtag = $lang->getTag(); //îïðåäåëÿåì òåêóùèé ÿçûê
		if (file_exists(JPATH_ROOT.'/components/com_jshopping/payments/pm_yandexmoney/lang/'.$langtag.'.php')) {
			require_once(JPATH_ROOT.'/components/com_jshopping/payments/pm_yandexmoney/lang/'.$langtag.'.php');
		} else { 
			require_once(JPATH_ROOT.'/components/com_jshopping/payments/pm_yandexmoney/lang/ru-RU.php');
		}
	}


	public function checkSign($callbackParams){
		$string = $callbackParams['action'].';'.$callbackParams['orderSumAmount'].';'.$callbackParams['orderSumCurrencyPaycash'].';'.$callbackParams['orderSumBankPaycash'].';'.$callbackParams['shopId'].';'.$callbackParams['invoiceId'].';'.$callbackParams['customerNumber'].';'.$this->ym_password;
		$md5 = strtoupper(md5($string));
		return ($callbackParams['md5']==$md5);
	}

	public function sendAviso($callbackParams, $code){
		header("Content-type: text/xml; charset=utf-8");
		$xml = '<?xml version="1.0" encoding="UTF-8"?>
			<paymentAvisoResponse performedDatetime="'.date("c").'" code="'.$code.'" invoiceId="'.$callbackParams['invoiceId'].'" shopId="'.$this->shopid.'"/>';
		echo $xml;
	}

	public function sendCode($callbackParams, $code){
		header("Content-type: text/xml; charset=utf-8");
		$xml = '<?xml version="1.0" encoding="UTF-8"?>
			<checkOrderResponse performedDatetime="'.date("c").'" code="'.$code.'" invoiceId="'.$callbackParams['invoiceId'].'" shopId="'.$this->ym_shopid.'"/>';
		echo $xml;
	}

	public function checkOrder($callbackParams, $sendCode=FALSE, $aviso=FALSE){ 
		
		if ($this->checkSign($callbackParams)){
			$code = 0;
		}else{
			$code = 1;
		}
		if ($sendCode){
			if ($aviso){
				$this->sendAviso($callbackParams, $code);	
			}else{
				$this->sendCode($callbackParams, $code);	
			}
			exit;
		}else{
			return $code;
		}
	}

	public function individualCheck($callbackParams){
		$string = $callbackParams['notification_type'].'&'.$callbackParams['operation_id'].'&'.$callbackParams['amount'].'&'.$callbackParams['currency'].'&'.$callbackParams['datetime'].'&'.$callbackParams['sender'].'&'.$callbackParams['codepro'].'&'.$this->ym_password.'&'.$callbackParams['label'];
		$check = (sha1($string) == $callbackParams['sha1_hash']);
		if (!$check){
			header('HTTP/1.0 401 Unauthorized');
			return false;
		}
		return true;
	
	}

	function checkTransaction($pmconfigs, $order, $act){
		$this->ym_org_mode = ($pmconfigs['mode'] == 2);
		$this->ym_password = $pmconfigs['password'];
		$this->ym_shopid = $pmconfigs['shopid'];
		$this->ym_scid = $pmconfigs['scid'];

		$order->order_total = floatval($order->order_total); //ïðèâîäèì ñóììó çàêàçà â íóæíûé ôîðìàò
		
		$rez = '';
		$error = '';
		
		$callbackParams = JRequest::get( 'post' );
		$this->loadLanguageFile(); 
		
		if ($this->ym_org_mode){

			if ($callbackParams['action'] == 'checkOrder'){
				$code = $this->checkOrder($callbackParams);
				$this->sendCode($callbackParams, $code);
				if ($code == 0){
					return array(1, '');
				}else{
					return array(0, 'checkOrder error');
				}
			}
			if ($callbackParams['action'] == 'paymentAviso'){
				$this->checkOrder($callbackParams, TRUE, TRUE);
			}
		}else{
			$check = $this->individualCheck($callbackParams);
			if (!$check){
				return array(0, 'checkOrder error');
			}else{
				return array(1, '');
			}
		}               
	}
	public function getFormUrl(){
		if (!$this->ym_org_mode){
			return $this->individualGetFormUrl();
		}else{
			return $this->orgGetFormUrl();
		}
	}

	public function individualGetFormUrl(){
		if ($this->ym_test_mode){
			return 'https://demomoney.yandex.ru/quickpay/confirm.xml';
		}else{
			return 'https://money.yandex.ru/quickpay/confirm.xml';
		}
	}

	public function orgGetFormUrl(){
		if ($this->ym_test_mode){
            return 'https://demomoney.yandex.ru/eshop.xml';
        } else {
            return 'https://money.yandex.ru/eshop.xml';
        }
	}

	function showEndForm($pmconfigs, $order){
		$this->ym_test_mode = $pmconfigs['testmode'];
		$this->ym_org_mode = ($pmconfigs['mode'] == 2);
		
		$uri = JURI::getInstance();        
        $liveurlhost = $uri->toString(array("scheme",'host', 'port'));
        

	$ym_params = unserialize($order->payment_params_data);
        $jshopConfig = JSFactory::getConfig();	    
        $item_name = $liveurlhost." ".sprintf(_JSHOP_PAYMENT_NUMBER, $order->order_number);
        $this->loadLanguageFile();      
        
	$notify_url = $liveurlhost.SEFLink("index.php?option=com_jshopping&controller=checkout&task=step7&act=notify&js_paymentclass=pm_yandexmoney&no_lang=1");
        $return = $liveurlhost.SEFLink("index.php?option=com_jshopping&controller=checkout&task=step7&act=return&js_paymentclass=pm_yandexmoney");
        $cancel_return = $liveurlhost.SEFLink("index.php?option=com_jshopping&controller=checkout&task=step7&act=cancel&js_paymentclass=pm_yandexmoney");
		
        $_country = JTable::getInstance('country', 'jshop');
        $_country->load($order->d_country);
        $country = $_country->country_code_2;
        $order->order_total = $this->fixOrderTotal($order);
        ?>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=utf-8" />            
        </head>
        <body>
	
	<?php if ($pmconfigs['mode'] == 2){?>
		<form method="POST" action="<?php echo $this->getFormUrl(); ?>"  id="paymentform" name = "paymentform">
		   <input type="hidden" name="paymentType" value="<?php echo $ym_params['ym-payment-type']?>" />
		   <input type="hidden" name="shopid" value="<?php echo $pmconfigs['shopid'];?>">
		   <input type="hidden" name="scid" value="<?php echo $pmconfigs['scid'];?>">
		   <input type="hidden" name="orderNumber" value="<?php echo $order->order_number;?>">
		   <input type="hidden" name="sum" value="<?php echo $order->order_total;?>" data-type="number" >
		   <input type="hidden" name="customerNumber" value="<?php echo $order->user_id; ?>" >
		   <input type="hidden" name="cms_name" value="joomla" >
		   <input type="hidden" name="shopSuccessURL" value="<?php echo $return; ?>" >
		   <input type="hidden" name="shopFailURL" value="<?php echo $cancel_return; ?>" >
		  
			<?php echo _JSHOP_REDIRECT_TO_PAYMENT_PAGE; ?>
			<br>
			<script type="text/javascript">document.getElementById('paymentform').submit();</script>
			
		</form>

<?php }else{ ?>
	<form method="POST" action="<?php echo $this->getFormUrl(); ?>"  id="paymentform" name = "paymentform">
	   <input type="hidden" name="receiver" value="<?php echo $pmconfigs['account']; ?>">
	   <input type="hidden" name="formcomment" value="<?php echo $item_name;?>">
	   <input type="hidden" name="short-dest" value="<?php echo $item_name;?>">
	   <input type="hidden" name="writable-targets" value="false">
	   <input type="hidden" name="comment-needed" value="true">
	   <input type="hidden" name="label" value="<?php echo $order->order_number;?>">
	   <input type="hidden" name="quickpay-form" value="shop">
	   <input type="hidden" name="payment-type" value="<?php echo $ym_params['ym-payment-type']?>" />
	   <input type="hidden" name="targets" value="<?php echo $item_name;?>">
	   <input type="hidden" name="sum" value="<?php echo $order->order_total;?>" data-type="number" >
	   <input type="hidden" name="comment" value="<?php echo $order->order_add_info; ?>" >
	   <input type="hidden" name="need-fio" value="true">
	   <input type="hidden" name="need-email" value="true" >
	   <input type="hidden" name="need-phone" value="false">
	   <input type="hidden" name="need-address" value="false">
	   <br>
		<script type="text/javascript">document.getElementById('paymentform').submit();</script>
		
			
		</form>
<?php } ?>
        
        </body>
        </html>
        <?php
        die();
	}
    
    function getUrlParams($pmconfigs){
        $params = array(); 
		if ($_POST['orderNumber']){
			$params['order_id'] = (int)$_POST['orderID'];
		}else{
			$params['order_id'] = (int)$_POST['label'];
		}
        $params['hash'] = "";
        $params['checkHash'] = 0;
		return $params;
    }
    
	function fixOrderTotal($order){
        $total = $order->order_total;
        if ($order->currency_code_iso=='HUF'){
            $total = round($total);
        }else{
            $total = number_format($total, 2, '.', '');
        }
    return $total;
    }
}
?>
