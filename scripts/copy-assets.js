const fs = require('fs');
const path = require('path');

// Create dist directory if it doesn't exist
const distDir = path.join(__dirname, '..', 'dist');
if (!fs.existsSync(distDir)) {
  fs.mkdirSync(distDir, { recursive: true });
}

// Copy public assets to dist
const publicDir = path.join(__dirname, '..', 'public');
const assetsToCopy = ['css', 'js', 'images', 'favicon.ico', 'robots.txt'];

function copyRecursive(src, dest) {
  const exists = fs.existsSync(src);
  const stats = exists && fs.statSync(src);
  const isDirectory = exists && stats.isDirectory();

  if (isDirectory) {
    if (!fs.existsSync(dest)) {
      fs.mkdirSync(dest, { recursive: true });
    }
    fs.readdirSync(src).forEach(childItemName => {
      copyRecursive(
        path.join(src, childItemName),
        path.join(dest, childItemName)
      );
    });
  } else {
    const destDir = path.dirname(dest);
    if (!fs.existsSync(destDir)) {
      fs.mkdirSync(destDir, { recursive: true });
    }
    fs.copyFileSync(src, dest);
  }
}

assetsToCopy.forEach(item => {
  const src = path.join(publicDir, item);
  const dest = path.join(distDir, item);
  
  if (fs.existsSync(src)) {
    copyRecursive(src, dest);
    console.log(`Copied ${item} to dist/`);
  }
});

console.log('Assets copied successfully!');

