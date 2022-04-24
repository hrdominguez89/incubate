<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use Aws\Credentials\Credentials;
use App\Http\Requests;

class ApiDownloadController extends Controller {

    /**
     * donwload archives
     * @param type $file
     */
    public function download($file) {
        try {
            $credentials = new Credentials(env('MINIO_KEY'), env('MINIO_SECRET'));
            $client = new S3Client([
                'credentials' => $credentials,
                'region' => 'us-west-2',
                'version' => "latest",
                'bucket_endpoint' => false,
                'use_path_style_endpoint' => true,
                'endpoint' => env('MINIO_ENDPOINT'),
                'http' => [
                    'verify' => false
                ]
            ]);
            $result = $client->getObject([
                'Bucket' => env('MINIO_BUCKET'),
                'Key' => $file
            ]);
            if (isset($result)) {
                header("Content-Type: {$result['ContentType']}");
                echo $result['Body'];
            } else {
                die();
            }
        } catch (Exception $e) {
            return false;
        }
    }

}
