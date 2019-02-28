<?php

namespace App\Services;

use League\Flysystem\Adapter\AbstractAdapter;
use League\Flysystem\Adapter\Polyfill\NotSupportingVisibilityTrait;
use League\Flysystem\Config;
use Obs\ObsClient;
use Obs\ObsException;

/**
 * 华为云OSS
 *
 * Class ObsAdapter.
 *
 * require non0/huaweicloud-obs-sdk
 */
class ObsAdapter extends AbstractAdapter
{
    use NotSupportingVisibilityTrait;

    /**
     * @var
     */
    protected $accessKeyId;

    /**
     * @var
     */
    protected $accessKeySecret;

    /**
     * @var
     */
    protected $endpoint;

    /**
     * @var
     */
    protected $bucket;

    /**
     * @var
     */
    protected $isCName;

    /**
     * @var ObsClient
     */
    protected $client;

    /**
     * @var array|mixed[]
     */
    protected $params;

    /**
     * OssAdapter constructor.
     *
     * @param       $accessKeyId
     * @param       $accessKeySecret
     * @param       $endpoint
     * @param       $bucket
     * @param bool  $cName
     * @param mixed ...$params
     *
     * @throws ObsException
     */
    public function __construct($accessKeyId, $accessKeySecret, $endpoint, $bucket, $cName = false, ...$params)
    {
        $this->accessKeyId = $accessKeyId;
        $this->accessKeySecret = $accessKeySecret;
        $this->endpoint = $endpoint;
        $this->bucket = $bucket;
        $this->isCName = $cName;
        $this->params = $params;
        $this->initClient();
    }

    /**
     * init oss client.
     *
     * @throws ObsException
     */
    protected function initClient()
    {
        if (empty($this->client)) {
            $this->client = new ObsClient([
                'key' => $this->accessKeyId,
                'secret' => $this->accessKeySecret,
                'endpoint' => $this->endpoint
            ]);
        }
    }

    /**
     * write a file.
     *
     * @param string $path
     * @param string $contents
     * @param Config $config
     *
     * @return array|bool|false
     */
    public function write($path, $contents, Config $config)
    {
        $path = $this->applyPathPrefix($path);

        $this->client->putObject([
            'Bucket' => $this->bucket,
            'Key' => $path,
            'Body' => $contents
        ]);

        return true;
    }

    /**
     * Write a new file using a stream.
     *
     * @param string   $path
     * @param resource $resource
     * @param Config   $config
     *
     * @return array|bool|false
     */
    public function writeStream($path, $resource, Config $config)
    {
        $contents = stream_get_contents($resource);

        return $this->write($path, $contents, $config);
    }

    /**
     * Update a file.
     *
     * @param string $path
     * @param string $contents
     * @param Config $config
     *
     * @return array|bool|false
     */
    public function update($path, $contents, Config $config)
    {
        return $this->write($path, $contents, $config);
    }

    /**
     * Update a file using a stream.
     *
     * @param string   $path
     * @param resource $resource
     * @param Config   $config
     *
     * @return array|bool|false
     */
    public function updateStream($path, $resource, Config $config)
    {
        return $this->writeStream($path, $resource, $config);
    }

    /**
     * rename a file.
     *
     * @param string $path
     * @param string $newpath
     *
     * @return bool
     *
     * @throws ObsException
     */
    public function rename($path, $newpath)
    {
        if (!$this->copy($path, $newpath)) {
            return false;
        }

        return $this->delete($path);
    }

    /**
     * copy a file.
     *
     * @param string $path
     * @param string $newpath
     *
     * @return bool
     */
    public function copy($path, $newpath)
    {
        $path = $this->applyPathPrefix($path);
        $newpath = $this->applyPathPrefix($newpath);

        try {
            $this->client->copyObject([
                'Bucket' => $this->bucket,
                'Key' => $newpath,
                'CopySource' => $this->bucket.'/'.$path
            ]);
        } catch (ObsException $exception) {
            return false;
        }

        return true;
    }

    public function putFileAs($path, $file, $name, $options)
    {
        $path = $this->applyPathPrefix($path);

        $this->client->putObject([
            'Bucket' => $this->bucket,
            'Key' => $path . '/' .$name,
            'SourceFile' => $file->path(),
        ]);

        return $path . '/' .$name;
    }

    public function url($path)
    {
        return $this->isCName.'/'.$path;
    }

    /**
     * delete a file.
     *
     * @param string $path
     *
     * @return bool
     *
     * @throws ObsException
     */
    public function delete($path)
    {
        $path = $this->applyPathPrefix($path);

        try {
            $this->client->deleteObject([
                'Bucket' => $this->bucket,
                'Key' => $path
            ]);
        } catch (ObsException $exception) {
            return false;
        }

        return !$this->has($path);
    }

    /**
     * Delete a directory.
     *
     * @param string $dirname
     *
     * @return bool
     */
    public function deleteDir($dirname)
    {
        return true;
    }

    /**
     * create a directory.
     *
     * @param string $dirname
     * @param Config $config
     *
     * @return array|false
     */
    public function createDir($dirname, Config $config)
    {
        return ['path' => $dirname, 'type' => 'dir'];
    }

    /**
     * Check whether a file exists.
     *
     * @param string $path
     *
     * @return array|bool|null
     */
    public function has($path)
    {
        $path = $this->applyPathPrefix($path);

        return $this->client->doesObjectExist($this->bucket, $path);
    }

