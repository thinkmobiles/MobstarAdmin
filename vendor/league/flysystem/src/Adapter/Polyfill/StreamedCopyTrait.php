<?php

namespace League\Flysystem\Adapter\Polyfill;

use League\Flysystem\Config;

trait StreamedCopyTrait
{
    /**
     * Copy a file
     *
     * @param   string  $path
     * @param   string  $newpath
     * @return  boolean
     */
    public function copy($path, $newpath)
    {
        $response = $this->readStream($path);

        if ($response === false || ! is_resource($response['stream'])) {
            return false;
        }

        $result = $this->writeStream($newpath, $response['stream'], new Config());

        if (is_resource($response['stream'])) {
            fclose($response['stream']);
        }

        return (boolean) $result;
    }

    // Required abstract method

    /**
     * @param string $path
     */
    abstract public function readStream($path);

    /**
     * @param string $path
     */
    abstract public function writeStream($path, $resource, Config $config);
}
