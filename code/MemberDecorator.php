<?php
class MemberDecorator extends DataExtension {
	function extraStatics() {
		return array(
			'has_many' => array(
				'Extensions' => 'ExtensionData',
			)
		);
	}
}