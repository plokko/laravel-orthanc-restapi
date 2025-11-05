<?php

namespace Plokko\LaravelOrthancRestApi\Accessors;

use Plokko\LaravelOrthancRestApi\OrthancApiAccessor;

class PatientsAccessor extends BaseEntityAccessor
{
    public function __construct(OrthancApiAccessor $accessor)
    {
        parent::__construct($accessor, 'patients');
    }

    /**
     * Patients are identified as the SHA-1 hash of their PatientID tag (0010,0020).
     *
     * @see https://orthanc.uclouvain.be/book/faq/orthanc-ids.html
     *
     * @param  string  $patientId  patient id, ex: "RIS-12345" (tag (0010,0020))
     */
    public function calculateOrthancIdentifier(string $patientId): string
    {
        return self::orthancSha1($patientId);
    }
}
