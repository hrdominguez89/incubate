<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Aws\S3\S3Client;
use Aws\Credentials\Credentials;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use Storage;

class MinIOStorageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      Storage::extend('minio', function ($app, $config) {

          $credentials = new Credentials($config["key"],$config["secret"]);

          $client = new S3Client([
              'credentials' =>$credentials,
              'region'      => $config["region"],
              'version'     => "latest",
              'bucket_endpoint' => false,
              'use_path_style_endpoint' => true,
              'endpoint'    => $config["endpoint"],
              'http'=>[
                'verify'=>false
              ]
          ]);
          $options = [
              'override_visibility_on_copy' => true
          ];
          return new Filesystem(new AwsS3Adapter($client, $config["bucket"], '', $options));
      });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}