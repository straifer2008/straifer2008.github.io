
	jQuery(document).ready(function($) {

		//$('#nav-main').scrollspy()

		// Localscrolling
		$('#nav-main, .brand').localScroll();
		$('#news, .container').localScroll();
	});
/*

    var xmlhttp = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    function sendToMail() {
        xmlhttp.open('POST', 'https://mandrillapp.com/api/1.0/messages/send.json');
        xmlhttp.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4) {
                if(xmlhttp.status == 200) alert('Mail sended!')
                else if(xmlhttp.status == 500) alert('Check apikey')
                else alert('Request error');
            }
        };
        xmlhttp.send(JSON.stringify({'key': 'db9bdb0df8756a73b4acfd56104f045f-us12',
            'message': {
                'from_email': 'site7kids@site7Kids.here',
                'to': [{'email': 'straifer69@gmail.com', 'type': 'to'}],
                'autotext': 'true',
                'subject': 'Yeah!',
                'html': '<h1>Its work!</h1>'
            }}));
    }*/
