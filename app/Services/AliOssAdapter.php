<?php

namespace App\Services;

use League\Flysystem\FileNotFoundException;
use Jacobcyl\AliOSS\AliOssAdapter as BaseAliOssAdapter;

class AliOssAdapter extends BaseAliOssAdapter
{
    /**
     * @param $path
     *
     * @return string
     */
    public function getUrl( $path )
    {
        if (!$this->has($path)) throw new FileNotFoundException($filePath.' not found');
        return ( $this->ssl ? 'https://' : 'http://' ) . $this->endPoint . '/' . ltrim($path, '/');
    }
}
