import { readFileSync, writeFileSync, existsSync } from 'node:fs';
import { resolve } from 'node:path';

const buildDir = resolve(process.cwd(), 'public', 'build');
const manifestPath = resolve(buildDir, 'manifest.json');
const outputHtmlPath = resolve(buildDir, 'index.html');

if (!existsSync(manifestPath)) {
  console.error('Manifest not found at public/build/manifest.json');
  process.exit(1);
}

const manifest = JSON.parse(readFileSync(manifestPath, 'utf8'));

const jsEntry = manifest['resources/js/app.js']?.file;
const cssEntries = manifest['resources/css/app.css']?.css ?? [];

if (!jsEntry) {
  console.error('JS entry not found in manifest: resources/js/app.js');
  process.exit(1);
}

const cssTags = cssEntries
  .map((href) => `    <link rel="stylesheet" href="/${href}">`)
  .join('\n');

const html = `<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantu Tugas - Static Preview</title>
${cssTags}
</head>
<body>
    <main style="max-width:760px;margin:40px auto;padding:0 16px;font-family:Arial,sans-serif;line-height:1.6;">
        <h1 style="margin-bottom:8px;">Bantu Tugas - Vercel Static Preview</h1>
        <p style="margin-top:0;color:#555;">Ini adalah preview statis aset frontend hasil build Vite.</p>
        <p style="color:#555;">Deploy production penuh (PHP + database) tetap gunakan cPanel/VPS/Railway.</p>
    </main>
    <script type="module" src="/${jsEntry}"></script>
</body>
</html>
`;

writeFileSync(outputHtmlPath, html);
console.log('Generated public/build/index.html for Vercel static preview');
