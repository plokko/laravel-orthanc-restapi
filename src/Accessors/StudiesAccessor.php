<?php

namespace Plokko\LaravelOrthancRestApi\Accessors;

use Plokko\LaravelOrthancRestApi\OrthancApiAccessor;

class StudiesAccessor extends BaseEntityAccessor
{
    public function __construct(OrthancApiAccessor $accessor)
    {
        parent::__construct($accessor, 'studies');
    }

    /**
     * Studies are identified as the SHA-1 hash of the concatenation of their PatientID tag (0010,0020) and their StudyInstanceUID tag (0020,000d).
     *
     * @see https://orthanc.uclouvain.be/book/faq/orthanc-ids.html
     *
     * @param  string  $patientId  Patient id, ex: "RIS-12345" (tag (0010,0020))
     * @param  string  $StudyInstanceUID  StudyInstanceUID, ex '1.2.3.1.4.1.12345.1.1.10.123....'
     */
    public function calculateOrthancIdentifier(string $patientId, string $studyInstanceUID): string
    {
        return self::orthancSha1([$patientId, $studyInstanceUID]);
    }
}
