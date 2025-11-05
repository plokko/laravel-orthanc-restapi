<?php

namespace Plokko\LaravelOrthancRestApi\Accessors;

use Plokko\LaravelOrthancRestApi\OrthancApiAccessor;
use Plokko\LaravelOrthancRestApi\OrthancReplaceOptions;

abstract class BaseEntityAccessor
{
    public function __construct(
        protected OrthancApiAccessor $accessor,
        public readonly string $entityName
    ) {}

    /**
     * Anonymize entity
     *
     * @see https://orthanc.uclouvain.be/book/users/anonymization.html#id2
     *
     * @param  string  $uuid  entity UUID
     * @param OrthancReplaceOptions Data to be replaced
     */
    public function anonymize(string $uuid, OrthancReplaceOptions $options = new OrthancReplaceOptions()): void
    {
        $response = $this->accessor->getClient()
            ->post("{$this->entityName}/$uuid/anonymize", $options->getData());

        $response->throw();
    }

    /**
     * Delete an entity from the server.
     *
     * @param  string  $uuid  entity UUID
     */
    public function delete(string $uuid): void
    {
        $response = $this->accessor->getClient()
            ->delete("{$this->entityName}/$uuid");

        $response->throw();
    }

    /**
     * Edit entity data
     *
     * @param  string  $uuid  entity UUID
     * @param  OrthancReplaceOptions  $options  Data to be replaced
     */
    public function edit(string $uuid, OrthancReplaceOptions $options = new OrthancReplaceOptions()): void
    {
        $response = $this->accessor->getClient()
            ->post("{$this->entityName}/$uuid/modify", $options->getData());
        $response->throw();
    }

    /**
     * List entities from Orthanc server.
     *
     * @return array array of entities
     */
    public function list(): array
    {
        $response = $this->accessor->getClient()->get($this->entityName);
        $response->throw();

        return $response->json();
    }
}
