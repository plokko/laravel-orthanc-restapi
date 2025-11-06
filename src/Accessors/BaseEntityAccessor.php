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
     * Catch 404 errors from API and return false.
     *
     * @return bool true if successfull, false if not found. Throws exception in other cases
     **/
    protected function handle404Response($response): bool
    {
        if ($response->successful()) {
            return true;
        }
        if ($response->status() !== 404) {
            $response->throw();
        }

        return false;
    }

    /**
     * Anonymize entity
     *
     * @see https://orthanc.uclouvain.be/book/users/anonymization.html#id2
     *
     * @param  string  $uuid  entity UUID
     * @param OrthancReplaceOptions Data to be replaced
     * @return bool true if successfull, false if not found
     */
    public function anonymize(string $uuid, OrthancReplaceOptions $options = new OrthancReplaceOptions()): bool
    {
        $response = $this->accessor->getClient()
            ->post("{$this->entityName}/$uuid/anonymize", $options->getData());

        return $this->handle404Response($response);
    }

    /**
     * Delete an entity from the server.
     *
     * @param  string  $uuid  entity UUID
     * @return bool true if successfull, false if not found
     */
    public function delete(string $uuid): bool
    {
        $response = $this->accessor->getClient()
            ->delete("{$this->entityName}/$uuid");

        return $this->handle404Response($response);
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

    public static function orthancSha1(string|array $value): string
    {
        $sha1 = sha1(is_array($value) ? implode('|', $value) : $value);

        return implode('-', str_split($sha1, 8));
    }
}