    /**
     * Get resource url.
     *
     * @param string $path
     *
     * @return string
     */
    public function getUrl($path)
    {
        return $this->normalizeHost().ltrim($path, '/');
    }

    /**
     * read a file.
     *
     * @param string $path
     *
     * @return array|bool|false
     */
    public function read($path)
    {
        try {
            $contents = $this->getObject($path);
        } catch (ObsException $exception) {
            return false;
        }

        return compact('contents', 'path');
    }

    /**
     * read a file stream.
     *
     * @param string $path
     *
     * @return array|bool|false
     */
    public function readStream($path)
    {
        try {
            $stream = $this->getObject($path);
        } catch (ObsException $exception) {
            return false;
        }

        return compact('stream', 'path');
    }

    /**
     * Lists all files in the directory.
     *
     * @param string $directory
     * @param bool   $recursive
     *
     * @return array
     *
     * @throws ObsException
     */
    public function listContents($directory = '', $recursive = false)
    {
        $list = [];

        $result = $this->listDirObjects($directory, true);

        if (!empty($result['objects'])) {
            foreach ($result['objects'] as $files) {
                if (!$fileInfo = $this->normalizeFileInfo($files)) {
                    continue;
                }

                $list[] = $fileInfo;
            }
        }

        return $list;
    }

    /**
     * get meta data.
     *
     * @param string $path
     *
     * @return array|bool|false
     */
    public function getMetadata($path)
    {
        $path = $this->applyPathPrefix($path);

        try {
            $metadata = $this->client->getObjectMetadata([
                'Bucket' => $this->bucket,
                'Key' => $path
            ])->toArray();
        } catch (ObsException $exception) {
            return false;
        }

        return $metadata;
    }

    /**
     * get the size of file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getSize($path)
    {
        return $this->normalizeFileInfo(['Key' => $path]);
    }

    /**
     * get mime type.
     *
     * @param string $path
     *
     * @return array|bool|false
     */
    public function getMimetype($path)
    {
        if (!$fileInfo = $this->normalizeFileInfo(['Key' => $path])) {
            return false;
        }

        return ['mimetype' => $fileInfo['type']];
    }

    /**
     * get timestamp.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getTimestamp($path)
    {
        return $this->normalizeFileInfo(['Key' => $path]);
    }

    /**
     * normalize Host.
     *
     * @return string
     */
    protected function normalizeHost()
    {
        if ($this->isCName) {
            $domain = $this->endpoint;
        } else {
            $domain = $this->bucket.'.'.$this->endpoint;
        }

        if (0 !== stripos($domain, 'https://') && 0 !== stripos($domain, 'http://')) {
            $domain = "http://{$domain}";
        }

        return rtrim($domain, '/').'/';
    }

    /**
     * Read an object from the ObsClient.
     *
     * @param $path
     *
     * @return string
     */
    protected function getObject($path)
    {
        $path = $this->applyPathPrefix($path);

        return $this->client->getObjectMetadata([
            'Bucket' => $this->bucket,
            'Key' => $path
        ]);
    }

    /**
     * File list core method.
     *
     * @param string $dirname
     * @param bool   $recursive
     *
     * @return array
     *
     * @throws ObsException
     */
    public function listDirObjects($dirname = '', $recursive = false)
    {
        $delimiter = '/';
        $nextMarker = '';
        $maxkeys = 1000;

        $result = [];

        while (true) {
            $options = [
                'delimiter' => $delimiter,
                'prefix' => $dirname,
                'max-keys' => $maxkeys,
                'marker' => $nextMarker,
            ];

            try {
                $listObjectInfo = $this->client->listObjects($this->bucket, $options);
            } catch (ObsException $exception) {
                throw $exception;
            }

            $nextMarker = $listObjectInfo->getNextMarker();
            $objectList = $listObjectInfo->getObjectList();
            $prefixList = $listObjectInfo->getPrefixList();

            if (!empty($objectList)) {
                foreach ($objectList as $objectInfo) {
                    $object['Prefix'] = $dirname;
                    $object['Key'] = $objectInfo->getKey();
                    $object['LastModified'] = $objectInfo->getLastModified();
                    $object['eTag'] = $objectInfo->getETag();
                    $object['Type'] = $objectInfo->getType();
                    $object['Size'] = $objectInfo->getSize();
                    $object['StorageClass'] = $objectInfo->getStorageClass();
                    $result['objects'][] = $object;
                }
            } else {
                $result['objects'] = [];
            }

            if (!empty($prefixList)) {
                foreach ($prefixList as $prefixInfo) {
                    $result['prefix'][] = $prefixInfo->getPrefix();
                }
            } else {
                $result['prefix'] = [];
            }

            // Recursive directory
            if ($recursive) {
                foreach ($result['prefix'] as $prefix) {
                    $next = $this->listDirObjects($prefix, $recursive);
                    $result['objects'] = array_merge($result['objects'], $next['objects']);
                }
            }

            if ('' === $nextMarker) {
                break;
            }
        }

        return $result;
    }

    /**
     * normalize file info.
     *
     * @param array $stats
     *
     * @return array
     */
    protected function normalizeFileInfo(array $stats)
    {
        $filePath = ltrim($stats['Key'], '/');

        $meta = $this->getMetadata($filePath) ?? [];

        if (empty($meta)) {
            return [];
        }

        return [
            'type' => $meta['content-type'],
            'path' => $filePath,
            'timestamp' => $meta['info']['filetime'],
            'size' => $meta['content-length'],
        ];
    }
}