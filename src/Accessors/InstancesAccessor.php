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

    /**
     * Instances are identified as the SHA-1 hash of the concatenation of their PatientID tag (0010,0020), their StudyInstanceUID tag (0020,000d), their SeriesInstanceUID tag (0020,000e), and their SOPInstanceUID tag (0008,0018).
     *
     * @see https://orthanc.uclouvain.be/book/faq/orthanc-ids.html
     *
     * @param  string  $patientId  Patient id, ex: "RIS-12345" (tag (0010,0020))
     * @param  string  $studyInstanceUID  StudyInstanceUID, ex '1.2.3.1.4.1.12345.1.1.10.123....'
     * @param  string  $seriesInstanceUID  SeriesInstanceUID, DICOM tag (0020,000e).
     * @param  string  $sopInstanceUID  SeriesInstanceUID, DICOM tag (0008,0018).
     */
    public function calculateOrthancIdentifier(string $patientId, string $studyInstanceUID, string $seriesInstanceUID, string $sopInstanceUID): string
    {
        return self::orthancSha1([$patientId, $studyInstanceUID, $seriesInstanceUID, $sopInstanceUID]);
    }
}
