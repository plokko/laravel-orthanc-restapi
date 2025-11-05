<?php

namespace Plokko\LaravelOrthancRestApi\Accessors;

use Plokko\LaravelOrthancRestApi\OrthancApiAccessor;

class InstancesAccessor extends BaseEntityAccessor
{
    public function __construct(OrthancApiAccessor $accessor)
    {
        parent::__construct($accessor, 'instances');
    }

    /**
     * Upload DICOM instances.
     *
     * @see https://orthanc.uclouvain.be/book/users/rest.html#sending-dicom-images
     *
     * @param  string  $dicomFilePath  Path for the zip file containing the DICOM images.
     */
    public function upload(string $dicomFilePath): void
    {
        $file = fopen($dicomFilePath, 'r');

        $response = $this->accessor->getClient()
            ->attach('dicom-images', $file, basename($dicomFilePath))
            ->timeout($this->config['upload_timeout'] ?? 300)
            ->post('instances');

        $response->throw();
    }
}
