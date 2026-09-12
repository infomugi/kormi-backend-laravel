import '../css/app.css';
import './bootstrap';
import { createIcons, icons } from 'lucide';
import flatpickr from 'flatpickr';
import { Indonesian } from 'flatpickr/dist/l10n/id.js';
import { compressImageClientSide } from './image-compressor';
import { markdownToHtml, htmlToMarkdown } from './markdown-converter';

window.flatpickr = flatpickr;
flatpickr.localize(Indonesian);
window.compressImageClientSide = compressImageClientSide;
window.markdownToHtml = markdownToHtml;
window.htmlToMarkdown = htmlToMarkdown;

window.kormiEditor = function(initialContent = '') {
    return {
        isFullscreen: false,
        editorMode: 'html', // 'visual', 'html', 'md', 'view', 'split'
        fontSize: 'text-sm', // 'text-xs', 'text-sm', 'text-base', 'text-lg'
        searchWord: '',
        showFindReplace: false,
        replaceWord: '',
        notifPasteMd: false,
        notifMessage: '',
        isUploadingImage: false,
        content: initialContent,

        init() {
            // Inisialisasi konten dari textarea jika ada
            const textareaEl = document.getElementById('textareaNaskahBerita');
            if (textareaEl && textareaEl.value) {
                this.content = textareaEl.value;
            }
        },

        syncFromVisual() {
            const visualEl = document.getElementById('visualEditorContainer');
            const textareaEl = document.getElementById('textareaNaskahBerita');
            if (visualEl) {
                this.content = visualEl.innerHTML;
                if (textareaEl) {
                    textareaEl.value = this.content;
                    textareaEl.dispatchEvent(new Event('input', { bubbles: true }));
                }
            }
        },

        syncToVisual() {
            const visualEl = document.getElementById('visualEditorContainer');
            const textareaEl = document.getElementById('textareaNaskahBerita');
            let currentVal = (textareaEl ? textareaEl.value : this.content) || this.content || '';

            if (typeof window.markdownToHtml === 'function') {
                const isRawMarkdown = /(^#{1,6}\s+|^\s*[-*+]\s+|^\s*\d+\.\s+|^\s*>\s+|\*\*|__|~~|\[.*?\]\(.*?\)|\|.*\|.*\|)/m.test(currentVal);
                if (isRawMarkdown) {
                    currentVal = window.markdownToHtml(currentVal);
                    this.content = currentVal;
                    if (textareaEl) {
                        textareaEl.value = currentVal;
                        textareaEl.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                }
            }

            if (visualEl) {
                visualEl.innerHTML = currentVal || '<p><br></p>';
            }
        },

        setMode(newMode) {
            const textareaEl = document.getElementById('textareaNaskahBerita');
            const oldMode = this.editorMode;

            // Jika berpindah DARI mode visual, sinkronkan perubahan HTML ke textarea & content
            if (oldMode === 'visual') {
                this.syncFromVisual();
            }

            let currentVal = (textareaEl ? textareaEl.value : this.content) || this.content || '';

            // 1. Berpindah DARI MD -> ke Mode HTML / Visual / View / Split
            if (oldMode === 'md' && (newMode === 'html' || newMode === 'visual' || newMode === 'view' || newMode === 'split')) {
                if (typeof window.markdownToHtml === 'function' && currentVal.trim()) {
                    currentVal = window.markdownToHtml(currentVal);
                    this.content = currentVal;
                    if (textareaEl) {
                        textareaEl.value = currentVal;
                        textareaEl.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                }
            }
            // 2. Berpindah DARI HTML/Visual -> ke Mode MD
            else if ((oldMode === 'html' || oldMode === 'visual' || oldMode === 'view' || oldMode === 'split') && newMode === 'md') {
                if (typeof window.htmlToMarkdown === 'function' && currentVal.trim()) {
                    currentVal = window.htmlToMarkdown(currentVal);
                    this.content = currentVal;
                    if (textareaEl) {
                        textareaEl.value = currentVal;
                        textareaEl.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                }
            }

            this.editorMode = newMode;

            // Jika berpindah KE mode visual, muat konten ke dalam visual container
            if (newMode === 'visual') {
                this.$nextTick(() => {
                    this.syncToVisual();
                });
                setTimeout(() => {
                    this.syncToVisual();
                }, 30);
            }
        },

        handlePaste(event) {
            const clipboardData = event.clipboardData || window.clipboardData;
            if (!clipboardData) return;
            
            const pastedText = clipboardData.getData('text');
            if (!pastedText) return;

            // Jika sedang dalam mode HTML, ubah markdown ke clean HTML secara otomatis
            if (this.editorMode === 'html' || this.editorMode === 'split') {
                const isMarkdown = /(^#{1,6}\s+|^\s*[-*+]\s+|^\s*\d+\.\s+|^\s*>\s+|\*\*|__|~~|\[.*?\]\(.*?\)|\|.*\|.*\|)/m.test(pastedText);

                if (isMarkdown && typeof window.markdownToHtml === 'function') {
                    event.preventDefault();
                    const cleanHtml = window.markdownToHtml(pastedText);
                    this.insertFormat('', '', cleanHtml);
                    
                    this.notifMessage = 'Teks Markdown berhasil dikonversi otomatis menjadi Clean HTML!';
                    this.notifPasteMd = true;
                    setTimeout(() => {
                        this.notifPasteMd = false;
                    }, 3500);
                }
            }
        },

        konversiKeHtmlBersih() {
            const el = document.getElementById('textareaNaskahBerita');
            if (!el || !el.value) return;
            if (typeof window.markdownToHtml === 'function') {
                el.value = window.markdownToHtml(el.value);
                el.dispatchEvent(new Event('input', { bubbles: true }));
                this.notifMessage = 'Naskah berhasil dibersihkan dan diformat menjadi Clean HTML!';
                this.notifPasteMd = true;
                setTimeout(() => {
                    this.notifPasteMd = false;
                }, 3000);
            }
        },

        toggleFullscreen() {
            this.isFullscreen = !this.isFullscreen;
            if (this.isFullscreen) {
                document.body.classList.add('overflow-hidden');
            } else {
                document.body.classList.remove('overflow-hidden');
            }
        },

        insertFormat(prefix, suffix = '', defaultText = '') {
            if (this.editorMode === 'visual') {
                const visualEl = document.getElementById('visualEditorContainer');
                if (visualEl) {
                    visualEl.focus();
                    if (prefix === '<strong>') {
                        document.execCommand('bold', false, null);
                    } else if (prefix === '<em>' || prefix === '*') {
                        document.execCommand('italic', false, null);
                    } else if (prefix === '<del>' || prefix === '~~') {
                        document.execCommand('strikeThrough', false, null);
                    } else if (prefix === '<mark>') {
                        const sel = window.getSelection();
                        if (sel && sel.rangeCount > 0) {
                            const range = sel.getRangeAt(0);
                            const selectedText = range.toString() || defaultText;
                            const markEl = document.createElement('mark');
                            markEl.className = 'bg-amber-200 px-1 py-0.5 rounded text-slate-900 font-semibold';
                            markEl.textContent = selectedText;
                            range.deleteContents();
                            range.insertNode(markEl);
                        }
                    } else {
                        const htmlToInsert = prefix + (window.getSelection()?.toString() || defaultText) + suffix;
                        document.execCommand('insertHTML', false, htmlToInsert);
                    }
                    this.syncFromVisual();
                }
                return;
            }

            const el = document.getElementById('textareaNaskahBerita');
            if (!el) return;
            const start = el.selectionStart;
            const end = el.selectionEnd;
            const text = el.value;
            const sel = text.substring(start, end) || defaultText;
            const replace = prefix + sel + suffix;
            
            el.focus();
            if (document.execCommand) {
                document.execCommand('insertText', false, replace);
            } else {
                el.value = text.substring(0, start) + replace + text.substring(end);
            }
            
            el.selectionStart = start + prefix.length;
            el.selectionEnd = start + prefix.length + sel.length;
            el.dispatchEvent(new Event('input', { bubbles: true }));
        },

        insertLineFormat(prefix, htmlTag = '') {
            if (this.editorMode === 'visual') {
                const visualEl = document.getElementById('visualEditorContainer');
                if (visualEl && htmlTag) {
                    visualEl.focus();
                    document.execCommand('formatBlock', false, `<${htmlTag}>`);
                    this.syncFromVisual();
                }
                return;
            }

            const el = document.getElementById('textareaNaskahBerita');
            if (!el) return;
            const start = el.selectionStart;
            const end = el.selectionEnd;
            const text = el.value;
            
            if (this.editorMode === 'html' && htmlTag) {
                const sel = text.substring(start, end) || 'Teks Judul';
                this.insertFormat(`<${htmlTag}>`, `</${htmlTag}>`, sel);
                return;
            }

            const prevNewline = text.lastIndexOf('\n', start - 1);
            const lineStart = prevNewline === -1 ? 0 : prevNewline + 1;
            
            const before = text.substring(0, lineStart);
            const currentLineAndRest = text.substring(lineStart);
            
            el.value = before + prefix + currentLineAndRest;
            el.focus();
            el.selectionStart = start + prefix.length;
            el.selectionEnd = end + prefix.length;
            el.dispatchEvent(new Event('input', { bubbles: true }));
        },

        insertList(type = 'ul') {
            if (this.editorMode === 'visual') {
                const visualEl = document.getElementById('visualEditorContainer');
                if (visualEl) {
                    visualEl.focus();
                    const cmd = type === 'ol' ? 'insertOrderedList' : 'insertUnorderedList';
                    document.execCommand(cmd, false, null);
                    this.syncFromVisual();
                }
                return;
            }

            if (this.editorMode === 'html') {
                const tag = type === 'ol' ? 'ol' : 'ul';
                this.insertFormat(`<${tag}>\n  <li>`, `</li>\n</${tag}>`, 'Poin Daftar');
            } else {
                const prefix = type === 'ol' ? '1. ' : '- ';
                this.insertLineFormat(prefix);
            }
        },

        insertDivider() {
            if (this.editorMode === 'visual') {
                const visualEl = document.getElementById('visualEditorContainer');
                if (visualEl) {
                    visualEl.focus();
                    document.execCommand('insertHorizontalRule', false, null);
                    this.syncFromVisual();
                }
                return;
            }

            if (this.editorMode === 'html') {
                this.insertFormat('\n<hr class="my-6 border-slate-200">\n');
            } else {
                this.insertFormat('\n\n---\n\n');
            }
        },

        insertTable() {
            const sampleHtmlTable = '\n<table class="w-full text-left text-sm border-collapse my-4">\n  <thead>\n    <tr class="bg-slate-100 font-bold">\n      <th class="px-3 py-2 border">No</th>\n      <th class="px-3 py-2 border">Agenda / Kegiatan</th>\n      <th class="px-3 py-2 border">Lokasi</th>\n    </tr>\n  </thead>\n  <tbody>\n    <tr>\n      <td class="px-3 py-2 border">1</td>\n      <td class="px-3 py-2 border">Upacara Pembukaan</td>\n      <td class="px-3 py-2 border">Stadion Si Jalak Harupat</td>\n    </tr>\n  </tbody>\n</table>\n\n';

            if (this.editorMode === 'visual') {
                const visualEl = document.getElementById('visualEditorContainer');
                if (visualEl) {
                    visualEl.focus();
                    document.execCommand('insertHTML', false, sampleHtmlTable);
                    this.syncFromVisual();
                }
                return;
            }

            if (this.editorMode === 'html') {
                this.insertFormat('', '', sampleHtmlTable);
            } else {
                const sampleTable = '\n| No | Nama Agenda / Kegiatan | Keterangan / Lokasi |\n|---|---|---|\n| 1 | Upacara Pembukaan Kejuaraan | Stadion Si Jalak Harupat |\n| 2 | Perlombaan Olahraga Tradisional | Lapangan KORMI Kab. Bandung |\n| 3 | Penyerahan Medali & Piagam | Gedung Budaya Sabilulungan |\n\n';
                this.insertFormat('', '', sampleTable);
            }
        },

        insertCallout(type = 'info') {
            if (this.editorMode === 'visual' || this.editorMode === 'html') {
                const quoteHtml = '<blockquote class="border-l-4 border-emerald-500 bg-emerald-50 p-4 italic my-4">\n  "Kutipan pernyataan narasumber..."\n  <footer class="text-xs font-bold text-slate-500 mt-2">— Nama Narasumber / Tokoh</footer>\n</blockquote>';
                const infoHtml = '<div class="p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-900 my-4">\n  <strong>ℹ️ INFORMASI:</strong> Tulis rincian informasi di sini...\n</div>';
                const htmlToInsert = type === 'quote' ? quoteHtml : infoHtml;

                if (this.editorMode === 'visual') {
                    const visualEl = document.getElementById('visualEditorContainer');
                    if (visualEl) {
                        visualEl.focus();
                        document.execCommand('insertHTML', false, htmlToInsert);
                        this.syncFromVisual();
                    }
                    return;
                }
                this.insertFormat('', '', htmlToInsert);
                return;
            }

            let icon = 'ℹ️';
            let title = 'INFORMASI PENTING';
            if (type === 'quote') {
                this.insertFormat('> ', '\n\n*— Kutipan Tokoh / Narasumber*');
                return;
            }
            if (type === 'alert') {
                icon = '⚠️';
                title = 'PERHATIAN / CATATAN KHUSUS';
            }
            const callout = `\n> ${icon} **${title}**\n> Tulis rincian pesan atau catatan penting di sini...\n\n`;
            this.insertFormat('', '', callout);
        },

        insertLink() {
            const url = prompt('Masukkan URL Tautan Web:', 'https://');
            if (!url) return;

            if (this.editorMode === 'visual') {
                const visualEl = document.getElementById('visualEditorContainer');
                if (visualEl) {
                    visualEl.focus();
                    document.execCommand('createLink', false, url);
                    this.syncFromVisual();
                }
                return;
            }

            if (this.editorMode === 'html') {
                this.insertFormat(`<a href="${url}" target="_blank" rel="noopener noreferrer" class="text-emerald-700 underline font-semibold">`, '</a>', 'Teks Tautan');
            } else {
                this.insertFormat('[', `](${url})`, 'Teks Tautan');
            }
        },

        triggerImageUpload() {
            const input = document.getElementById('inputUploadFotoArtikel');
            if (input) {
                input.click();
            }
        },

        async handleDirectImageUpload(event) {
            const file = event.target.files && event.target.files[0];
            if (!file) return;

            // Validate image
            if (!file.type.startsWith('image/')) {
                alert('Silakan pilih berkas gambar yang valid (JPG, PNG, WEBP).');
                return;
            }

            this.isUploadingImage = true;
            const caption = prompt('Masukkan Keterangan / Caption Gambar (Opsional):', file.name.replace(/\.[^/.]+$/, "")) || 'Dokumentasi KORMI Kab. Bandung';

            try {
                const formData = new FormData();
                formData.append('foto', file);

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                  document.querySelector('input[name="_token"]')?.value;

                const response = await fetch('/admin/berita/upload-foto-konten', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.success && result.url) {
                    const imgHtml = `\n<figure class="my-6 text-center">\n  <img src="${result.url}" alt="${caption}" class="w-full rounded-2xl shadow-md border border-slate-100 object-cover">\n  <figcaption class="text-xs text-slate-500 mt-2 italic">Foto: ${caption}</figcaption>\n</figure>\n`;
                    
                    if (this.editorMode === 'md') {
                        const mdImg = `\n![${caption}](${result.url})\n*Foto: ${caption}*\n\n`;
                        this.insertFormat('', '', mdImg);
                    } else if (this.editorMode === 'visual') {
                        const visualEl = document.getElementById('visualEditorContainer');
                        if (visualEl) {
                            visualEl.focus();
                            document.execCommand('insertHTML', false, imgHtml);
                            this.syncFromVisual();
                        } else {
                            this.insertFormat('', '', imgHtml);
                        }
                    } else {
                        this.insertFormat('', '', imgHtml);
                    }

                    this.notifMessage = 'Foto berhasil diunggah ke storage dan disematkan ke naskah artikel!';
                    this.notifPasteMd = true;
                    setTimeout(() => { this.notifPasteMd = false; }, 3500);
                } else {
                    alert('Gagal mengunggah foto: ' + (result.message || 'Terjadi kesalahan'));
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan saat mengunggah foto ke server.');
            } finally {
                this.isUploadingImage = false;
                event.target.value = ''; // Reset input file
            }
        },

        insertEmbedImage() {
            const pilihan = confirm("Pilih 'OK' untuk UPLOAD FOTO dari Komputer (Otomatis ke Storage),\natau 'Cancel' untuk memasukkan URL Web Gambar Eksternal?");
            if (pilihan) {
                this.triggerImageUpload();
            } else {
                const url = prompt('Masukkan URL Gambar / Dokumentasi Eksternal:', 'https://');
                if (url) {
                    const caption = prompt('Masukkan Keterangan Gambar:', 'Dokumentasi KORMI Kab. Bandung') || 'Dokumentasi KORMI';
                    if (this.editorMode === 'html' || this.editorMode === 'visual') {
                        this.insertFormat(`\n<figure class="my-6 text-center"><img src="${url}" alt="${caption}" class="w-full rounded-2xl shadow-md border border-slate-100"><figcaption class="text-xs text-slate-500 mt-2 italic">Foto: ${caption}</figcaption></figure>\n`);
                    } else {
                        this.insertFormat(`\n![${caption}](${url})\n*Foto: ${caption}*\n\n`);
                    }
                }
            }
        },

        findAndReplaceAll() {
            if (!this.searchWord) return;
            const el = document.getElementById('textareaNaskahBerita');
            if (!el) return;
            const regex = new RegExp(this.searchWord, 'gi');
            el.value = el.value.replace(regex, this.replaceWord);
            el.dispatchEvent(new Event('input', { bubbles: true }));
        },

        bersihkanFormat() {
            if (!confirm('Bersihkan tag/formatting khusus dari teks?')) return;
            const el = document.getElementById('textareaNaskahBerita');
            if (!el) return;
            const start = el.selectionStart;
            const end = el.selectionEnd;
            const text = el.value;
            
            if (start !== end) {
                let sel = text.substring(start, end);
                sel = sel.replace(/<[^>]*>?/gm, '').replace(/[\*_~`#]/g, '');
                el.value = text.substring(0, start) + sel + text.substring(end);
            } else {
                el.value = text.replace(/<[^>]*>?/gm, '').replace(/[\*_~`#]/g, '');
            }
            el.dispatchEvent(new Event('input', { bubbles: true }));
        }
    };
};

window.createLucideIcons = () => {
    try {
        createIcons({ icons });
    } catch (e) {
        // Safe catch
    }
};

let initTimer = null;
const initIcons = () => {
    window.createLucideIcons();
};

// 1. Initial DOM & Livewire SPA Navigation Hooks
document.addEventListener('DOMContentLoaded', initIcons);
document.addEventListener('livewire:navigated', () => {
    window.createLucideIcons();
    if (window.location.hash) {
        const target = document.querySelector(window.location.hash);
        if (target) target.scrollIntoView({ behavior: 'smooth' });
    }
});

// 2. Livewire 3 Morph & Commit Hooks
document.addEventListener('livewire:initialized', () => {
    initIcons();

    Livewire.hook('commit', ({ succeed }) => {
        succeed(() => {
            initIcons();
        });
    });

    // Prevent automatic reload loops and default alert dialogs on temporary request failures
    Livewire.hook('request', ({ fail }) => {
        fail(({ status, preventDefault }) => {
            if (status === 419) {
                preventDefault(); // Suppress the default Livewire "Page Expired" alert dialog
                console.warn('[Livewire] Sesi / CSRF token 419 diabaikan agar input tidak terganggu.');
            }
        });
    });
});
