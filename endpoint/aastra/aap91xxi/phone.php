<?php
/**
 * Aastra 9133i and 9122i Phone File
 *
 * @author Andrew Nagy
 * @license MPL / GPLv2 / LGPL
 * @package Provisioner
 */
class endpoint_aastra_aap91xxi_phone extends endpoint_aastra_base {
	public $family_line = 'aap91xxi';
	
	function generate_config() {

		$this->en_htmlspecialchars = FALSE;

		if(!isset($this->options['provisioning_server'])) {
			$this->options['provisioning_server'] = $this->server[1]['ip'];
		}
		
		if(!isset($this->options['provisioning_path'])) {
			$this->options['provisioning_path'] = '';
		}
				
		switch($this->provisioning_type) {
			case "tftp":
				$this->options['provisioning_protocol'] = 'TFTP';
				break;
			case "http":
				$this->options['provisioning_protocol'] = 'HTTP';
				break;
			case "https":
				$this->options['provisioning_protocol'] = 'HTTPS';
				break;
		}
		
		//mac.cfg
		$contents = $this->open_config_file("\$mac.cfg");
		$final[$this->mac.'.cfg'] = $this->parse_config_file($contents, FALSE);
		
		//aastra.cfg
		$contents = $this->open_config_file("aastra.cfg");
		$final['aastra.cfg'] = $this->parse_config_file($contents, FALSE);
		
		if($this->server_type == 'dynamic') {
			$out = '';
			$out[$this->mac.'.cfg'] = '';
			foreach($final as $key => $value) {
				$out[$this->mac.'.cfg'] .= $value . "\n";
				if($key != $this->mac.'.cfg') {
					$out[$key] = '#This File is intentionally left blank';
				}
			}
			return($out);
		} else {
			return($final);
		}
	}
}
?>