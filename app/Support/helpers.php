<?php

if (! function_exists('versioned_asset')) {
    function versioned_asset(string $path): string
    {
        $relativePath = ltrim($path, '/');
        $url = asset($relativePath);
        $filePath = public_path($relativePath);

        if (! is_file($filePath)) {
            return $url;
        }

        $modifiedAt = filemtime($filePath);

        return $modifiedAt === false ? $url : $url.'?v='.$modifiedAt;
    }
}
