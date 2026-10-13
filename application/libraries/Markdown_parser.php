<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Lorekeeper Markdown & Wiki Link Parser Engine
 * Converts Markdown prose into Field Archivist Grimoire typography
 * and automatically resolves [[Wiki Links]] to lore entries or uncreated concepts.
 */
class Markdown_parser {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    /**
     * Parses markdown text and resolves [[Wiki Links]] for a specific world
     *
     * @param string $text Raw markdown content
     * @param int $world_id Active world ID
     * @return string Illuminated HTML
     */
    public function parse($text, $world_id = null)
    {
        if (empty($text)) {
            return '<p class="text-ash italic">No chronicled lore inscribed for this entry yet.</p>';
        }

        if (!$world_id) {
            $world_id = $this->CI->session->userdata('active_world_id') ?: 1;
        }

        // 1. Normalize line endings
        $text = str_replace(array("\r\n", "\r"), "\n", $text);

        // 2. Extract code blocks so they are not altered by formatting
        $code_blocks = array();
        $text = preg_replace_callback('/```([a-zA-Z0-9_-]*)\n(.*?)```/s', function($matches) use (&$code_blocks) {
            $key = '%%CODEBLOCK_' . count($code_blocks) . '%%';
            $lang = htmlspecialchars($matches[1], ENT_QUOTES, 'UTF-8');
            $code = htmlspecialchars($matches[2], ENT_QUOTES, 'UTF-8');
            $code_blocks[$key] = '<pre class="my-4 p-4 bg-paper-ink border-2 border-paper-line overflow-x-auto font-mono text-xs text-parchment-dim shadow-ink-sm"><code class="language-' . $lang . '">' . $code . '</code></pre>';
            return $key;
        }, $text);

        // 3. Extract inline code
        $inline_codes = array();
        $text = preg_replace_callback('/`([^`]+)`/', function($matches) use (&$inline_codes) {
            $key = '%%INLINECODE_' . count($inline_codes) . '%%';
            $code = htmlspecialchars($matches[1], ENT_QUOTES, 'UTF-8');
            $inline_codes[$key] = '<code class="px-1.5 py-0.5 bg-paper-deep border border-paper-line text-gold font-mono text-xs rounded-sm">' . $code . '</code>';
            return $key;
        }, $text);

        // 4. Resolve [[Wiki Links]]
        $text = $this->resolve_wiki_links($text, $world_id);

        // 5. Headings
        $text = preg_replace_callback('/^(#{1,6})\s+(.+)$/m', function($matches) {
            $level = strlen($matches[1]);
            $title = trim($matches[2]);
            if ($level === 1) {
                return '<h2 class="font-display font-bold text-3xl sm:text-4xl uppercase tracking-wider text-gold border-b-2 border-gold/40 pb-2 mt-8 mb-4">' . $title . '</h2>';
            } elseif ($level === 2) {
                return '<h3 class="font-display font-bold text-2xl sm:text-3xl uppercase tracking-wide text-parchment border-b border-paper-line pb-1.5 mt-7 mb-3 flex items-center gap-2"><span class="w-2 h-2 bg-copper rotate-45 inline-block"></span>' . $title . '</h3>';
            } elseif ($level === 3) {
                return '<h4 class="font-display font-bold text-xl uppercase tracking-wide text-copper mt-6 mb-2">' . $title . '</h4>';
            } else {
                return '<h5 class="font-mono font-bold text-sm uppercase tracking-wider text-parchment-dim mt-4 mb-2">' . $title . '</h5>';
            }
        }, $text);

        // 6. Blockquotes
        $text = preg_replace_callback('/(?:^>.*(?:\n|$))+/m', function($matches) {
            $lines = explode("\n", trim($matches[0]));
            $content = array();
            foreach ($lines as $line) {
                $content[] = preg_replace('/^>\s?/', '', $line);
            }
            $quote_text = trim(implode("\n", $content));
            return '<blockquote class="my-5 p-4 sm:p-5 bg-paper-deep border-l-4 border-gold shadow-ink-sm font-prose italic text-lg sm:text-xl text-parchment-dim leading-relaxed relative"><span class="font-display text-4xl text-gold/30 absolute top-1 left-2 select-none">“</span><div class="relative z-10 pl-3">' . nl2br($quote_text) . '</div></blockquote>';
        }, $text);

        // 7. Horizontal Rules
        $text = preg_replace('/^(\-{3,}|\*{3,}|_{3,})$/m', '<div class="my-8 flex items-center gap-3"><span class="flex-1 h-px bg-paper-line"></span><span class="w-2 h-2 border border-gold rotate-45"></span><span class="w-3 h-3 border border-copper rotate-45 flex items-center justify-center"><span class="w-1 h-1 bg-gold"></span></span><span class="w-2 h-2 border border-gold rotate-45"></span><span class="flex-1 h-px bg-paper-line"></span></div>', $text);

        // 8. Bold and Italic formatting
        $text = preg_replace('/\*\*\*(.+?)\*\*\*/s', '<strong class="font-bold text-gold"><em>$1</em></strong>', $text);
        $text = preg_replace('/\*\*(.+?)\*\*/s', '<strong class="font-bold text-gold">$1</strong>', $text);
        $text = preg_replace('/__(.+?)__/s', '<strong class="font-bold text-gold">$1</strong>', $text);
        $text = preg_replace('/\*([^\*\n]+)\*/', '<em class="italic text-parchment-dim">$1</em>', $text);
        $text = preg_replace('/_([^_\n]+)_/', '<em class="italic text-parchment-dim">$1</em>', $text);

        // 9. Unordered Lists
        $text = preg_replace_callback('/(?:^[\*\-]\s+.+(?:\n|$))+/m', function($matches) {
            $lines = explode("\n", trim($matches[0]));
            $items = array();
            foreach ($lines as $line) {
                $item_content = preg_replace('/^[\*\-]\s+/', '', $line);
                if (!empty($item_content)) {
                    $items[] = '<li class="flex items-start gap-2.5 my-1.5"><span class="text-gold text-xs mt-1 shrink-0">◈</span><span class="text-parchment leading-relaxed">' . $item_content . '</span></li>';
                }
            }
            return '<ul class="my-4 pl-2 font-prose text-base space-y-1">' . implode('', $items) . '</ul>';
        }, $text);

        // 10. Ordered Lists
        $text = preg_replace_callback('/(?:^\d+\.\s+.+(?:\n|$))+/m', function($matches) {
            $lines = explode("\n", trim($matches[0]));
            $items = array();
            $num = 1;
            foreach ($lines as $line) {
                $item_content = preg_replace('/^\d+\.\s+/', '', $line);
                if (!empty($item_content)) {
                    $items[] = '<li class="flex items-start gap-2.5 my-1.5"><span class="font-mono text-xs font-bold text-copper mt-0.5 shrink-0">[' . sprintf('%02d', $num++) . ']</span><span class="text-parchment leading-relaxed">' . $item_content . '</span></li>';
                }
            }
            return '<ol class="my-4 pl-2 font-prose text-base space-y-1">' . implode('', $items) . '</ol>';
        }, $text);

        // 11. Paragraphs (blocks separated by blank lines)
        $blocks = preg_split('/\n{2,}/', $text);
        $html_blocks = array();

        foreach ($blocks as $block) {
            $block = trim($block);
            if (empty($block)) continue;

            // If block is already wrapped in HTML or a placeholder tag, don't wrap in <p>
            if (preg_match('/^<(h[1-6]|blockquote|ul|ol|pre|div|table)/i', $block) || preg_match('/^%%CODEBLOCK_\d+%%$/', $block)) {
                $html_blocks[] = $block;
            } else {
                $html_blocks[] = '<p class="font-prose text-base sm:text-lg text-parchment leading-relaxed mb-4">' . nl2br($block) . '</p>';
            }
        }

        $result = implode("\n\n", $html_blocks);

        // 12. Restore inline code
        foreach ($inline_codes as $key => $val) {
            $result = str_replace($key, $val, $result);
        }

        // 13. Restore code blocks
        foreach ($code_blocks as $key => $val) {
            $result = str_replace($key, $val, $result);
        }

        return $result;
    }

