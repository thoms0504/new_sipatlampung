<?php
namespace App\Config;

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Config\MinIOConfig;

class MinIOUploader {
    private $s3Client;
    private $bucket;

    public function __construct()
    {
        $config = new MinIOConfig();

        $this->s3Client = new S3Client([
            'version' => 'latest',
            'region'  => $config->region,
            'endpoint' => $config->endpoint,
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key'    => $config->access_key,
                'secret' => $config->secret_key
            ]
        ]);

        $this->bucket = $config->bucket;
    }

    public function uploadFile($localFilePath, $objectKey)
    {
        try {
            $result = $this->s3Client->putObject([
                'Bucket' =>$this->bucket,
                'Key' => 'file/' . $objectKey,
                'SourceFile' => $localFilePath,
                'ACL' =>"private"
            ]);

            return [
                'success' => true,
                'url' => $result['ObjectURL'] ?? null
            ];
        } catch (AwsException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function deleteFile($objectKey)
{
    try {
        $this->s3Client->deleteObject([
            'Bucket' => $this->bucket,
            'Key'    => 'file/' . $objectKey
        ]);

        return ['success' => true];
    } catch (AwsException $e) {
        $errorCode = $e->getAwsErrorCode();
        $errorMessage = $e->getAwsErrorMessage();
        return [
            'success' => false,
            'error' => "Error deleting file: ($errorCode) $errorMessage"
        ];
    } catch (\Exception $e) {
        return [
            'success' => false,
            'error' => "Unexpected error deleting file: " . $e->getMessage()
        ];
    }
}

    public function getFileUrl($objectKey)
    {
        try {
            $cmd = $this->s3Client->getCommand('GetObject', [
                'Bucket' => $this->bucket,
                'Key'    => 'file/' . $objectKey
            ]);

            $request = $this->s3Client->createPresignedRequest($cmd, '+20 minutes');
            return (string) $request->getUri();
        } catch (AwsException $e) {
            return null;
        }
    }

    public function fileExists($objectKey)
    {
        try {
            $result = $this->s3Client->headObject([
                'Bucket' => $this->bucket,
                'Key'    => 'file/' . $objectKey
            ]);

            return true;
        } catch (AwsException $e) {
            return false;
        }
    }
}