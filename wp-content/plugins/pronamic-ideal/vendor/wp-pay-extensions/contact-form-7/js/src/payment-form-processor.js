document.addEventListener( 'wpcf7submit', ( event ) => {
	let detail = event.detail;

	if ( 'pronamic_pay_redirect' !== detail.status ) {
		return;
	}

	window.location.href = detail.apiResponse.pronamic_pay_redirect_url;
} );
