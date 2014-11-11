<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wsza\Bundle\ReportBundle\Serializer;


use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;
use Wsza\Bundle\ReportBundle\Entity\BaseEntity;
use Wsza\Bundle\ReportBundle\Entity\Client;

class ForeignKeyHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        return array(
            array(
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => 'Wsza\Bundle\ReportBundle\Serializer\ForeignKeyType',
                'method' => 'serializeDateTimeToJson',
            )
        );
    }

    public function serializeDateTimeToJson(JsonSerializationVisitor $visitor, $entity, array $type, Context $context)
    {
        return $entity->getId();
    }
}
