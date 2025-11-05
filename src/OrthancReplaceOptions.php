<?php

namespace Plokko\LaravelOrthancRestApi;

use JsonSerializable;

/**
 * @see https://orthanc.uclouvain.be/book/users/anonymization.html
 */
class OrthancReplaceOptions implements JsonSerializable
{
    public function __construct(
        public array $Replace = [],
        public array $Remove = [],
        public array $Keep = [],
        public ?bool $RemovePrivateTags = null,
        public ?bool $Force = null,
        public ?bool $KeepPrivateTags = null,
        public ?string $Transcode = null
    ) {}

    public function jsonSerialize(): array
    {
        $data = [];

        foreach (['Replace', 'Remove', 'Keep'] as $key) {
            if (! empty($this->$key)) {
                $data[$key] = $this->$key;
            }
        }
        foreach (['RemovePrivateTags', 'Force', 'Transcode', 'KeepPrivateTags'] as $key) {
            if ($this->$key !== null) {
                $data[$key] = $this->$key;
            }
        }

        return $data;
    }

    public function getData(): object
    {
        return (object) $this->jsonSerialize();
    }
}
