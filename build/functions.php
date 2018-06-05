<?php

if ( ! function_exists( 'dd' ) ) {

	function dd() {
		$args = func_get_args();
		if ( count( $args ) ) {
			call_user_func_array( 'dump', func_get_args() );
		}
		
		die;
	}
}
