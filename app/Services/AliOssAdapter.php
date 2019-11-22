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
        return ( $this->ssl ? 'https://' : 'http://' ) . $this->endPoint . '/' . ltrim($path, '/');
    }
}
