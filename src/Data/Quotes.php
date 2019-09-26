<?php

namespace Orkhanahmadov\Currencylayer\Data;

class Quotes
{
    /**
     * @var string
     */
    private $source;
    /**
     * @var array
     */
    private $quotes;
    /**
     * @var int
     */
    private $timestamp;
    /**
     * @var \DateTimeInterface|null
     */
    private $date = null;

    /**
     * Currency constructor.
     *
     * @param array $data
     *
     * @throws \Exception
     */
    public function __construct(array $data)
    {
        $this->source = $data['source'];
        $this->quotes = $data['quotes'];
        $this->timestamp = $data['timestamp'];
        $this->date = isset($data['date']) ? new \DateTimeImmutable($data['date']) : null;
    }

    /**
     * @return string
     */
    public function source(): string
    {
        return $this->source;
    }

    /**
     * @return array
     */
    public function quotes(): array
    {
        return $this->quotes;
    }

    /**
     * @return int
     */
    public function timestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function date(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param string $name
     *
     * @return float
     */
    public function __get(string $name): float
    {
        $key = $this->source.$name;
        if (!array_key_exists($key, $this->quotes)) {
            throw new \InvalidArgumentException("{$name} does not exist in API response. Did you put it in request?");
        }

        return $this->quotes[$key];
    }
}
