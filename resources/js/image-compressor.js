/**
 * Client-Side Image Compressor using HTML5 Canvas
 * @param {File} file - Original Image File
 * @param {Object} options - Compression Options
 * @returns {Promise<File>} Compressed File
 */
export async function compressImageClientSide(file, options = {}) {
    const {
        maxSizeMB = 2,
        maxWidthOrHeight = 1920,
        initialQuality = 0.85,
        minQuality = 0.6,
    } = options;

    const maxSizeBytes = maxSizeMB * 1024 * 1024;

    // If file is not an image or already smaller than target size, return directly
    if (!file.type.startsWith('image/') || file.size <= maxSizeBytes) {
        return file;
    }

    // Don't attempt to compress SVG or GIF (to preserve animation)
    if (file.type === 'image/svg+xml' || file.type === 'image/gif') {
        return file;
    }

    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onload = (event) => {
            const img = new Image();
            img.src = event.target.result;

            img.onload = () => {
                let width = img.width;
                let height = img.height;

                // Scale down dimensions if greater than maxWidthOrHeight
                if (width > height) {
                    if (width > maxWidthOrHeight) {
                        height = Math.round((height * maxWidthOrHeight) / width);
                        width = maxWidthOrHeight;
                    }
                } else {
                    if (height > maxWidthOrHeight) {
                        width = Math.round((width * maxWidthOrHeight) / height);
                        height = maxWidthOrHeight;
                    }
                }

                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;

                const ctx = canvas.getContext('2d');
                ctx.imageSmoothingEnabled = true;
                ctx.imageSmoothingQuality = 'high';
                ctx.drawImage(img, 0, 0, width, height);

                // Convert to WebP / JPEG
                const outputFormat = file.type === 'image/png' ? 'image/png' : 'image/jpeg';

                const attemptCompression = (quality) => {
                    canvas.toBlob(
                        (blob) => {
                            if (!blob) {
                                resolve(file);
                                return;
                            }

                            // If still bigger than maxSizeBytes and quality is above min, compress further
                            if (blob.size > maxSizeBytes && quality > minQuality) {
                                attemptCompression(quality - 0.1);
                                return;
                            }

                            const compressedFile = new File([blob], file.name, {
                                type: blob.type || outputFormat,
                                lastModified: Date.now(),
                            });

                            resolve(compressedFile);
                        },
                        outputFormat,
                        quality
                    );
                };

                attemptCompression(initialQuality);
            };

            img.onerror = () => resolve(file);
        };

        reader.onerror = () => resolve(file);
    });
}
