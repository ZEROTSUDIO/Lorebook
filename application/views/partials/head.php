<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($page_title) ? html_escape($page_title) . ' — ' : ''; ?>Lorekeeper</title>
  
  <!-- Google Fonts: Cormorant Garamond, Newsreader, Space Mono, Cinzel -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700;900&family=Cormorant+Garamond:ital,wght@0,600;0,700;1,500;1,700&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,600;1,6..72,400&family=Space+Mono:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
  
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            paper: {
              base: '#151419',
              deep: '#111014',
              panel: '#1E1D24',
              surface: '#272630',
              line: '#3D382F',
              ink: '#08070A'
            },
            parchment: {
              DEFAULT: '#ECE7DD',
              dim: '#CFC8BA',
              dark: '#9E9788'
            },
            ash: '#8E887E',
            gold: {
              DEFAULT: '#C5A869',
              light: '#E6D3A3',
              pale: '#F4ECDB',
              dark: '#856E3B',
              bronze: '#6E5A2D'
            },
            copper: '#BA7A55',
            crimson: {
              DEFAULT: '#8A2B2B',
              dark: '#581818',
              seal: '#A53232'
            }
          },
          fontFamily: {
            display: ['"Cormorant Garamond"', 'Georgia', 'serif'],
            cinzel: ['"Cinzel"', 'Georgia', 'serif'],
            prose: ['"Newsreader"', 'Georgia', 'serif'],
            mono: ['"Space Mono"', 'monospace']
          },
          boxShadow: {
            'ink-sm': '2px 2px 0 #08070A',
            'ink': '4px 4px 0 #08070A',
            'ink-lg': '6px 6px 0 #08070A',
            'gold-sm': '2px 2px 0 #C5A869',
            'gold-md': '4px 4px 0 #C5A869'
          }
        }
      }
    }
  </script>

  <style>
    /* Dark Grimoire Tactile Paper Weave Texture */
    .bg-grimoire-weave {
      background-color: #151419;
      background-image: 
        repeating-linear-gradient(97deg, rgba(197, 168, 105, 0.035) 0 1px, transparent 1px 4px),
        repeating-linear-gradient(11deg, rgba(120, 100, 70, 0.025) 0 1px, transparent 1px 6px);
    }

    /* Architectural Corner Crosshairs */
    .corner-brackets {
      position: relative;
    }
    .corner-brackets::before {
      content: "⌜";
      position: absolute;
      top: 3px;
      left: 5px;
      font-family: monospace;
      font-size: 13px;
      color: #C5A869;
      opacity: 0.7;
    }
    .corner-brackets::after {
      content: "⌟";
      position: absolute;
      bottom: 3px;
      right: 5px;
      font-family: monospace;
      font-size: 13px;
      color: #C5A869;
      opacity: 0.7;
    }

    /* Wax Seal Badge Texture */
    .wax-seal {
      background: radial-gradient(circle at 35% 35%, #A53232 0%, #752222 55%, #4A1414 100%);
      box-shadow: inset 0 1px 2px rgba(255,255,255,0.25), 3px 3px 0 #08070A;
    }
  </style>
</head>
<body class="bg-grimoire-weave text-parchment font-prose min-h-screen selection:bg-gold selection:text-paper-ink flex flex-col justify-between">
