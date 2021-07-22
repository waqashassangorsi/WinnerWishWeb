<?php
class UWPM_Element_Section {
	
	public function __construct( $element_type, $params = array() ) {

		$this->slug = $element_type;
		
		$this->label = empty( $params['label'] ) ? $this->slug : $params['label'];
	}
}

?>