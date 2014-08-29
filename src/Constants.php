<?php
/**
 * SocialConnect project
 * @author: Patsura Dmitry @ovr <talk@dmtry.me>
 */

namespace SocialConnect\Vk;

/**
 * BC with PHP <= 5.6
 *
 * Class Constants
 * @package SocialConnect\Vk
 */
trait Constants
{
    public $USER_DEFAULT_FIELDS = array(
        'id',
        'first_name',
        'last_name',
    );

    public $USER_ALL_FIELDS = array(
        'id',
        'first_name',
        'last_name',
        'deactivated',
        'verified',
        'blacklisted',
        'country',
        'home_town',
        'city',
        'bdate',
        'sex',
        'blacklisted',
        'domain',
        'has_mobile',
        'contacts',
        'site',
        'education',
        'universities',
        'schools',
        'status',
        'last_seen',
        'followers_count',
        'common_count',
        'counters',
        'photo_50',
        'photo_100',
        'photo_200_orig',
        'photo_200',
        'photo_400_orig',
        'photo_max',
        'photo_max_orig',
        'online',
        'lists',
        'occupation'
    );
}