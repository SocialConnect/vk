<?php
/**
 * SocialConnect project
 * @author: Patsura Dmitry @ovr <talk@dmtry.me>
 */

namespace SocialConnect\Vk\Entity;

/**
 * @link http://vk.com/dev/fields
 *
 * Class User
 * @package SocialConnect\Vk\Entity
 */
class User extends \SocialConnect\Common\Entity\User
{
    /**
     * @var bool
     */
    public $deactivated = false;

    /**
     * @var bool
     */
    public $hidden = false;
}
