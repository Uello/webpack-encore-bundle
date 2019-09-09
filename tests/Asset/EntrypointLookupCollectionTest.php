<?php

/*
 * This file is part of the Symfony WebpackEncoreBundle package.
 * (c) Fabien Potencier <fabien@symfony.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Uello\WebpackEncoreBundle\Tests\Asset;

use Symfony\Component\DependencyInjection\ServiceLocator;
use Uello\WebpackEncoreBundle\Asset\EntrypointLookupCollection;
use PHPUnit\Framework\TestCase;
use Uello\WebpackEncoreBundle\Asset\EntrypointLookupInterface;

class EntrypointLookupCollectionTest extends TestCase
{
    /**
     * @expectedException \Uello\WebpackEncoreBundle\Exception\UndefinedBuildException
     * @expectedExceptionMessage The build "something" is not configured
     */
    public function testExceptionOnMissingEntry()
    {
        $collection = new EntrypointLookupCollection(new ServiceLocator([]));
        $collection->getEntrypointLookup('something');
    }

    /**
     * @expectedException \Uello\WebpackEncoreBundle\Exception\UndefinedBuildException
     * @expectedExceptionMessage There is no default build configured: please pass an argument to getEntrypointLookup().
     */
    public function testExceptionOnMissingDefaultBuildEntry()
    {
        $collection = new EntrypointLookupCollection(new ServiceLocator([]));
        $collection->getEntrypointLookup();
    }

    public function testDefaultBuildIsReturned()
    {
        $lookup = $this->createMock(EntrypointLookupInterface::class);
        $collection = new EntrypointLookupCollection(new ServiceLocator(['the_default' => function () use ($lookup) { return $lookup; }]), 'the_default');

        $this->assertSame($lookup, $collection->getEntrypointLookup());
    }
}