    /**
     * Resolves [[Wiki Links]] against the database
     */
    protected function resolve_wiki_links($text, $world_id)
    {
        return preg_replace_callback('/\[\[([^\]\|]+)(?:\|([^\]]+))?\]\]/', function($matches) use ($world_id) {
            $target = trim($matches[1]);
            $label  = isset($matches[2]) && !empty(trim($matches[2])) ? trim($matches[2]) : $target;

            // Search for target in entries table by title, slug, or sanitized slug
            $target_slug = url_title($target, '-', TRUE);

            $this->CI->db->select('id, title, slug, status, is_archived');
            $this->CI->db->from('entries');
            $this->CI->db->where('world_id', $world_id);
            $this->CI->db->group_start();
            $this->CI->db->where('LOWER(title)', strtolower($target));
            $this->CI->db->or_where('slug', $target_slug);
            $this->CI->db->or_where('slug', strtolower($target));
            $this->CI->db->group_end();
            $entry = $this->CI->db->get()->row();

            if ($entry) {
                // Link exists in the world registry
                $url = base_url('entries/view/' . $entry->id);
                $is_archived = !empty($entry->is_archived);
                
                if ($is_archived) {
                    return '<a href="' . $url . '" class="wiki-link inline-flex items-center gap-1 text-ash hover:text-parchment border-b border-dashed border-ash font-medium transition px-1 py-0.5 bg-paper-deep/80 rounded-sm" title="Archived record: ' . htmlspecialchars($entry->title, ENT_QUOTES, 'UTF-8') . '"><span class="text-[10px] text-ash">◈</span>' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . ' <span class="text-[9px] uppercase tracking-wider text-ash">[ARCHIVED]</span></a>';
                }

                return '<a href="' . $url . '" class="wiki-link inline-flex items-center gap-1 text-gold hover:text-gold-light border-b border-gold/60 font-semibold transition px-1 py-0.5 bg-paper-deep/70 rounded-sm hover:bg-paper-panel shadow-ink-sm" title="Consult chronicle: ' . htmlspecialchars($entry->title, ENT_QUOTES, 'UTF-8') . '"><span class="text-[10px] text-gold/80">✦</span>' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</a>';
            } else {
                // Unwritten Lore Concept / Redlink
                $create_url = base_url('entries/create?title=' . urlencode($target));
                return '<a href="' . $create_url . '" class="wiki-link-unwritten inline-flex items-center gap-1 text-copper hover:text-parchment border-b border-dashed border-copper/70 font-mono text-sm px-1 py-0.5 bg-paper-deep/60 hover:bg-copper/10 transition" title="Unrecorded lore concept — Click to inscribe new entry"><span class="text-[10px] text-copper">✧</span>' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . ' <span class="text-[10px] text-copper font-bold" style="font-size: 10px;">[＋]</span></a>';
            }
        }, $text);
    }

    /**
     * Extracts all raw target titles or slugs from [[Target]] links
     *
     * @param string $text
     * @return array Unique target strings
     */
    public function extract_wiki_targets($text)
    {
        $targets = array();
        if (preg_match_all('/\[\[([^\]\|]+)(?:\|[^\]]+)?\]\]/', $text, $matches)) {
            foreach ($matches[1] as $t) {
                $targets[] = trim($t);
            }
        }
        return array_unique($targets);
    }
}
