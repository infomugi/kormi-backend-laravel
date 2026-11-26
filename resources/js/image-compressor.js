/**
 * Client-Side Image Compressor using HTML5 Canvas.
 *
 * Target default: maksimal 1 MB dengan sisi terpanjang 1600 px.
 * Selalu "best effort": fungsi ini tidak pernah melempar error. Bila berkas
 * tidak perlu/tidak bisa diproses, objek File asli dikembalikan apa adanya
 * sehingga pemanggil dapat membandingkan referensi untuk tahu ada kompresi.
 */

const TIPE_DILEWATI = new Set([
    'image/svg+xml',
    'image/gif',
    'image/x-icon',
    'image/vnd.microsoft.icon',
    'image/heic',
    'image/heif',
]);

const EKSTENSI_DILEWATI = /\.(svg|gif|ico|heic|heif)$/i;

function berkasDilewati(file) {
    const tipe = (file.type || '').toLowerCase();
    const nama = (file.name || '').toLowerCase();

    if (! tipe.startsWith('image/')) {
        return true;
    }
    if (TIPE_DILEWATI.has(tipe)) {
        return true;
    }
    return EKSTENSI_DILEWATI.test(nama);
}

async function dekodeGambar(file) {
    if (typeof createImageBitmap === 'function') {
        try {
            const bitmap = await createImageBitmap(file, { imageOrientation: 'from-image' });
            return {
                sumber: bitmap,
                lebar: bitmap.width,
                tinggi: bitmap.height,
                lepas: () => {
                    if (typeof bitmap.close === 'function') {
                        bitmap.close();
                    }
                },
            };
        } catch (e) {
            // Fallback ke elemen Image di bawah.
        }
    }

    const url = URL.createObjectURL(file);
    try {
        const gambar = await new Promise((resolve, reject) => {
            const el = new Image();
            el.onload = () => resolve(el);
            el.onerror = () => reject(new Error('Gambar tidak dapat didekode.'));
            el.src = url;
        });
        return {
            sumber: gambar,
            lebar: gambar.naturalWidth || gambar.width,
            tinggi: gambar.naturalHeight || gambar.height,
            lepas: () => URL.revokeObjectURL(url),
        };
    } catch (e) {
        URL.revokeObjectURL(url);
        throw e;
    }
}

function punyaKanalAlpha(sumber) {
    try {
        const sisi = 64;
        const kanvas = document.createElement('canvas');
        kanvas.width = sisi;
        kanvas.height = sisi;
        const ctx = kanvas.getContext('2d', { willReadFrequently: true });
        if (! ctx) {
            return false;
        }
        ctx.drawImage(sumber, 0, 0, sisi, sisi);
        const data = ctx.getImageData(0, 0, sisi, sisi).data;
        for (let i = 3; i < data.length; i += 4) {
            if (data[i] < 250) {
                return true;
            }
        }
    } catch (e) {
        // Anggap tanpa alpha bila pemeriksaan gagal.
    }
    return false;
}

function kanvasKeBlob(kanvas, tipe, kualitas) {
    return new Promise((resolve) => {
        const lewatDataUrl = () => {
            try {
                const dataUrl = kanvas.toDataURL(tipe, kualitas);
                const biner = atob(dataUrl.split(',')[1] || '');
                const buffer = new Uint8Array(biner.length);
                for (let i = 0; i < biner.length; i++) {
                    buffer[i] = biner.charCodeAt(i);
                }
                resolve(new Blob([buffer], { type: tipe }));
            } catch (e) {
                resolve(null);
            }
        };

        try {
            kanvas.toBlob((blob) => {
                if (blob) {
                    resolve(blob);
                } else {
                    lewatDataUrl();
                }
            }, tipe, kualitas);
        } catch (e) {
            lewatDataUrl();
        }
    });
}

