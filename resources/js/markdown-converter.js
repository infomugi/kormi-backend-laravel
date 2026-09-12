/**
 * Markdown <-> Clean HTML Bidirectional Converter Utility
 * Mendukung konversi Markdown ke Clean HTML dan HTML ke Markdown
 */

export function markdownToHtml(md) {
    if (!md) return '';

    let text = md.trim();

    // Jika sudah full HTML (misal diawali tag HTML), kembalikan apa adanya
    if (/^<(div|article|section|p|h[1-6]|table|ul|ol|blockquote)\b/i.test(text) && !/(^#{1,6}\s+|^\s*[-*+]\s+|^\s*\d+\.\s+|^\s*>\s+|\*\*|~~|\[.*?\]\(.*?\))/m.test(text)) {
        return text;
    }

    // 1. Normalize Line Endings
    text = text.replace(/\r\n/g, '\n').replace(/\r/g, '\n');

    // 2. Escape dangerous scripts
    text = text.replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, '');

    // 3. Code blocks (```code```)
    text = text.replace(/```([\s\S]*?)```/g, (match, p1) => {
        return `<pre class="bg-slate-900 text-slate-100 p-4 rounded-xl overflow-x-auto text-xs my-3"><code>${escapeHtml(p1.trim())}</code></pre>`;
    });

    // 4. Tables (| col | col |)
    text = text.replace(/(?:(?:^|\n)\|[^\n]+\|\n\|[-:| ]+\|\n(?:\|[^\n]+\|\n?)+)/g, (tableMatch) => {
        const lines = tableMatch.trim().split('\n');
        if (lines.length < 3) return tableMatch;

        const headerCells = lines[0].split('|').filter((_, idx, arr) => idx > 0 && idx < arr.length - 1).map(c => c.trim());
        const bodyRows = lines.slice(2);

        let tableHtml = '<div class="overflow-x-auto my-4 rounded-xl border border-slate-200"><table class="w-full text-left text-sm border-collapse">';
        tableHtml += '<thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider"><tr>';
        headerCells.forEach(cell => {
            tableHtml += `<th class="px-4 py-3">${parseInline(cell)}</th>`;
        });
        tableHtml += '</tr></thead><tbody class="divide-y divide-slate-100 text-slate-700">';
        bodyRows.forEach(row => {
            const cells = row.split('|').filter((_, idx, arr) => idx > 0 && idx < arr.length - 1).map(c => c.trim());
            if (cells.length > 0) {
                tableHtml += '<tr class="hover:bg-slate-50/70 transition-colors">';
                cells.forEach(cell => {
                    tableHtml += `<td class="px-4 py-3">${parseInline(cell)}</td>`;
                });
                tableHtml += '</tr>';
            }
        });
        tableHtml += '</tbody></table></div>';
        return tableHtml;
    });

    // 5. Blockquotes / Callout (> Quote or > Info)
    text = text.replace(/(?:^|\n)(?:> ?[^\n]+(?:\n|$))+/g, (quoteBlock) => {
        const cleaned = quoteBlock.split('\n').map(l => l.replace(/^> ?/, '').trim()).filter(l => l.length > 0).join('<br>');
        return `\n<blockquote class="my-4 border-l-4 border-emerald-500 bg-emerald-50/50 dark:bg-emerald-950/20 px-4 py-3 rounded-r-xl text-slate-800 dark:text-slate-200 font-medium italic">${parseInline(cleaned)}</blockquote>\n`;
    });

    // 6. Headings (# H1 to ###### H6)
    text = text.replace(/^###### (.*$)/gim, '<h6 class="text-sm font-bold text-slate-800 mt-4 mb-2">$1</h6>');
    text = text.replace(/^##### (.*$)/gim, '<h5 class="text-base font-bold text-slate-800 mt-4 mb-2">$1</h5>');
    text = text.replace(/^#### (.*$)/gim, '<h4 class="text-lg font-bold text-slate-900 mt-5 mb-2">$1</h4>');
    text = text.replace(/^### (.*$)/gim, '<h3 class="text-xl font-black text-slate-900 mt-6 mb-2 tracking-tight">$1</h3>');
    text = text.replace(/^## (.*$)/gim, '<h2 class="text-2xl font-black text-slate-900 mt-7 mb-3 tracking-tight">$1</h2>');
    text = text.replace(/^# (.*$)/gim, '<h1 class="text-3xl font-black text-slate-900 mt-8 mb-4 tracking-tight">$1</h1>');

    // 7. Horizontal Divider
    text = text.replace(/^(?:---|\*\*\*|___)$/gim, '<hr class="my-6 border-slate-200">');

    // 8. Checklists (- [ ] or - [x])
    text = text.replace(/(?:^|\n)(?:- \[[ xX]\] [^\n]+(?:\n|$))+/g, (listBlock) => {
        const items = listBlock.split('\n').filter(l => l.trim().length > 0);
        let listHtml = '\n<ul class="my-3 space-y-1.5 list-none pl-0">';
        items.forEach(item => {
            const isChecked = /- \[x\]/i.test(item);
            const content = item.replace(/^- \[[ xX]\]\s*/, '');
            listHtml += `<li class="flex items-center gap-2 text-slate-700 font-medium"><input type="checkbox" disabled ${isChecked ? 'checked' : ''} class="rounded text-emerald-600"> <span>${parseInline(content)}</span></li>`;
        });
        listHtml += '</ul>\n';
        return listHtml;
    });

    // 9. Unordered Lists (- item or * item)
    text = text.replace(/(?:^|\n)(?:[-*] [^\n]+(?:\n|$))+/g, (listBlock) => {
        const items = listBlock.split('\n').filter(l => l.trim().length > 0);
        let listHtml = '\n<ul class="my-3 space-y-1 list-disc list-inside text-slate-700">';
        items.forEach(item => {
            const content = item.replace(/^[-*]\s+/, '');
            listHtml += `<li class="leading-relaxed">${parseInline(content)}</li>`;
        });
        listHtml += '</ul>\n';
        return listHtml;
    });

    // 10. Numbered Lists (1. item)
    text = text.replace(/(?:^|\n)(?:\d+\. [^\n]+(?:\n|$))+/g, (listBlock) => {
        const items = listBlock.split('\n').filter(l => l.trim().length > 0);
        let listHtml = '\n<ol class="my-3 space-y-1 list-decimal list-inside text-slate-700">';
        items.forEach(item => {
            const content = item.replace(/^\d+\.\s+/, '');
            listHtml += `<li class="leading-relaxed">${parseInline(content)}</li>`;
        });
        listHtml += '</ol>\n';
        return listHtml;
    });

    // 11. Paragraphs & Inline Format
    return parseParagraphs(text).trim();
}

/**
 * Konversi HTML ke Markdown bersih
 */
export function htmlToMarkdown(html) {
    if (!html) return '';

    let md = html;

    // Headings
    md = md.replace(/<h1[^>]*>(.*?)<\/h1>/gi, '# $1\n\n');
    md = md.replace(/<h2[^>]*>(.*?)<\/h2>/gi, '## $1\n\n');
    md = md.replace(/<h3[^>]*>(.*?)<\/h3>/gi, '### $1\n\n');
    md = md.replace(/<h4[^>]*>(.*?)<\/h4>/gi, '#### $1\n\n');
    md = md.replace(/<h5[^>]*>(.*?)<\/h5>/gi, '##### $1\n\n');
    md = md.replace(/<h6[^>]*>(.*?)<\/h6>/gi, '###### $1\n\n');

    // Blockquote
    md = md.replace(/<blockquote[^>]*>([\s\S]*?)<\/blockquote>/gi, (match, p1) => {
        const lines = p1.replace(/<br\s*\/?>/gi, '\n').split('\n').map(l => l.trim()).filter(l => l.length > 0);
        return lines.map(l => `> ${l}`).join('\n') + '\n\n';
    });

    // Bold / Strong
    md = md.replace(/<(strong|b)[^>]*>(.*?)<\/(strong|b)>/gi, '**$2**');

    // Italic / Em
    md = md.replace(/<(em|i)[^>]*>(.*?)<\/(em|i)>/gi, '*$2*');

    // Strike / Del
    md = md.replace(/<(del|s|strike)[^>]*>(.*?)<\/(del|s|strike)>/gi, '~~$2~~');

    // Mark
    md = md.replace(/<mark[^>]*>(.*?)<\/mark>/gi, '<mark>$1</mark>');

    // Links: <a href="url">text</a>
    md = md.replace(/<a\s+[^>]*href=["']([^"']*)["'][^>]*>(.*?)<\/a>/gi, '[$2]($1)');

    // Images: <img src="url" alt="alt">
    md = md.replace(/<img\s+[^>]*src=["']([^"']*)["'][^>]*alt=["']([^"']*)["'][^>]*>/gi, '![$2]($1)');
    md = md.replace(/<img\s+[^>]*alt=["']([^"']*)["'][^>]*src=["']([^"']*)["'][^>]*>/gi, '![$1]($2)');
    md = md.replace(/<img\s+[^>]*src=["']([^"']*)["'][^>]*>/gi, '![]($1)');

    // List items
    md = md.replace(/<li[^>]*>(.*?)<\/li>/gi, '- $1\n');
    md = md.replace(/<\/?(ul|ol)[^>]*>/gi, '\n');

    // Paragraphs & Breaks
    md = md.replace(/<p[^>]*>(.*?)<\/p>/gi, '$1\n\n');
    md = md.replace(/<br\s*\/?>/gi, '\n');
    md = md.replace(/<hr[^>]*>/gi, '\n---\n\n');

    // Strip remaining tags
    md = md.replace(/<[^>]+>/g, '');

    // Unescape HTML Entities
    md = md.replace(/&amp;/g, '&')
           .replace(/&lt;/g, '<')
           .replace(/&gt;/g, '>')
           .replace(/&quot;/g, '"')
           .replace(/&#039;/g, "'")
           .replace(/&nbsp;/g, ' ');

    // Clean multiple blank lines
    md = md.replace(/\n{3,}/g, '\n\n');

    return md.trim();
}

function parseInline(str) {
    if (!str) return '';
    return str
        .replace(/!\[(.*?)\]\((.*?)\)/g, '<img src="$2" alt="$1" class="rounded-xl my-4 max-h-96 w-full object-cover shadow-sm">')
        .replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" target="_blank" rel="noopener noreferrer" class="text-emerald-700 hover:text-emerald-900 underline font-semibold transition-colors">$1</a>')
        .replace(/\*\*(.*?)\*\*/g, '<strong class="font-extrabold text-slate-900">$1</strong>')
        .replace(/__(.*?)__/g, '<strong class="font-extrabold text-slate-900">$1</strong>')
        .replace(/\*(.*?)\*/g, '<em class="italic">$1</em>')
        .replace(/_(.*?)_/g, '<em class="italic">$1</em>')
        .replace(/~~(.*?)~~/g, '<del class="line-through text-slate-400">$1</del>')
        .replace(/<mark>(.*?)<\/mark>/g, '<mark class="bg-amber-200 px-1 py-0.5 rounded text-slate-900 font-semibold">$1</mark>')
        .replace(/`([^`]+)`/g, '<code class="bg-slate-100 text-emerald-700 px-1.5 py-0.5 rounded text-xs font-mono">$1</code>');
}

function parseParagraphs(html) {
    const blocks = html.split(/\n\s*\n/);
    return blocks.map(block => {
        const trimmed = block.trim();
        if (!trimmed) return '';
        if (/^<(h[1-6]|ul|ol|table|blockquote|pre|hr|div|img|p)\b/i.test(trimmed)) {
            return trimmed;
        }
        return `<p class="my-3 leading-relaxed text-slate-700">${parseInline(trimmed.replace(/\n/g, '<br>'))}</p>`;
    }).join('\n\n');
}

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}
