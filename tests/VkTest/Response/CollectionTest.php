<?php
/**
 * SocialConnect project
 * @author: Patsura Dmitry @ovr <talk@dmtry.me>
 */

namespace VkTest\Response;

use SocialConnect\Vk\Response\Collection;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testIterator()
    {
        $collection = new Collection(array(
            (object)array(
                'id' => '1'
            ),
            (object)array(
                'id' => '2'
            ),
            (object)array(
                'id' => '3'
            ),
        ), 3, function () {
        });

        $this->assertEquals(3, $collection->count());

        $count = 0;
        foreach ($collection as $key => $value) {
            $count++;
        }
        $this->assertEquals(3, $count);
    }
}
