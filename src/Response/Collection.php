<?php
/**
     * SocialConnect project
     * @author: Patsura Dmitry @ovr <talk@dmtry.me>
     */

namespace SocialConnect\Vk\Response;

use Closure;

class Collection implements \Iterator, \Countable
{
    /**
     * @var integer
     */
    protected $total;

    /**
     * @var Closure
     */
    protected $loadCallback;

    /**
     * @var array
     */
    protected $elements;

    /**
     * @param array $elements
     * @param integer $total
     * @param Closure $loadCallback
     */
    public function __construct(array $elements, $total, Closure $loadCallback)
    {
        $this->elements = $elements;
        $this->total = $total;
        $this->loadCallback = $loadCallback;
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->total;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->elements;
    }

    /**
     * Set position to first element and return this element
     *
     * @return mixed
     */
    public function first()
    {
        return reset($this->elements);
    }

    /**
     * @return mixed
     */
    public function last()
    {
        return end($this->elements);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->elements);
    }

    /**
     * @return mixed
     */
    public function next()
    {
        return next($this->elements);
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->elements);
    }

    /**
     * Set position to first element
     */
    public function rewind()
    {
        reset($this->elements);
    }

    /**
     * @return bool|void
     */
    public function valid()
    {
        return $this->current();
    }
}
