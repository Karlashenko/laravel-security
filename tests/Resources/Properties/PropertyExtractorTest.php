<?php

declare(strict_types=1);

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\ResourceDescriptions\Properties\PropertyHydrator;
use App\ResourceDescriptions\Properties\PropertyFactory;
use App\ResourceDescriptions\ResourceFactory;
use Tests\TestCase;

class PropertyExtractorTest extends TestCase
{
    public function testExtract(): void
    {
        $properties = new PropertyFactory(new ResourceFactory());

        $object = new \StdClass();
        $object->id = 123;
        $object->datetime = Carbon::parse('2017-09-14T12:20:00+03:00')->toDayDateTimeString();
        $object->collection = new Collection([
            (object) ['id' => 1, 'name' => 'One'],
            (object) ['id' => 2, 'name' => 'Two'],
            (object) ['id' => 3, 'name' => 'Three'],
        ]);

        $extractor = new PropertyHydrator();
        $resource = new ParentResourceDescription();

        $values = $extractor->extract($object, $resource->propertyDescription($properties));

        $expected = [
            'id' => 123,
            'datetime' => '2017-09-14T12:20:00+03:00',
            'collection' => [
                0 => ['id' => 1, 'name' => 'One'],
                1 => ['id' => 2, 'name' => 'Two'],
                2 => ['id' => 3, 'name' => 'Three']
            ]
        ];

        $this->assertEquals($expected, $values);
    }
}

class ParentResourceDescription extends \App\ResourceDescriptions\ResourceDescription
{
    public function propertyDescription(PropertyFactory $properties): array
    {
        return [
            'id' => $properties->readableProperty('id'),
            'datetime' => $properties->readableDynamicProperty(function ($object) {
                return Carbon::parse($object->datetime)->format(Carbon::RFC3339);
            }),
            'collection' => $properties->readableResourceCollectionProperty(ChildResourceDescription::class, 'collection'),
        ];
    }
}

class ChildResourceDescription extends \App\ResourceDescriptions\ResourceDescription
{
    public function propertyDescription(PropertyFactory $properties): array
    {
        return [
            'id' => $properties->readableProperty('id'),
            'name' => $properties->readableProperty('name'),
        ];
    }
}
