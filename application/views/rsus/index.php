<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="rsu">
	<!-- Header -->
	<section class="hero is-danger is-bold m-t-52">
		<div class="hero-body">
			<div class="container wow slideInLeft" data-wow-duration="1s" data-wow-delay="0.8s">
				<h1 class="title">
					Daftar Rumah Sakit Umum
				</h1>

				<!-- Memuat Total RS Umum -->
				<p class="subtitle" v-if="loading">
					<i class="fas fa-spin fa-spinner title"></i>
				</p>
				<!-- Akhir Memuat Total RS Umum -->

				<p class="subtitle" v-if="!loading">Ada {{ count }} RS Umum di DKI Jakarta</p>
			</div>
		</div>
	</section>
	<!-- Akhir Header -->

	<!-- Memuat Data RS Umum -->
	<section class="section has-text-centered" v-if="loading">
		<i class="fas fa-spin fa-spinner title"></i>
		<p class="subtitle">Memuat data...</p>
	</section>
	<!-- Akhir Memuat Data RS Umum -->

	<section class="section" v-if="!loading">
		<div class="columns is-mobile">
			<div class="column is-10 is-offset-1">
				<div class="field">
					<div class="control has-icons-right">
						<input class="input" type="text" v-model="query" placeholder="Cari nama RS disini..." @input="fetchData">
						<span class="icon is-small is-right">
							<i class="fas fa-search"></i>
						</span>
					</div>
				</div>

				<hr>

				<!-- RS Umum Tidak Ditemukan -->
				<div class="box has-text-centered" v-if="!found">
					<p class="title">
						<i class="fas fa-sad-tear fa-2x"></i>
					</p>
					<p class="subtitle">
						RS <strong>{{ query }}</strong> tidak ditemukan
					</p>
				</div>
				<!-- Akhir RS Umum Tidak Ditemukan -->

				<article class="message is-danger" v-for="(rsu, index) in newRsus" v-if="!loading">
					<div class="message-header">
						<p>RS {{ rsu.nama_rsu }}</p>
					</div>
					<div class="message-body">
						<div class="field">
							<label class="label">Alamat</label>
							<div class="control">
								<span>{{ rsu.location.alamat }}</span>
							</div>
						</div>
						<div class="field">
							<div class="control">
								<button class="button is-danger" @click="getRsu(rsu.id)">Lihat</button>
							</div>
						</div>
					</div>
				</article>
			</div>
		</div>
	</section>

	<!-- Modal Detail RS Umum -->
	<div class="modal" :class="{ 'is-active': visibleModal }">
		<div class="modal-background"></div>
		<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">Detail RS Umum</p>
				<button class="delete" aria-label="close" @click="switchModal"></button>
			</header>

			<!-- Memuat Detail RS Umum -->
			<section class="modal-card-body has-text-centered" v-if="loadingRsu">
				<i class="fas fa-spin fa-spinner title"></i>
				<p class="subtitle">Memuat data...</p>
			</section>
			<!-- Akhir Memuat Detail RS Umum -->

			<section class="modal-card-body" v-if="!loadingRsu">
				<div class="field">
					<label class="label">Nama RS Umum</label>
					<div class="control">
						<p>RS {{ rsu.nama_rsu }}</p>
					</div>
				</div>

				<div class="field">
					<label class="label">Jenis RS Umum</label>
					<div class="control">
						<span>{{ rsu.jenis_rsu }}</span>
					</div>
				</div>

				<div class="field">
					<label class="label">Alamat</label>
					<div class="control">
						<p>{{ rsu.location.alamat }}</p>
						<span>
							<button class="button is-danger" @click="showMap">Lihat Peta</button>
						</span>
					</div>
				</div>

				<div class="field">
					<label class="label">Website</label>
					<div class="control">
						<span v-if="!rsu.website">-</span>
						<a :href="'http://' + rsu.website" class="has-text-link" v-if="rsu.website" target="_blank">{{ rsu.website }}</a>
					</div>
				</div>

				<div class="field">
					<label class="label">Telepon</label>
					<div class="control">
						<span v-if="rsu.telepon[0] === ''">-</span>

						<div class="tags" v-if="rsu.telepon[0] != ''">
							<span class="tag is-medium is-danger is-rounded" v-for="(t, index) in rsu.telepon">{{ t }}</span>
						</div>
					</div>
				</div>

				<div class="field">
					<label class="label">Fax</label>
					<div class="control">
						<span v-if="rsu.faximile[0] === ''">-</span>
						
						<div class="tags" v-if="rsu.faximile[0] != ''">
							<span class="tag is-medium is-danger is-rounded" v-for="(f, index) in rsu.faximile">{{ f }}</span>
						</div>
					</div>
				</div>

				<div class="field">
					<label class="label">Email</label>
					<div class="control">
						<span v-if="!rsu.email">-</span>

						<span v-if="rsu.email">{{ rsu.email }}</span>
					</div>
				</div>
			</section>

			<footer class="modal-card-foot">
				<button class="button is-danger" @click="switchModal">Tutup</button>
			</footer>
		</div>
	</div>
	<!-- Akhir Modal Detail RS Umum -->
</div>

<script>
new Vue({
	el: '#rsu',
	data: () => ({
		rsus: [],
		newRsus: [],
		rsu: {},
		count: '',
		query: '',
		found: '',
		visibleModal: false,
		loading: true,
		loadingRsu: true
	}),

	mounted() {
		this.getData()
	},

	methods: {
		getData () {
			axios.get('<?= base_url() ?>' + 'api/getRumahSakitUmum')
				.then(res => {
					this.rsus = res.data.data
					this.count = res.data.data.length
					this.fetchData()
					this.loading = false
				})

				.catch(err => {
					alert('Terjadi error. Silahkan refresh halaman atau coba lagi nanti.')
				})
		},

		fetchData () {
			this.loading = true

			this.newRsus = []
			let query = this.query.toLowerCase()
			this.rsus.map((rsu) => {
				if (rsu.nama_rsu.toLowerCase().indexOf(query) !== -1) {
					this.newRsus.push(rsu)
				}
			})

			if (this.newRsus.length < 1) {
				this.found = false

			} else {
				this.found = true
			}

			this.loading = false
		},

		// Mengambil data 1 RSU dari cURL
		getRsu (id) {
			this.switchModal()

			axios.get('<?= base_url() ?>' + 'api/getRumahSakitUmum?id=' + id)
				.then(res => {
					this.rsu = res.data.data[0]
					this.loadingRsu = false
				})

				.catch(err => {
					alert('Terjadi error. Silahkan refresh halaman atau coba lagi nanti.')
				})
		},

		// Menampilkan Google Maps pada tab browser yang baru
		showMap () {
			let center = this.rsu.latitude + ',' + this.rsu.longitude
			let url = 'https://www.google.com/maps/search/?api=1&query=' + center
			window.open(url, '_blank')
		},

		// Mengaktifkan atau menonaktifkan 'modal'
		switchModal () {
			let html = $('html')

			if (html.css('overflow') === 'auto') {
				html.css('overflow', 'hidden')
			
			} else {
				html.css('overflow', 'auto')
			}

			this.visibleModal = !this.visibleModal
			this.loadingRsu = true
		}
	}
})
</script>
