<div id="fb-root"></div>
<a id="repeat" class="repeat button" href="<?=site_url('start');?>"></a>
<div id="activity-background"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>

	FB.init({
		appId  : '172229782938829',
		frictionlessRequests: true
	});

	function sendRequestToRecipients() {
		var user_ids = document.getElementsByName("user_ids")[0].value;
		FB.ui({method: 'apprequests',
			message: 'My Great Request',
			to: user_ids
		}, requestCallback);
	}

	function sendRequestViaMultiFriendSelector() {
		FB.ui({method: 'apprequests',
			message: 'Hoi! ik vond dit op Offf!, zin om dat samen te gaan doen? <?=site_url('activity/'.$this->input->get('activity'))?>'
		}, requestCallback);
	}

	sendRequestViaMultiFriendSelector();

	function requestCallback(response) {
		window.top.location = '<?=site_url('activity/'.$this->input->get('activity'))?>';
	}
</script>