<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="nav">
	<nav class="navbar is-fixed-top is-danger" role="navigation" aria-label="main navigation">
		<div class="navbar-brand">
			<a class="navbar-item wow slideInLeft" href="<?= base_url('home') ?>" data-wow-duration="1s">
				SEHAT YUK
			</a>

			<a role="button" class="navbar-burger has-text-white" :class="{ 'is-active': isActive }" aria-label="menu" aria-expanded="false" @click="switchMenu">
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
			</a>
		</div>

		<div class="navbar-menu wow fadeInDown" :class="{ 'is-active': isActive }" data-wow-duration="1s">
			<div class="navbar-start">
				<div class="navbar-item wow slideInDown" data-wow-duration="1s">
					<div class="field is-grouped">
						<p class="control">
							<a class="button is-dark" href="https://github.com/andriannus/sehatyuk" target="_blank">
								<span class="icon">
									<i class="fab fa-github"></i>
								</span>
								<span>Github</span>
							</a>
						</p>
					</div>
				</div>
			</div>

			<div class="navbar-end">
				<a
					class="navbar-item wow slideInDown <?= (isset($menu) && $menu === 'home' ? 'is-active' : ''); ?>"
					href="<?= base_url('home') ?>"
					data-wow-duration="1s"
					data-wow-delay="0.4s"
				>Beranda</a>

				<a
					class="navbar-item wow slideInDown <?= (isset($menu) && $menu === 'puskesmas' ? 'is-active' : ''); ?>"
					href="<?= base_url('puskesmas') ?>"
					data-wow-duration="1s"
					data-wow-delay="0.4s"
				>Puskesmas</a>

				<a
					class="navbar-item wow slideInDown <?= (isset($menu) && $menu === 'rsk' ? 'is-active' : ''); ?>"
					href="<?= base_url('rsk') ?>"
					data-wow-duration="1s"
					data-wow-delay="0.6s"
				>Rumah Sakit Khusus</a>


				<a 
					class="navbar-item wow slideInDown <?= (isset($menu) && $menu === 'rsu' ? 'is-active' : ''); ?>"
					href="<?= base_url('rsu') ?>"
					data-wow-duration="1s"
					data-wow-delay="0.8s"
				>Rumah Sakit Umum</a>
			</div>
		</div>
	</nav>
</div>

<script>
new Vue({
	el: '#nav',
	data: () => ({
		isActive: false
	}),

	methods: {
		switchMenu () {
			this.isActive = !this.isActive
		}
	}
})
</script>
