<?php

if ( ! function_exists( 'dd' ) ) {

	function dd() {
		dump( func_get_args() );
		die;
	}
}