<?php
/**
 * SocialConnect project
 * @author: Patsura Dmitry @ovr <talk@dmtry.me>
 */

namespace SocialConnect\Vk\Entity;

class Group extends \stdClass
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $name;

    /**
     * @var boolean|integer
     */
    public $closed = 0;

    /**
     * @var string
     */
    public $type;
}
