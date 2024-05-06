<?php

if (isset($_POST['StepByStepFormData'])) {
	new OrderAjaxHandler();
}

/**
 * 
 */
class OrderAjaxHandler {
	
	function __construct() {

		$re = [
			'alert' => [
				'color' => 'success',
				'message' => 'Заявка отправлена администратору!',
			],
		];
		echo json_encode($re);
		exit();
		
	}
}