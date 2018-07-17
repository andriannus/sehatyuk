<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="hero is-danger is-fullheight">
	<div class="hero-body">
		<div class="container has-text-centered">
			<h1 class="title wow zoomIn" data-wow-duration="1s" data-wow-delay="1s">
				Selamat Datang di Website SEHAT YUK
			</h1>

			<p class="subtitle wow zoomIn" data-wow-duration="1s" data-wow-delay="1.2s">
				Apa yang ingin Anda lihat?
			</p>


			<div class="columns is-mobile">
				<div class="column is-6 is-offset-3">
					<div class="columns">
						<div class="column">
							<a class="button is-danger is-inverted is-fullwidth wow zoomIn" href="<?= base_url('puskesmas') ?>" data-wow-duration="1s" data-wow-delay="1.4s">
								Puskesmas
							</a>
						</div>

						<div class="column">
							<a class="button is-danger is-inverted is-fullwidth wow zoomIn" href="<?= base_url('rsk') ?>" data-wow-duration="1s" data-wow-delay="1.6s">
								RS Khusus
							</a>
						</div>

						<div class="column">
							<a class="button is-danger is-inverted is-fullwidth wow zoomIn" href="<?= base_url('rsu') ?>" data-wow-duration="1s" data-wow-delay="1.8s">
								RS Umum
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
