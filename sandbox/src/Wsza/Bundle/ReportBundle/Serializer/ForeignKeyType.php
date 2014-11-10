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


use Sonata\CoreBundle\Serializer\BaseSerializerHandler;

class ForeignKeyType extends BaseSerializerHandler
{
    public static function getType()
    {
        return 'my_handler';
    }

}
