#!/usr/bin/env sh
# Re-apply Composer 2 compatibility fix after `composer update` overwrites vendor/laravel/framework.
set -e
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
TARGET="$ROOT/vendor/laravel/framework/src/Illuminate/Foundation/PackageManifest.php"
PATCH="$ROOT/patches/laravel-5.5-composer2-package-manifest.patch"

if [ ! -f "$TARGET" ]; then
  echo "Run composer install first (missing $TARGET)" >&2
  exit 1
fi

cd "$ROOT/vendor/laravel/framework"
patch -N -p1 -r - < "$PATCH" || true

# patch returns 1 if already applied; ensure file contains our fix
if ! grep -q "installed\['packages'\]" "$ROOT/vendor/laravel/framework/src/Illuminate/Foundation/PackageManifest.php"; then
  echo "Patch may have failed; check PackageManifest.php manually." >&2
  exit 1
fi

echo "PackageManifest.php Composer 2 fix OK."
