import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// Helper function to replace Blade syntax with static paths
function convertBladeToHTML(content) {
  // Replace {{ asset('path') }} with /path
  content = content.replace(/\{\{\s*asset\(['"]([^'"]+)['"]\)\s*\}\}/g, '/$1');
  
  // Replace {{ str_replace('_', '-', app()->getLocale()) }} with 'en'
  content = content.replace(/\{\{\s*str_replace\(['"]_['"],\s*['"]-['"],\s*app\(\)->getLocale\(\)\)\s*\}\}/g, 'en');
  
  // Remove any remaining Blade syntax (you may need to handle these manually)
  // For now, we'll leave them as comments for manual review
  
  return content;
}

// Convert Blade templates to HTML
const viewsDir = path.join(__dirname, '..', 'resources', 'views');
const distDir = path.join(__dirname, '..', 'dist');

if (!fs.existsSync(distDir)) {
  fs.mkdirSync(distDir, { recursive: true });
}

const bladeFiles = [
  { src: 'welcome.blade.php', dest: 'index.html' },
  { src: 'login.blade.php', dest: 'login.html' },
  { src: 'login_official.blade.php', dest: 'login/official.html' },
  { src: 'create_account.blade.php', dest: 'register.html' },
  { src: 'dashboard.blade.php', dest: 'dashboard.html' },
  { src: 'dashboard_official.blade.php', dest: 'dashboard/official.html' }
];

bladeFiles.forEach(({ src, dest }) => {
  const srcPath = path.join(viewsDir, src);
  const destPath = path.join(distDir, dest);
  
  if (fs.existsSync(srcPath)) {
    let content = fs.readFileSync(srcPath, 'utf8');
    content = convertBladeToHTML(content);
    
    // Ensure destination directory exists
    const destDir = path.dirname(destPath);
    if (!fs.existsSync(destDir)) {
      fs.mkdirSync(destDir, { recursive: true });
    }
    
    fs.writeFileSync(destPath, content, 'utf8');
    console.log(`Converted ${src} -> ${dest}`);
  } else {
    console.warn(`Warning: ${src} not found`);
  }
});

console.log('HTML conversion completed!');
