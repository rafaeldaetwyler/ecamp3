<?php

namespace eCamp\CoreTest\Hydrator;

use eCamp\Core\Entity\CampType;
use eCamp\Core\Entity\Organization;
use eCamp\Core\Hydrator\CampTypeHydrator;
use eCamp\LibTest\PHPUnit\AbstractTestCase;

/**
 * @internal
 */
class CampTypeHydratorTest extends AbstractTestCase {
    public function testExtract() {
        $organization = new Organization();
        $campType = new CampType();
        $campType->setName('name');
        $campType->setIsJS(true);
        $campType->setIsCourse(true);
        $campType->setOrganization($organization);

        $hydrator = new CampTypeHydrator();
        $data = $hydrator->extract($campType);

        $this->assertEquals('name', $data['name']);
        $this->assertTrue($data['isJS']);
        $this->assertTrue($data['isCourse']);

        // Wie muss das korrekt verglichen werden?
        // ($data['organization'] ist ein LinkEntity
        // $this->assertEquals($organization, $data['organization']);
    }

    public function testHydrate() {
        $organization = new Organization();
        $campType = new CampType();
        $data = [
            'name' => 'name',
            'isJS' => true,
            'isCourse' => true,
            'organization' => $organization,
        ];

        $hydrator = new CampTypeHydrator();
        $hydrator->hydrate($data, $campType);

        $this->assertEquals('name', $campType->getName());
        $this->assertTrue($campType->getIsJS());
        $this->assertTrue($campType->getIsCourse());
        $this->assertEquals($organization, $campType->getOrganization());
    }
}
