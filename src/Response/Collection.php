<?php
/**
 * SocialConnect project
 * @author: Patsura Dmitry @ovr <talk@dmtry.me>
 */

namespace SocialConnect\Vk\Response;

class Collection implements \Countable
{
    /**
     * @var integer
     */
    protected $total;

    protected $loadCallback;

    /**
     * @var array
     */
    protected $elements = array();

    /**
     * @param $elements
     * @param $total
     * @param $loadCallback
     */
    public function __construct($elements, $total, $loadCallback)
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
}
