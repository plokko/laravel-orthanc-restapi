<?php

namespace Plokko\LaravelOrthancRestApi\Accessors;

use Plokko\LaravelOrthancRestApi\OrthancApiAccessor;

class SeriesAccessor extends BaseEntityAccessor
{
    public function __construct(OrthancApiAccessor $accessor)
    {
        parent::__construct($accessor, 'series');
    }

    /**
     * Series are identified as the SHA-1 hash of the concatenation of their PatientID tag (0010,0020), their StudyInstanceUID tag (0020,000d) and their SeriesInstanceUID tag (0020,000e).
     *
     * @see https://orthanc.uclouvain.be/book/faq/orthanc-ids.html
     *
     * @param  string  $patientId  Patient id, ex: "RIS-12345" (tag (0010,0020))
     * @param  string  $studyInstanceUID  StudyInstanceUID, ex '1.2.3.1.4.1.12345.1.1.10.123....'
     * @param  string  $seriesInstanceUID  SeriesInstanceUID, DICOM tag (0020,000e).
     */
    public function calculateOrthancIdentifier(string $patientId, string $studyInstanceUID, string $seriesInstanceUID): string
    {
        return self::orthancSha1([$patientId, $studyInstanceUID, $seriesInstanceUID]);
    }
}
