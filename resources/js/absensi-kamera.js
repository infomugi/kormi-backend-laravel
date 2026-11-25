/**
 * Komponen Alpine halaman Absensi mobile:
 * kamera langsung + deteksi wajah (client-side), GPS, dan unggah foto ke Livewire.
 */
export function buatAbsensiKamera() {
    return {
        // Lokasi
        isLocating: false,
        gpsError: '',

        // Foto
        isUploading: false,
        fotoError: '',

        // Jam berjalan (WIB)
        jamSekarang: '—',
        pengaturJam: null,

        // Overlay kamera
        kameraTerbuka: false,
        kameraSiap: false,
        izinKameraError: '',
        statusDeteksi: 'idle', // idle | memuat | aktif | tidak-didukung
        jumlahWajah: 0,
        wajahTerdeteksi: false,
        modeKamera: 'user',
        _stream: null,
        _detektor: null,
        _pemuatFaceApi: null,
        _intervalDeteksi: null,
        _deteksiSibuk: false,
        _pemicuFokus: null,
        _padaVisibilitas: null,

        init() {
            this.perbaruiJam();
            this.pengaturJam = setInterval(() => this.perbaruiJam(), 30000);
            this.deteksiLokasi();

            this._padaVisibilitas = () => {
                if (document.hidden) {
                    this.tutupDeteksi();
                } else if (this.kameraTerbuka && this.kameraSiap && this._detektor) {
                    this.mulaiLoopDeteksi();
                }
            };
            document.addEventListener('visibilitychange', this._padaVisibilitas);
        },

        destroy() {
            if (this.pengaturJam) {
                clearInterval(this.pengaturJam);
                this.pengaturJam = null;
            }
            if (this._padaVisibilitas) {
                document.removeEventListener('visibilitychange', this._padaVisibilitas);
                this._padaVisibilitas = null;
            }
            this.tutupKamera(false);
        },

        perbaruiJam() {
            try {
                this.jamSekarang = new Intl.DateTimeFormat('id-ID', {
                    timeZone: 'Asia/Jakarta',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false,
                }).format(new Date()) + ' WIB';
            } catch (e) {
                this.jamSekarang = '';
            }
        },

        deteksiLokasi() {
            if (! navigator.geolocation) {
                this.gpsError = 'Perangkat ini tidak mendukung GPS.';
                return;
            }
            this.isLocating = true;
            this.gpsError = '';
            navigator.geolocation.getCurrentPosition(
                async (pos) => {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;
                    let alamat = null;
                    try {
                        const res = await fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lng + '&zoom=18&addressdetails=1');
                        const data = await res.json();
                        const a = data.address || {};
                        const bagian = [
                            a.road || a.pedestrian || a.neighbourhood,
                            a.village || a.suburb || a.hamlet,
                            a.city_district || a.municipality || a.town,
                            a.city || a.county,
                        ].filter((v, i, arr) => v && arr.indexOf(v) === i);
                        alamat = bagian.length ? bagian.join(', ') : (data.display_name || null);
                    } catch (e) {}
                    this.gpsError = '';
                    await this.$wire.terapkanLokasi(lat, lng, alamat, pos.coords.accuracy);
                    this.isLocating = false;
                },
                () => {
                    this.isLocating = false;
                    this.gpsError = 'Izin lokasi ditolak atau GPS tidak aktif. Aktifkan GPS lalu tekan tombol perbarui.';
                },
                { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
            );
        },

        async unggahFoto(event) {
            const input = event.target;
            const file = input.files && input.files[0];
            input.value = '';
            if (! file) return;
            if (! file.type.startsWith('image/')) {
                this.fotoError = 'Berkas harus berupa gambar JPG, PNG, atau WEBP.';
                return;
            }
            this.fotoError = '';
            let hasil = file;
            if (file.size > 2 * 1024 * 1024 && window.compressImageClientSide) {
                try {
                    hasil = await window.compressImageClientSide(file, { maxSizeMB: 2, maxWidthOrHeight: 1600, initialQuality: 0.82 });
                } catch (e) {}
            }
            this.$wire.upload('foto', hasil, () => {}, () => {
                this.fotoError = 'Foto gagal diunggah. Periksa koneksi lalu coba lagi.';
            });
        },

        // ---------- Kamera langsung ----------
        async bukaKamera() {
            this.izinKameraError = '';
            this.fotoError = '';
            this._pemicuFokus = document.activeElement;
            this.kameraTerbuka = true;
            this._kunciScroll(true);
            this.$nextTick(() => {
                if (this.$refs.tombolTutup) {
                    this.$refs.tombolTutup.focus({ preventScroll: true });
                }
            });

            if (! navigator.mediaDevices || ! navigator.mediaDevices.getUserMedia) {
                this.kameraSiap = false;
                this.izinKameraError = 'Browser ini belum mendukung kamera langsung. Gunakan kamera perangkat.';
                return;
            }

            this.kameraSiap = false;
            this.statusDeteksi = 'memuat';
            this.wajahTerdeteksi = false;
            this.jumlahWajah = 0;

            try {
                await this.mulaiStream();
            } catch (e) {
                this.kameraSiap = false;
                this.izinKameraError = (e && (e.name === 'NotAllowedError' || e.name === 'SecurityError'))
                    ? 'Izin kamera ditolak. Aktifkan izin kamera di browser, atau gunakan kamera perangkat.'
                    : 'Kamera langsung tidak dapat dibuka. Gunakan kamera perangkat.';
            }
        },

        async mulaiStream() {
            this.hentikanStream();
            this._stream = await navigator.mediaDevices.getUserMedia({
                audio: false,
                video: {
                    facingMode: this.modeKamera,
                    width: { ideal: 960 },
                    height: { ideal: 1280 },
                },
            });

            const video = this.$refs.videoKamera;
            if (! video) return;

            video.srcObject = this._stream;

            if (video.readyState >= 1) {
                await this.siapkanVideo(video);
            } else {
                await new Promise((resolve) => {
                    video.onloadedmetadata = resolve;
                    setTimeout(resolve, 2500);
                });
                await this.siapkanVideo(video);
            }
        },

        async siapkanVideo(video) {
            try {
                await video.play();
            } catch (e) {}
            this.kameraSiap = true;
            this.izinKameraError = '';
            this.siapkanDetektor();
        },

        gantiKamera() {
            if (! this.kameraSiap || this.izinKameraError) return;
            this.modeKamera = this.modeKamera === 'user' ? 'environment' : 'user';
            this.tutupDeteksi();
            this.mulaiStream().catch(() => {
                this.izinKameraError = 'Kamera tidak dapat diganti pada perangkat ini.';
            });
        },

        hentikanStream() {
            if (this._stream) {
                this._stream.getTracks().forEach((track) => track.stop());
                this._stream = null;
            }
            const video = this.$refs.videoKamera;
            if (video) {
                video.srcObject = null;
            }
            this.kameraSiap = false;
        },

        tutupDeteksi() {
            if (this._intervalDeteksi) {
                clearInterval(this._intervalDeteksi);
                this._intervalDeteksi = null;
            }
            this.wajahTerdeteksi = false;
            this.jumlahWajah = 0;
        },

        tutupKamera(kembalikanFokus = true) {
            const pemicu = this._pemicuFokus;
            this._pemicuFokus = null;
            this.kameraTerbuka = false;
            this._kunciScroll(false);
            this.tutupDeteksi();
            this.hentikanStream();
            this.statusDeteksi = 'idle';

            if (kembalikanFokus && pemicu && document.contains(pemicu)) {
                pemicu.focus({ preventScroll: true });
            }
        },

        _kunciScroll(aktif) {
            document.body.classList.toggle('overflow-hidden', aktif);
        },

        // ---------- Deteksi wajah ----------
        async siapkanDetektor() {
            this.statusDeteksi = 'memuat';

            if ('FaceDetector' in window) {
                try {
                    this._detektor = new window.FaceDetector({ fastMode: true, maxDetectedFaces: 2 });
                    this.statusDeteksi = 'aktif';
                    this.mulaiLoopDeteksi();
                    return;
                } catch (e) {}
            }

            try {
                await this.muatFaceApi();
                this._detektor = 'faceapi';
                this.statusDeteksi = 'aktif';
                this.mulaiLoopDeteksi();
            } catch (e) {
                this.statusDeteksi = 'tidak-didukung';
            }
        },

        muatFaceApi() {
            if (window.faceapi && window.faceapi.nets?.tinyFaceDetector?.isLoaded) {
                return Promise.resolve(window.faceapi);
            }
            if (this._pemuatFaceApi) {
                return this._pemuatFaceApi;
            }

            this._pemuatFaceApi = new Promise((resolve, reject) => {
                const batas = setTimeout(() => reject(new Error('Batas waktu pemuatan detektor wajah terlampaui.')), 15000);
                const selesai = () => clearTimeout(batas);

                const muatModel = async () => {
                    try {
                        if (! window.faceapi) {
                            throw new Error('Pustaka deteksi wajah gagal dimuat.');
                        }
                        if (! window.faceapi.nets.tinyFaceDetector.isLoaded) {
                            await window.faceapi.nets.tinyFaceDetector.loadFromUri(
                                'https://cdn.jsdelivr.net/npm/@vladmandic/face-api@1.7.15/model'
                            );
                        }
                        selesai();
                        resolve(window.faceapi);
                    } catch (e) {
                        selesai();
                        reject(e);
                    }
                };

                const skrip = document.createElement('script');
                skrip.src = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api@1.7.15/dist/face-api.min.js';
                skrip.async = true;
                skrip.onload = muatModel;
                skrip.onerror = () => {
                    selesai();
                    reject(new Error('Pustaka deteksi wajah gagal dimuat.'));
                };
                document.head.appendChild(skrip);
            }).catch((e) => {
                this._pemuatFaceApi = null;
                throw e;
            });

            return this._pemuatFaceApi;
        },

        mulaiLoopDeteksi() {
            this.tutupDeteksi();
            this._intervalDeteksi = setInterval(() => this.jalankanDeteksi(), 400);
            this.jalankanDeteksi();
        },

        async jalankanDeteksi() {
            if (this._deteksiSibuk || ! this.kameraTerbuka || ! this.kameraSiap || ! this._detektor) {
                return;
            }
            const video = this.$refs.videoKamera;
            if (! video || video.readyState < 2 || ! video.videoWidth) {
                return;
            }

            this._deteksiSibuk = true;
            try {
                let jumlah = 0;
                if (this._detektor === 'faceapi') {
                    const faceapi = window.faceapi;
                    if (! faceapi) return;
                    const hasil = await faceapi.detectAllFaces(
                        video,
                        new faceapi.TinyFaceDetectorOptions({ inputSize: 224, scoreThreshold: 0.45 })
                    );
                    jumlah = Array.isArray(hasil) ? hasil.length : 0;
                } else {
                    const hasil = await this._detektor.detect(video);
                    jumlah = Array.isArray(hasil) ? hasil.length : 0;
                }
                this.jumlahWajah = jumlah;
                this.wajahTerdeteksi = jumlah > 0;
            } catch (e) {
                // Deteksi gagal pada frame ini; biarkan status terakhir.
            } finally {
                this._deteksiSibuk = false;
            }
        },

        ambilFoto() {
            if (! this.kameraSiap || this.izinKameraError) return;
            if (this.statusDeteksi === 'aktif' && ! this.wajahTerdeteksi) return;

            const video = this.$refs.videoKamera;
            const lebar = video?.videoWidth;
            const tinggi = video?.videoHeight;
            if (! lebar || ! tinggi) {
                this.fotoError = 'Kamera belum siap. Coba lagi sesaat.';
                return;
            }

            const kanvas = document.createElement('canvas');
            kanvas.width = lebar;
            kanvas.height = tinggi;
            const ctx = kanvas.getContext('2d');
            if (this.modeKamera === 'user') {
                ctx.translate(lebar, 0);
                ctx.scale(-1, 1);
            }
            ctx.drawImage(video, 0, 0, lebar, tinggi);

            kanvas.toBlob((blob) => {
                if (! blob) {
                    this.fotoError = 'Gagal mengambil foto. Coba lagi.';
                    return;
                }
                const file = new File([blob], 'absensi-' + Date.now() + '.jpg', { type: 'image/jpeg' });
                this.tutupKamera();
                this.$wire.upload('foto', file, () => {}, () => {
                    this.fotoError = 'Foto gagal diunggah. Periksa koneksi lalu coba lagi.';
                });
            }, 'image/jpeg', 0.9);
        },

        bukaKameraPerangkat() {
            this.tutupKamera();
            this.$nextTick(() => {
                if (this.$refs.kameraFallback) {
                    this.$refs.kameraFallback.click();
                }
            });
        },

        labelDeteksi() {
            if (this.izinKameraError) return 'Kamera tidak tersedia';
            if (this.statusDeteksi === 'memuat') return 'Menyiapkan deteksi wajah...';
            if (this.statusDeteksi === 'idle') return 'Menyiapkan kamera...';
            if (this.statusDeteksi === 'tidak-didukung') return 'Deteksi wajah tidak tersedia di perangkat ini';
            if (this.wajahTerdeteksi) {
                return this.jumlahWajah > 1
                    ? this.jumlahWajah + ' wajah terdeteksi — pastikan hanya Anda'
                    : 'Wajah terdeteksi';
            }
            return 'Posisikan wajah di dalam bingkai';
        },
    };
}

export function daftarkanAbsensiKamera() {
    window.absensiKamera = buatAbsensiKamera;
}
