<?php

namespace App\Providers;

use Storage;
use OSS\OssClient;
use App\Services\AliOssAdapter;
use League\Flysystem\Filesystem;
use Jacobcyl\AliOSS\Plugins\PutFile;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Jacobcyl\AliOSS\Plugins\PutRemoteFile;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Pagination\LengthAwarePaginator::defaultView('vendor.pagination.default');

        $this->app['request']->server->set('HTTPS', str_contains(config('app.url'), 'https://'));

        // 重写 aliyun oss 扩展
        Storage::extend('oss', function($app, $config) {
            $accessId  = $config['access_id'];
            $accessKey = $config['access_key'];

            $bucket    = $config['bucket'];
            $ssl       = $config['ssl']; 
            $isCname   = $config['isCName'];
            $debug     = $config['debug'];
            $endPoint  = $config['endpoint'];
            $cdnDomain = $config['cdnDomain'] ?: $bucket.'.'.$endPoint;
            
            if($debug) Log::debug('OSS config:', $config);

            $client  = new OssClient($accessId, $accessKey, $bucket.'.'.$endPoint, $isCname);
            $adapter = new AliOssAdapter($client, $bucket, $cdnDomain, $ssl, $isCname, $debug, $endPoint);

            $filesystem =  new Filesystem($adapter);
            
            $filesystem->addPlugin(new PutFile());
            $filesystem->addPlugin(new PutRemoteFile());

            return $filesystem;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
