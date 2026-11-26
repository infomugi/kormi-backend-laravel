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
        _tokenStream: 0,
        _detektor: null,
        _pemuatFaceApi: null,
        _skripFaceApi: null,
        _intervalDeteksi: null,
        _deteksiSibuk: false,
        _tokenDetektor: 0,
        _gagalDeteksi: 0,
        _deteksiPeringatanTampil: false,
        _deteksiDimatikan: false,
        _membukaKamera: false,
        _sedangAmbilFoto: false,
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
            if (window.compressImageClientSide) {
                try {
                    const terkompres = await window.compressImageClientSide(file, { maxSizeMB: 1, maxWidthOrHeight: 1600, initialQuality: 0.85 });
                    if (terkompres) {
                        hasil = terkompres;
                    }
                } catch (e) {
                    hasil = file;
                }
            }
            this.$wire.upload('foto', hasil, () => {}, () => {
                this.fotoError = 'Foto gagal diunggah. Periksa koneksi lalu coba lagi.';
            });
        },

        // ---------- Kamera langsung ----------
        async bukaKamera() {
            // Cegah pemanggilan ganda (mis. klik beruntun atau overlay/stream masih aktif).
            if (this._membukaKamera || (this.kameraTerbuka && this.kameraSiap)) {
                return;
            }

            this._membukaKamera = true;
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

            try {
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
            } finally {
                this._membukaKamera = false;
            }
        },

        async mulaiStream() {
            const tokenStream = ++this._tokenStream;
            this.hentikanStream();

            let stream;
            const permintaan = navigator.mediaDevices.getUserMedia({
                audio: false,
                video: {
                    facingMode: this.modeKamera,
                    width: { ideal: 960 },
                    height: { ideal: 1280 },
                },
            });
            try {
                // Batasi getUserMedia agar tidak menggantung tanpa batas.
                stream = await this._batasiWaktu(permintaan, 10000);
            } catch (e) {
                if (e && e.name === 'TimeoutError') {
                    // Bila kamera akhirnya menyala setelah batas waktu, langsung matikan agar tidak menggantung.
                    permintaan
                        .then((s) => s.getTracks().forEach((track) => track.stop()))
                        .catch(() => {});
                    if (tokenStream === this._tokenStream) {
                        this.kameraSiap = false;
                        this.statusDeteksi = 'idle';
                        this.izinKameraError = 'Kamera tidak merespons. Tutup lalu coba lagi, atau gunakan kamera perangkat.';
                    }
                    return;
                }
                throw e;
            }

            // Overlay bisa saja sudah ditutup (atau permintaan lebih baru dimulai) selagi menunggu izin.
            if (tokenStream !== this._tokenStream || ! this.kameraTerbuka) {
                stream.getTracks().forEach((track) => track.stop());
                return;
            }

            this._stream = stream;

            const video = this.$refs.videoKamera;
            if (! video) {
                // Jangan berhenti senyap: matikan stream dan beri tahu pengguna.
                this.hentikanStream();
                this.statusDeteksi = 'idle';
                this.izinKameraError = 'Pratinjau kamera tidak tersedia. Gunakan kamera perangkat.';
                return;
            }

            video.srcObject = this._stream;

            if (video.readyState >= 1) {
                await this.siapkanVideo(video, tokenStream);
            } else {
                await new Promise((resolve) => {
                    video.onloadedmetadata = resolve;
                    setTimeout(resolve, 2500);
                });
                await this.siapkanVideo(video, tokenStream);
            }
        },

        async siapkanVideo(video, tokenStream) {
            let diputar = false;
            try {
                await this._batasiWaktu(video.play(), 3000);
                diputar = true;
            } catch (e) {
                diputar = false;
            }

            // Bila overlay sudah ditutup atau ada permintaan stream yang lebih baru, jangan lanjutkan.
            if (! this.kameraTerbuka || tokenStream !== this._tokenStream) {
                return;
            }

            if (! diputar || video.readyState < 2 || ! video.videoWidth) {
                this.kameraSiap = false;
                this.izinKameraError = 'Pratinjau kamera tidak dapat ditampilkan. Tutup lalu coba lagi, atau gunakan kamera perangkat.';
                return;
            }

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
            // Lepas guard & batalkan permintaan stream/persiapan detektor yang mungkin masih berjalan.
            this._membukaKamera = false;
            this._tokenStream += 1;
            this._tokenDetektor += 1;
            this._kunciScroll(false);
            this.tutupDeteksi();
            this.hentikanStream();
            this._detektor = null;
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
            const token = ++this._tokenDetektor;
            this.statusDeteksi = 'memuat';
            this._detektor = null;
            this._gagalDeteksi = 0;
            this._deteksiPeringatanTampil = false;
            this._deteksiDimatikan = false;

            const gagalTotal = () => {
                if (token !== this._tokenDetektor) return;
                this._detektor = null;
                this.statusDeteksi = 'tidak-didukung';
                this.wajahTerdeteksi = false;
                this.jumlahWajah = 0;
                this._peringatkanDeteksiSekali();
            };

            // Batas waktu total ±4 detik: jangan biarkan status menggantung di 'memuat'.
            const batas = setTimeout(() => {
                if (token === this._tokenDetektor && this.statusDeteksi === 'memuat') {
                    gagalTotal();
                }
            }, 4000);

            // 1) Detektor bawaan browser — verifikasi dengan satu siklus detect nyata.
            if ('FaceDetector' in window) {
                try {
                    const probe = new window.FaceDetector({ fastMode: true, maxDetectedFaces: 2 });
                    const kanvas = document.createElement('canvas');
                    kanvas.width = 64;
                    kanvas.height = 64;
                    kanvas.getContext('2d').fillRect(0, 0, 64, 64);
                    // Konstruktor bisa sukses walau platform tidak mendukung; detect() yang menolak
                    // (atau menggantung) dan wajib dibatasi waktu.
                    await this._batasiWaktu(probe.detect(kanvas), 2500);
                    clearTimeout(batas);
                    if (token !== this._tokenDetektor || this.statusDeteksi !== 'memuat') return;
                    this._detektor = probe;
                    this.statusDeteksi = 'aktif';
                    this.mulaiLoopDeteksi();
                    return;
                } catch (e) {
                    // NotSupportedError / platform tidak tersedia -> fallback face-api.
                }
            }

            // 2) Fallback face-api (CDN) — probe juga agar 'aktif' hanya bila benar-benar berjalan.
            try {
                const faceapi = await this.muatFaceApi();
                if (token !== this._tokenDetektor || this.statusDeteksi !== 'memuat') {
                    clearTimeout(batas);
                    return;
                }
                const kanvas = document.createElement('canvas');
                kanvas.width = 128;
                kanvas.height = 128;
                kanvas.getContext('2d').fillRect(0, 0, 128, 128);
                await this._batasiWaktu(
                    faceapi.detectAllFaces(kanvas, new faceapi.TinyFaceDetectorOptions({ inputSize: 224, scoreThreshold: 0.45 })),
                    1500
                );
                clearTimeout(batas);
                if (token !== this._tokenDetektor || this.statusDeteksi !== 'memuat') return;
                this._detektor = 'faceapi';
                this.statusDeteksi = 'aktif';
                this.mulaiLoopDeteksi();
            } catch (e) {
                clearTimeout(batas);
                gagalTotal();
            }
        },

        muatFaceApi() {
            if (window.faceapi && window.faceapi.nets?.tinyFaceDetector?.isLoaded) {
                return Promise.resolve(window.faceapi);
            }
            // Sudah ada pemuatan berjalan (termasuk elemen <script> yang masih dimuat): jangan append ganda.
            if (this._pemuatFaceApi) {
                return this._pemuatFaceApi;
            }

            this._pemuatFaceApi = new Promise((resolve, reject) => {
                const bersihkanSkrip = () => {
                    if (this._skripFaceApi) {
                        this._skripFaceApi.remove();
                        this._skripFaceApi = null;
                    }
                };

                const batas = setTimeout(() => {
                    bersihkanSkrip();
                    reject(new Error('Batas waktu pemuatan detektor wajah terlampaui.'));
                }, 15000);
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
                        bersihkanSkrip();
                        reject(e);
                    }
                };

                const skrip = document.createElement('script');
                skrip.src = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api@1.7.15/dist/face-api.min.js';
                skrip.async = true;
                skrip.onload = () => {
                    muatModel();
                };
                skrip.onerror = () => {
                    selesai();
                    bersihkanSkrip();
                    reject(new Error('Pustaka deteksi wajah gagal dimuat.'));
                };
                this._skripFaceApi = skrip;
                document.head.appendChild(skrip);
            }).catch((e) => {
                this._pemuatFaceApi = null;
                throw e;
            });

            return this._pemuatFaceApi;
        },

        mulaiLoopDeteksi() {
            this.tutupDeteksi();
            this._gagalDeteksi = 0;
            this._intervalDeteksi = setInterval(() => this.jalankanDeteksi(), 400);
            this.jalankanDeteksi();
        },

        _batasiWaktu(promise, ms, pesan = 'Batas waktu operasi terlampaui.') {
            let timer;
            const batas = new Promise((_, reject) => {
                timer = setTimeout(() => {
                    const galat = new Error(pesan);
                    galat.name = 'TimeoutError';
                    reject(galat);
                }, ms);
            });
            return Promise.race([promise, batas]).finally(() => clearTimeout(timer));
        },

        async jalankanDeteksi() {
            if (this._deteksiSibuk || ! this.kameraTerbuka || ! this.kameraSiap || ! this._detektor) {
                return;
            }
            if (this.statusDeteksi !== 'aktif') {
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
                    if (! faceapi) {
                        this._catatGagalDeteksi();
                        return;
                    }
                    const hasil = await this._batasiWaktu(
                        faceapi.detectAllFaces(
                            video,
                            new faceapi.TinyFaceDetectorOptions({ inputSize: 224, scoreThreshold: 0.45 })
                        ),
                        1500
                    );
                    jumlah = Array.isArray(hasil) ? hasil.length : 0;
                } else {
                    const hasil = await this._batasiWaktu(this._detektor.detect(video), 1500);
                    jumlah = Array.isArray(hasil) ? hasil.length : 0;
                }
                this._gagalDeteksi = 0;
                this.jumlahWajah = jumlah;
                this.wajahTerdeteksi = jumlah > 0;
            } catch (e) {
                // Timeout frame bukan kegagalan permanen: lewati frame ini saja.
                if (! (e && e.name === 'TimeoutError')) {
                    this._catatGagalDeteksi();
                }
            } finally {
                this._deteksiSibuk = false;
            }
        },

        _peringatkanDeteksiSekali() {
            if (this._deteksiPeringatanTampil) {
                return;
            }
            this._deteksiPeringatanTampil = true;
            console.warn('[Absensi] Deteksi wajah tidak tersedia. Absensi tetap dapat dilanjutkan tanpa deteksi wajah.');
        },

        _catatGagalDeteksi() {
            this._gagalDeteksi += 1;
            if (this._gagalDeteksi < 3) {
                return;
            }
            if (this._intervalDeteksi) {
                clearInterval(this._intervalDeteksi);
                this._intervalDeteksi = null;
            }
            this._detektor = null;
            this._deteksiDimatikan = true;
            this.statusDeteksi = 'tidak-didukung';
            this.wajahTerdeteksi = false;
            this.jumlahWajah = 0;
            this._peringatkanDeteksiSekali();
        },

        _kanvasKeBlob(kanvas) {
            return new Promise((resolve) => {
                let selesai = false;
                const lewatDataUrl = () => {
                    if (selesai) {
                        return;
                    }
                    selesai = true;
                    try {
                        const dataUrl = kanvas.toDataURL('image/jpeg', 0.9);
                        const biner = atob((dataUrl.split(',')[1] || ''));
                        const buffer = new Uint8Array(biner.length);
                        for (let i = 0; i < biner.length; i++) {
                            buffer[i] = biner.charCodeAt(i);
                        }
                        resolve(new Blob([buffer], { type: 'image/jpeg' }));
                    } catch (e) {
                        resolve(null);
                    }
                };

                // toBlob dapat menggantung/null pada sebagian perangkat; fallback ke data URL.
                const batas = setTimeout(lewatDataUrl, 1200);
                try {
                    kanvas.toBlob((blob) => {
                        if (selesai) {
                            return;
                        }
                        clearTimeout(batas);
                        if (blob) {
                            selesai = true;
                            resolve(blob);
                        } else {
                            lewatDataUrl();
                        }
                    }, 'image/jpeg', 0.9);
                } catch (e) {
                    clearTimeout(batas);
                    lewatDataUrl();
                }
            });
        },

        async ambilFoto() {
            if (this._sedangAmbilFoto) {
                return;
            }
            this.fotoError = '';

            if (this.izinKameraError) {
                this.fotoError = this.izinKameraError;
                return;
            }
            if (! this.kameraSiap) {
                this.fotoError = 'Kamera belum siap. Tunggu sebentar lalu coba lagi.';
                return;
            }

            const video = this.$refs.videoKamera;
            const lebar = video?.videoWidth;
            const tinggi = video?.videoHeight;
            if (! lebar || ! tinggi) {
                this.fotoError = 'Kamera belum siap. Coba lagi sesaat.';
                return;
            }

            this._sedangAmbilFoto = true;
            try {
                const kanvas = document.createElement('canvas');
                kanvas.width = lebar;
                kanvas.height = tinggi;
                const ctx = kanvas.getContext('2d');
                if (this.modeKamera === 'user') {
                    ctx.translate(lebar, 0);
                    ctx.scale(-1, 1);
                }
                ctx.drawImage(video, 0, 0, lebar, tinggi);

                const blob = await this._kanvasKeBlob(kanvas);
                if (! blob) {
                    this.fotoError = 'Gagal mengambil foto. Coba lagi.';
                    return;
                }

                const file = new File([blob], 'absensi-' + Date.now() + '.jpg', { type: 'image/jpeg' });
                this.tutupKamera();

                // Normalkan hasil kamera (≤ 1 MB / 1600 px); bila gagal, unggah apa adanya.
                let berkas = file;
                if (window.compressImageClientSide) {
                    try {
                        const terkompres = await window.compressImageClientSide(file, { maxSizeMB: 1, maxWidthOrHeight: 1600, initialQuality: 0.85 });
                        if (terkompres) {
                            berkas = terkompres;
                        }
                    } catch (e) {
                        berkas = file;
                    }
                }

                this.$wire.upload('foto', berkas, () => {}, () => {
                    this.fotoError = 'Foto gagal diunggah. Periksa koneksi lalu coba lagi.';
                });
            } catch (e) {
                this.fotoError = 'Gagal mengambil foto. Coba lagi.';
            } finally {
                this._sedangAmbilFoto = false;
            }
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
            if (this.statusDeteksi === 'tidak-didukung') {
                return this._deteksiDimatikan
                    ? 'Deteksi wajah dinonaktifkan agar kamera tetap lancar'
                    : 'Deteksi wajah tidak tersedia di perangkat ini';
            }
            if (this.wajahTerdeteksi) {
                return this.jumlahWajah > 1
                    ? this.jumlahWajah + ' wajah terdeteksi — pastikan hanya Anda'
                    : 'Wajah terdeteksi';
            }
            return 'Wajah belum terdeteksi — Anda tetap bisa memotret';
        },
    };
}

export function daftarkanAbsensiKamera() {
    window.absensiKamera = buatAbsensiKamera;
}
