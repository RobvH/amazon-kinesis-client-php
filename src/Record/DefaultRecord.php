<?php

namespace Robvh\Kcl\Record;

class DefaultRecord extends Record
{
    /**
     * @var string
     */
    private $sequenceNumber;
    /**
     * @var string
     */
    private $partitionKey;
    /**
     * @var string
     */
    private $raw;
    /**
     * @var mixed
     */
    private $data;

    public function __construct(string $sequenceNumber, string $partitionKey, string $data)
    {
        $this->sequenceNumber = $sequenceNumber;
        $this->partitionKey = $partitionKey;
        $this->raw = $data;
    }

    /**
     * @throws RecordDecodeException
     *
     * @return mixed data Data may be binary
     */
    public function getData()
    {
        if (is_null($this->data)) {
            $this->decodeData();
        }

        return $this->data;
    }

    private function decodeData()
    {
        $this->data = base64_decode($this->raw);

        if ($this->data === false) {
            throw new RecordDecodeException();
        }

        $this->raw = null;
    }

    /**
     * @return string
     */
    public function getPartitionKey(): string
    {
        return $this->partitionKey;
    }

    /**
     * @return string
     */
    public function getSequenceNumber(): string
    {
        return $this->sequenceNumber;
    }
}
