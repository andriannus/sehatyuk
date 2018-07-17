<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="hero is-light is-fullheight">
	<div class="hero-body">
		<div class="container has-text-centered">
			<h1 class="title wow zoomIn" data-wow-duration="1s">
				<i class="fas fa-sad-tear fa-2x"></i>
			</h1>

			<p class="subtitle wow zoomIn" data-wow-duration="1s" data-wow-delay="0.2s">
				Halaman Tidak Ditemukan
			</p>

			<a class="button is-rounded wow zoomIn" href="<?= base_url('home') ?>" data-wow-duration="1s" data-wow-delay="0.4s">
				Beranda
			</a>

			<a class="button is-rounded wow zoomIn" href="<?= base_url('puskesmas') ?>" data-wow-duration="1s" data-wow-delay="0.6s">
				Puskesmas
			</a>

			<a class="button is-rounded wow zoomIn" href="<?= base_url('rsk') ?>" data-wow-duration="1s" data-wow-delay="0.8s">
				RS Khusus
			</a>
			
			<a class="button is-rounded wow zoomIn" href="<?= base_url('rsu') ?>" data-wow-duration="1s" data-wow-delay="1s">
				RS Umum
			</a>
		</div>
	</div>
</section>
