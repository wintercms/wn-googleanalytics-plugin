<?php namespace Winter\GoogleAnalytics\Classes;

use Psr\Cache\CacheItemInterface;
use DateTimeInterface;
use DateInterval;
use DateTime;

class CacheItem implements CacheItemInterface
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var mixed|null
     */
    protected $value;

    /**
     * @var bool
     */
    protected $hit;

    /**
     * @var \DateTimeInterface|\DateInterval|int
     */
    protected $expires;

    /**
     * @param string $key
     * @param mixed $value
     * @param bool $hit
     */
    public function __construct($key, $value = null, $hit = false)
    {
        $this->key = $key;
        $this->value = $value;
        $this->hit = boolval($hit);
    }

    /**
     * {@inheritdoc}
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * {@inheritdoc}
     */
    public function get(): mixed
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function isHit(): bool
    {
        return $this->hit;
    }

    /**
     * {@inheritdoc}
     */
    public function set(mixed $value): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function expiresAt(?DateTimeInterface $expiration): static
    {
        $this->expires = $expiration;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function expiresAfter(int|DateInterval|null $time): static
    {
        $this->expires = $time;

        return $this;
    }

    /**
     * @return int|null
     *   The amount of minutes this item should stay alive. Or null when no expires is given.
     */
    public function getTTL()
    {
        if (is_int($this->expires)) {
            return floor($this->expires / 60.0);
        }

        if ($this->expires instanceof DateTimeInterface) {
            $diff = (new DateTime())->diff($this->expires);

            return boolval($diff->invert) ? 0 : $diff->i;
        }

        if ($this->expires instanceof DateInterval) {
            return boolval($this->expires->invert) ? 0 : $this->expires->i;
        }
    }
}
