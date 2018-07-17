<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="index, follow">
	<meta name="keywords" contnet="sehat, yuk, sehat yuk, API, PHP, CodeIgniter, JavaScript, Vue">
	<meta name="description" content="Temukan instansi kesehatan (puskesmas dan rumah sakit) di daerah DKI Jakarta">
	<meta name="author" content="Andriannus Parasian">

	<title><?= $title ?></title>
	<link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/fav.png'); ?>"/>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
	
	<script src="https://unpkg.com/vue@2.5.16/dist/vue.min.js"></script>
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="<?= base_url('assets/js/wow.min.js'); ?>"></script>

	<style>
		html {
			overflow: auto;
		}

		#btnToTop {
			display: none;
			position: fixed;
			z-index: 30;
			bottom: 20px;
			right: 30px;
		}

		.m-t-52 {
			margin-top: 52px;
		}
	</style>
</head>
<body>
	<?php
		if (isset($navigation)) {
			$this->load->view($navigation);
		}
	?>
	
	<?php $this->load->view($page) ?>

	<button id="btnToTop" class="button is-dark is-large">
		<i class="fas fa-chevron-circle-up"></i>
	</button>

	<script>
	window.onscroll = () => backToTop()

	function backToTop () {
		let body = $('body')

		if (body.scrollTop() > 800) {
			$('#btnToTop').show()
		
		} else {
			$('#btnToTop').hide()
		}
	}


	$('#btnToTop').click(() => {
		$('html, body').animate(
			{ scrollTop: 0 },
			'slow'
		)
	})

	wow = new WOW({}).init();
	</script>
</body>
</html>
