function formhash(form, password) {
	var p = document.createElement("input");
	
	form.appendChild(p);
	p.name = "p";
	p.type = "hidden";
	p.value = hex_sha512(password.value);
	
	// Clear password so plain text is not sent.
	password.value = "";
	
	form.submit();
}

function regformhash(form, username, email, password, conf) {
	if (username.value == '' || email.value == '' || password.value == '' || conf.value == '') {	
		//TODO remove alerts
		alert('You must provide all the requested details. Please try again.');
		return false;
	}
	
	var re = /^\w+$/;
	if (!re.test(username.value)) {
		//TODO remove alerts
		alert('Username must contain only letter, numbers and underscores. Please try again.');
		return false;
	}
	if (!re.test(password.value) && length(password.value) >= 6) {
		//TODO remove alerts
		alert('Passwords must contain only letter, numbers and underscores, and must be at least 6 characters. Please try again.');
		return false;
	}
	if (password.value != conf.value) {
		//TODO remove alerts
		alert('Your password and confirmation do not match. Please try again.');
		return false;
	}
	
	var p = document.createElement("input");
	
	form.appendChild(p);
	p.name = "p";
	p.type = "hidden";
	p.value = hex_sha512(password.value);
	
	// Clear password so plain text is not sent.
	password.value = "";
	conf.value = "";
	
	form.submit();
	return true;
}