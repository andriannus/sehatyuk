<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="puskesmas">
	<!-- Header -->
	<section class="hero is-danger is-bold m-t-52">
		<div class="hero-body">
			<div class="container wow slideInLeft" data-wow-duration="1s" data-wow-delay="0.8s">
				<h1 class="title">
					Daftar Puskesmas
				</h1>

				<!-- Memuat Total Puskesmas -->
				<p class="subtitle" v-if="loading">
					<i class="fas fa-spin fa-spinner title"></i>
				</p>
				<!-- Akhir Memuat Total Puskesmas -->

				<p class="subtitle" v-if="!loading">Ada {{ count }} Puskesmas di DKI Jakarta</p>
			</div>
		</div>
	</section>
	<!-- Akhir Header -->

	<!-- Memuat Data Puskesmas -->
	<section class="section has-text-centered" v-if="loading">
		<i class="fas fa-spin fa-spinner title"></i>
		<p class="subtitle">Memuat data...</p>
	</section>
	<!-- Akhir Memuat Data Puskesmas -->

	<section class="section" v-if="!loading">
		<div class="columns is-mobile">
			<div class="column is-10 is-offset-1">
				<div class="field">
					<div class="control has-icons-right">
						<input class="input" type="text" v-model="query" placeholder="Cari nama puskesmas disini..." @input="fetchData">
						<span class="icon is-small is-right">
							<i class="fas fa-search"></i>
						</span>
					</div>
				</div>

				<hr>

				<!-- Puskesmas Tidak Ditemukan -->
				<div class="box has-text-centered" v-if="!found">
					<p class="title">
						<i class="fas fa-sad-tear fa-2x"></i>
					</p>
					<p class="subtitle">
						Puskesmas <strong>{{ query }}</strong> tidak ditemukan
					</p>
				</div>
				<!-- Akhir Puskesmas Tidak Ditemukan -->

				<article class="message is-danger" v-for="(puskesmas, index) in newPuskesmases" v-if="!loading && newPuskesmases && found">
					<div class="message-header">
						<p>{{ puskesmas.nama_Puskesmas }}</p>
					</div>
					<div class="message-body">
						<div class="field">
							<label class="label">Alamat</label>
							<div class="control">
								<span>{{ puskesmas.location.alamat }}</span>
							</div>
						</div>
						<div class="field">
							<div class="control">
								<button class="button is-danger" @click="getPuskesmas(puskesmas.id)">Lihat</button>
							</div>
						</div>
					</div>
				</article>
			</div>
		</div>
	</section>

	<!-- Modal Detail Puskesmas -->
	<div class="modal" :class="{ 'is-active': visibleModal }">
		<div class="modal-background"></div>
		<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">Detail Puskesmas</p>
				<button class="delete" aria-label="close" @click="switchModal"></button>
			</header>

			<!-- Memuat Detail Puskesmas -->
			<section class="modal-card-body has-text-centered" v-if="loadingPuskesmas">
				<i class="fas fa-spin fa-spinner title"></i>
				<p class="subtitle">Memuat data...</p>
			</section>
			<!-- Akhir Memuat Detail Puskesmas -->

			<section class="modal-card-body" v-if="!loadingPuskesmas">
				<div class="field">
					<label class="label">Nama Puskesmas</label>
					<div class="control">
						<p>{{ puskesmas.nama_Puskesmas }}</p>
					</div>
				</div>

				<div class="field">
					<label class="label">Alamat</label>
					<div class="control">
						<p>{{ puskesmas.location.alamat }}</p>
						<span>
							<button class="button is-danger" @click="showMap">Lihat Peta</button>
						</span>
					</div>
				</div>

				<div class="field">
					<label class="label">Kepala Puskesmas</label>
					<div class="control">
						<span>{{ puskesmas.kepala_puskesmas }}</span>
					</div>
				</div>

				<div class="field">
					<label class="label">Telepon</label>
					<div class="control">
						<span v-if="puskesmas.telepon[0] === ''">-</span>

						<div class="tags" v-if="puskesmas.telepon[0] != ''">
							<span class="tag is-medium is-danger is-rounded" v-for="(t, index) in puskesmas.telepon">{{ t }}</span>
						</div>
					</div>
				</div>

				<div class="field">
					<label class="label">Fax</label>
					<div class="control">
						<span v-if="puskesmas.faximile[0] === ''">-</span>
						
						<div class="tags" v-if="puskesmas.faximile[0] != ''">
							<span class="tag is-medium is-danger is-rounded" v-for="(f, index) in puskesmas.faximile">{{ f }}</span>
						</div>
					</div>
				</div>

				<div class="field">
					<label class="label">Email</label>
					<div class="control">
						<span v-if="!puskesmas.email">-</span>
						
						<span v-if="puskesmas.email">{{ puskesmas.email }}</span>
					</div>
				</div>
			</section>

			<footer class="modal-card-foot">
				<button class="button is-danger" @click="switchModal">Tutup</button>
			</footer>
		</div>
	</div>
	<!-- Akhir Modal Detail Puskesmas -->
</div>

<script>
new Vue({
	el: '#puskesmas',
	data: () => ({
		puskesmases: [],
		newPuskesmases: [],
		puskesmas: {},
		count: '',
		query: '',
		found: '',
		visibleModal: false,
		loading: true,
		loadingPuskesmas: true
	}),

	mounted() {
		this.getData()
	},

	methods: {
		// Mengambil data seluruh puskesmas dari cURL
		getData () {
			axios.get('<?= base_url() ?>' + 'api/getPuskesmas')
				.then(res => {
					this.puskesmases = res.data.data
					this.count = res.data.data.length
					this.fetchData()
					this.loading = false
				})

				.catch(err => {
					alert('Terjadi error. Silahkan refresh halaman atau coba lagi nanti.')
				})
		},

		// Membuat array baru untuk membuat fitur 'cari'
		fetchData () {
			this.loading = true

			this.newPuskesmases = []
			let query = this.query.toLowerCase()
			this.puskesmases.map((puskesmas) => {
				if (puskesmas.nama_Puskesmas.toLowerCase().indexOf(query) !== -1) {
					this.newPuskesmases.push(puskesmas)
				}
			})

			if (this.newPuskesmases.length < 1) {
				this.found = false

			} else {
				this.found = true
			}

			this.loading = false
		},

		// Mengambil data 1 puskesmas dari cURL
		getPuskesmas (id) {
			this.switchModal()

			axios.get('<?= base_url() ?>' + 'api/getPuskesmas?id=' + id)
				.then(res => {
					this.puskesmas = res.data.data[0]
					this.loadingPuskesmas = false
				})

				.catch(err => {
					alert('Terjadi error. Silahkan refresh halaman atau coba lagi nanti.')
				})
		},

		// Menampilkan Google Maps pada tab browser yang baru
		showMap () {
			let center = this.puskesmas.location.latitude + ',' + this.puskesmas.location.longitude
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
			this.loadingPuskesmas = true
		}
	}
})
</script>
