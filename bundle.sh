#!/bin/bash

set -e

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
TEMP_DIR="$PROJECT_ROOT/.bundle_temp"

cleanup() {
    echo "Cleaning up temporary files..."
    rm -rf "$TEMP_DIR"
}
trap cleanup EXIT

echo "=== cPanel Deployment Bundle Script ==="
echo ""

echo "[1/8] Cleaning up previous builds..."
rm -rf "$TEMP_DIR"
rm -f "$PROJECT_ROOT/bundle.zip"
rm -f "$PROJECT_ROOT/database_backup.sql"
mkdir -p "$TEMP_DIR/laravel"
mkdir -p "$TEMP_DIR/public_html"

echo "[2/8] Creating database backup..."
cd "$PROJECT_ROOT"
php -r "
\$lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
\$env = [];
foreach (\$lines as \$line) {
    if (strpos(trim(\$line), '#') === 0) continue;
    if (strpos(\$line, '=') !== false) {
        list(\$key, \$value) = explode('=', \$line, 2);
        \$env[trim(\$key)] = trim(\$value);
    }
}
\$host = \$env['DB_HOST'] ?? '127.0.0.1';
\$port = \$env['DB_PORT'] ?? '3306';
\$user = \$env['DB_USERNAME'] ?? 'root';
\$pass = \$env['DB_PASSWORD'] ?? '';
\$name = \$env['DB_DATABASE'] ?? 'laravel_portfolio';
\$cmd = 'mysqldump -u ' . \$user . (\$pass ? ' -p' . \$pass : '') . ' -h ' . \$host . ' ' . \$name . ' > database_backup.sql';
exec(\$cmd);
"
if [ -f "$PROJECT_ROOT/database_backup.sql" ] && [ -s "$PROJECT_ROOT/database_backup.sql" ]; then
    echo "Database backup created: database_backup.sql"
else
    echo "Warning: Database backup failed or is empty"
fi

echo "[3/8] Copying vendor directory..."
cp -r "$PROJECT_ROOT/vendor" "$TEMP_DIR/laravel/"

echo "[4/8] Optimizing autoload..."
cd "$PROJECT_ROOT"
composer dump-autoload --optimize --classmap-authoritative

echo "[5/8] Building frontend assets..."
npm run build

echo "[6/8] Copying Laravel files to temp directory..."
rsync -a \
    --exclude='.git' \
    --exclude='node_modules' \
    --exclude='tests' \
    --exclude='.env' \
    --exclude='bundle.sh' \
    --exclude='vendor' \
    --exclude='/public' \
    --exclude='.phpunit.result.cache' \
    --exclude='*.zip' \
    --exclude='.bundle_temp' \
    --exclude='database_backup.sql' \
    "$PROJECT_ROOT/" "$TEMP_DIR/laravel/"

cp "$PROJECT_ROOT/.env.example" "$TEMP_DIR/laravel/"

echo "[7/8] Copying build assets to laravel/public..."
mkdir -p "$TEMP_DIR/laravel/public/build"
cp -r "$PROJECT_ROOT/public/build/"* "$TEMP_DIR/laravel/public/build/"

echo "[9/9] Copying public files to public_html..."
cd "$PROJECT_ROOT/public"
for item in *; do
    if [ "$item" != "storage" ] && [ -e "$item" ]; then
        cp -r "$item" "$TEMP_DIR/public_html/"
    fi
done

echo "Creating storage symlink for public_html..."
cd "$TEMP_DIR/public_html"
ln -s ../laravel/storage/app/public storage

echo "[10/10] Updating index.php paths..."
sed -i "s|__DIR__.'/../storage|__DIR__.'/../laravel/storage|g" "$TEMP_DIR/public_html/index.php"
sed -i "s|__DIR__.'/../vendor|__DIR__.'/../laravel/vendor|g" "$TEMP_DIR/public_html/index.php"
sed -i "s|__DIR__.'/../bootstrap|__DIR__.'/../laravel/bootstrap|g" "$TEMP_DIR/public_html/index.php"

echo "Creating bundle.zip..."
cd "$TEMP_DIR"
zip -rqy "$PROJECT_ROOT/bundle.zip" .

echo ""
echo "=== Bundle complete! ==="
echo "Output:"
echo "  - $PROJECT_ROOT/bundle.zip"
echo "  - $PROJECT_ROOT/database_backup.sql"
