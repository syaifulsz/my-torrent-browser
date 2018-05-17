<?php

namespace App\Components;

use Cocur\Slugify\Slugify;

class Cache
{
    private function filePath($key)
    {
        $slugify = new Slugify();
        return CACHE_DIR . '/' . $slugify->slugify($key) . '.cache';
    }

    public function set($cacheKey, $cacheData, $expire = false)
    {
        $cacheFile = $this->filePath($cacheKey);
        if ($cacheData) {
            return file_put_contents($cacheFile, json_encode([
                'expire' => $expire,
                'data' => serialize($cacheData)
            ])) ? true : false;
        }
    }

    public function get($cacheKey)
    {
        $cacheFile = $this->filePath($cacheKey);

        if (file_exists($cacheFile)) {

            $cache = file_get_contents($cacheFile);
            $cache = json_decode($cache, true);

            if (isset($cache['expire']) && $cache['expire'] !== false) {
                if (filectime($cacheFile) + $cache['expire'] < time()) {
                    return null;
                }
            }

            if (!empty($cache['data'])) {
                return unserialize($cache['data']);
            }
        }

        return null;
    }

    public function remove($cacheKey)
    {
        $cacheFile = $this->filePath($cacheKey);

        if (file_exists($cacheFile)) {
            return unlink($cacheFile) ? true : false;
        }

        return true;
    }

    public function removeAll()
    {
        $count = 0;

        $cacheFiles = glob(CACHE_DIR . '/*.cache');
        foreach($cacheFiles as $file) {
            if (unlink($cacheFile)) {
                $count++;
            }
        }

        return $count ? true : false;
    }
}
