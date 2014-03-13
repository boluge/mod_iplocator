<?php
/**
 * @copyright	Copyright (c) 2014 Ip Locator. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

	$doc =& JFactory::getDocument();
	$doc->addStyleSheet( 'modules/mod_iplocator/assets/css/style.css' );

	jimport( 'joomla.application.module.helper' );
	jimport( 'joomla.html.parameter' );
	$module = &JModuleHelper::getModule('mod_iplocator');
	$moduleParams = new JParameter($module->params);
	// Flags
	$flag = $moduleParams->get('flag');
	$size = $moduleParams->get('flagsize');

	//Redirect
	//print_r($moduleParams);

	include_once(JPATH_ROOT.DS."modules".DS."mod_iplocator/assets/libs/geoipcity.inc");
	include_once(JPATH_ROOT.DS."modules".DS."mod_iplocator/assets/libs/geoipregionvars.php");

	$ip = $_SERVER['REMOTE_ADDR'];
	// $ip = '82.229.204.31';
	// $ip = '194.154.215.115';
	// $ip = '213.239.224.65';
	// $ip = '4.69.154.190';

	$gi = geoip_open(realpath(JPATH_ROOT.DS."modules".DS."mod_iplocator/assets/libs/db/GeoLiteCity.dat"),GEOIP_STANDARD);

	$record = geoip_record_by_addr($gi,$ip);

	if($record) {
		for ($i=1; $i < 9 ; $i++) {
			$actif = $moduleParams->get('actif'.$i);
			if($actif == 1){

				$redirect = $moduleParams->get('redirect'.$i);
				$code = $moduleParams->get('code'.$i);
				$url = $moduleParams->get('url'.$i);

				if( $redirect == 1) {
					if( $code == $record->country_code ){
						header('Location: '.$url);
						exit;
					}
				} else {
					if( $code != $record->country_code ){
						header('Location: '.$url);
						exit;
					}
				}
			}

		}
	}

?>



	<div id="iplocator">
		<p><b><?php echo $ip; ?></b></p>
		<?php if($record): ?>
			<p><?php echo $record->country_name; ?></p>
			<?php if( $flag != 'null' ): ?>
				<p><img src="modules/mod_iplocator/assets/img/flags/<?php echo $flag;  ?>/<?php echo $size;  ?>/<?php echo $record->country_code; ?>.png"/></p>
			<?php endif; ?>
		<?php endif; ?>
	</div>

   <!--  <pre><?php print_r($record); ?></pre> -->


