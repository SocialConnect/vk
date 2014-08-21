<?php
/**
 * SocialConnect project
 * @author: Patsura Dmitry @ovr <talk@dmtry.me>
 */

namespace SocialConnect\Vk\Entity;

/**
 * Class Audio
 * @package SocialConnect\Vk\Entity
 */
class Audio
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $ownerId;

    /**
     * @var string
     */
    public $artist;

    /**
     * @var string
     */
    public $title;

    /**
     * @var mixed
     */
    public $duration;

    /**
     * @var mixed
     */
    public $url;

    /**
     * @var integer
     */
    public $lyricsId;

    /**
     * @var integer
     */
    public $genreId;
}
