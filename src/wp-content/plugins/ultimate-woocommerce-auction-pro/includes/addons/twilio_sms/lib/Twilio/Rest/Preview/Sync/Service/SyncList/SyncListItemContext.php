<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Preview
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */


namespace Twilio\Rest\Preview\Sync\Service\SyncList;

use Twilio\Exceptions\TwilioException;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;
use Twilio\Serialize;


class SyncListItemContext extends InstanceContext
    {
    /**
     * Initialize the SyncListItemContext
     *
     * @param Version $version Version that contains the resource
     * @param string $serviceSid 
     * @param string $listSid 
     * @param int $index 
     */
    public function __construct(
        Version $version,
        $serviceSid,
        $listSid,
        $index
    ) {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
        'serviceSid' =>
            $serviceSid,
        'listSid' =>
            $listSid,
        'index' =>
            $index,
        ];

        $this->uri = '/Services/' . \rawurlencode($serviceSid)
        .'/Lists/' . \rawurlencode($listSid)
        .'/Items/' . \rawurlencode($index)
        .'';
    }

    /**
     * Delete the SyncListItemInstance
     *
     * @param array|Options $options Optional Arguments
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(array $options = []): bool
    {

        $options = new Values($options);

        $headers = Values::of(['If-Match' => $options['ifMatch']]);

        return $this->version->delete('DELETE', $this->uri, [], [], $headers);
    }


    /**
     * Fetch the SyncListItemInstance
     *
     * @return SyncListItemInstance Fetched SyncListItemInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): SyncListItemInstance
    {

        $payload = $this->version->fetch('GET', $this->uri);

        return new SyncListItemInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['listSid'],
            $this->solution['index']
        );
    }


    /**
     * Update the SyncListItemInstance
     *
     * @param array $data 
     * @param array|Options $options Optional Arguments
     * @return SyncListItemInstance Updated SyncListItemInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(array $data, array $options = []): SyncListItemInstance
    {

        $options = new Values($options);

        $data = Values::of([
            'Data' =>
                Serialize::jsonObject($data),
        ]);

        $headers = Values::of(['If-Match' => $options['ifMatch']]);

        $payload = $this->version->update('POST', $this->uri, [], $data, $headers);

        return new SyncListItemInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['listSid'],
            $this->solution['index']
        );
    }


    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.Sync.SyncListItemContext ' . \implode(' ', $context) . ']';
    }
}
