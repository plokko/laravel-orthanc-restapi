<?php

namespace Plokko\LaravelOrthancRestApi;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Plokko\LaravelOrthancRestApi\Accessors\InstancesAccessor;
use Plokko\LaravelOrthancRestApi\Accessors\PatientsAccessor;
use Plokko\LaravelOrthancRestApi\Accessors\SeriesAccessor;
use Plokko\LaravelOrthancRestApi\Accessors\StudiesAccessor;

/**
 * @see https://orthanc.uclouvain.be/book/users/rest.html
 * @see https://orthanc.uclouvain.be/api/
 */
class OrthancApiAccessor
{
    protected string $serverName = 'default';

    protected array $server;

    public function __construct(public readonly array $config = [])
    {
        $this->server($this->config['default-server'] ?? 'default');
    }

    /**
     * Set server name
     *
     * @return $this
     */
    public function server(string $serverName): OrthancApiAccessor
    {
        if (empty($this->config['servers'][$serverName])) {
            throw new \Exception("Orthanc server not found in config: $serverName");
        }
        $this->serverName = $serverName;
        $this->server = $this->config['servers'][$serverName];

        return $this;
    }

    public function studies(): StudiesAccessor
    {
        return new StudiesAccessor($this);
    }

    public function instances(): InstancesAccessor
    {
        return new InstancesAccessor($this);
    }

    public function series(): SeriesAccessor
    {
        return new SeriesAccessor($this);
    }

    public function patients(): PatientsAccessor
    {
        return new PatientsAccessor($this);
    }

    /**
     * Get the HTTP client instance.
     *
     * @internal
     */
    public function getClient(): PendingRequest
    {
        return Http::acceptJson()
            ->baseUrl($this->server['address'])
            ->withToken($this->getToken())
            ->withOptions([
                'debug' => $this->config['debug'] ?? false,
            ]);
    }

    /**
     * Get the Authentication token from cache or via API login.
     *
     * @internal
     */
    protected function getToken(): string
    {
        return OrthancApiAuthInterface::getToken($this->serverName);
    }
}