function renderKanvas(sumber, lebar, tinggi, tipe, kualitas) {
    try {
        const kanvas = document.createElement('canvas');
        kanvas.width = Math.max(1, Math.round(lebar));
        kanvas.height = Math.max(1, Math.round(tinggi));
        const ctx = kanvas.getContext('2d');
        if (! ctx) {
            return Promise.resolve(null);
        }
        ctx.imageSmoothingEnabled = true;
        ctx.imageSmoothingQuality = 'high';
        ctx.drawImage(sumber, 0, 0, kanvas.width, kanvas.height);
        return kanvasKeBlob(kanvas, tipe, kualitas);
    } catch (e) {
        return Promise.resolve(null);
    }
}

/**
 * @param {File} file
 * @param {Object} options
 * @returns {Promise<File>} File terkompresi, atau file asli bila tidak perlu/gagal.
 */
export async function compressImageClientSide(file, options = {}) {
    const {
        maxSizeMB = 1,
        maxWidthOrHeight = 1600,
        initialQuality = 0.85,
        minQuality = 0.6,
    } = options;

    if (! file) {
        return file;
    }
    if (berkasDilewati(file)) {
        return file;
    }

    const maxSizeBytes = Math.max(1, maxSizeMB) * 1024 * 1024;
    const sisiMaks = Math.max(1, maxWidthOrHeight);

    let hasilDekode;
    try {
        hasilDekode = await dekodeGambar(file);
    } catch (e) {
        return file;
    }

    const { sumber, lebar: lebarAsli, tinggi: tinggiAsli, lepas } = hasilDekode;

    try {
        if (! lebarAsli || ! tinggiAsli) {
            return file;
        }

        const sisiTerpanjang = Math.max(lebarAsli, tinggiAsli);

        // Sudah memenuhi kedua syarat: ukuran file dan dimensi.
        if (file.size <= maxSizeBytes && sisiTerpanjang <= sisiMaks) {
            return file;
        }

        const jenisPng = (file.type || '').toLowerCase() === 'image/png';
        // PNG hanya dipertahankan bila punya kanal alpha; selain itu JPEG.
        const tipeKeluaran = (jenisPng && punyaKanalAlpha(sumber)) ? 'image/png' : 'image/jpeg';

        const skalaAwal = Math.min(1, sisiMaks / sisiTerpanjang);
        let lebar = Math.max(1, Math.round(lebarAsli * skalaAwal));
        let tinggi = Math.max(1, Math.round(tinggiAsli * skalaAwal));
        let kualitas = Math.min(1, Math.max(minQuality, initialQuality));

        let blobTerbaik = null;
        let putaran = 0;

        while (putaran < 24) {
            putaran += 1;
            const blob = await renderKanvas(
                sumber,
                lebar,
                tinggi,
                tipeKeluaran,
                tipeKeluaran === 'image/jpeg' ? kualitas : undefined
            );
            if (! blob) {
                break;
            }
            if (! blobTerbaik || blob.size < blobTerbaik.size) {
                blobTerbaik = blob;
            }
            if (blob.size <= maxSizeBytes) {
                blobTerbaik = blob;
                break;
            }

            // Turunkan kualitas JPEG bertahap sampai minQuality.
            if (tipeKeluaran === 'image/jpeg' && kualitas > minQuality + 0.001) {
                kualitas = Math.max(minQuality, Math.round((kualitas - 0.05) * 100) / 100);
                continue;
            }

            // Masih terlalu besar: turunkan dimensi bertahap, berhenti di 800 px.
            if (Math.max(lebar, tinggi) <= 800) {
                break;
            }
            lebar = Math.max(1, Math.round(lebar * 0.85));
            tinggi = Math.max(1, Math.round(tinggi * 0.85));
            kualitas = Math.min(1, Math.max(minQuality, initialQuality));
        }

        if (! blobTerbaik) {
            return file;
        }

        const ekstensi = tipeKeluaran === 'image/png' ? 'png' : 'jpg';
        const namaDasar = ((file.name || 'gambar').replace(/\.[^./\\]+$/, '') || 'gambar');
        const namaBaru = namaDasar + '.' + ekstensi;

        return new File([blobTerbaik], namaBaru, {
            type: tipeKeluaran,
            lastModified: Date.now(),
        });
    } catch (e) {
        return file;
    } finally {
        if (typeof lepas === 'function') {
            try {
                lepas();
            } catch (e) {
                // abaikan
            }
        }
    }
}
