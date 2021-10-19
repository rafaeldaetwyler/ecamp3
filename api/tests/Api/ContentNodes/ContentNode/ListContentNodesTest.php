<?php

namespace App\Tests\Api\ContentNodes\ContentNode;

use App\Tests\Api\ECampApiTestCase;

/**
 * @internal
 */
class ListContentNodesTest extends ECampApiTestCase {
    // TODO security tests when not logged in or not collaborator

    public function testListContentNodesIsAllowedForCollaborator() {
        $response = static::createClientWithCredentials()->request('GET', '/content_nodes');
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'totalItems' => 13,
            '_links' => [
                'items' => [],
            ],
            '_embedded' => [
                'items' => [],
            ],
        ]);
        $this->assertEqualsCanonicalizing([
            ['href' => $this->getIriFor('columnLayout1')],
            ['href' => $this->getIriFor('columnLayout2')],
            ['href' => $this->getIriFor('columnLayoutChild1')],
            ['href' => $this->getIriFor('columnLayout3')],
            ['href' => $this->getIriFor('columnLayout4')],
            ['href' => $this->getIriFor('columnLayout2camp2')],
            ['href' => $this->getIriFor('columnLayout1campPrototype')],
            ['href' => $this->getIriFor('columnLayout2campPrototype')],
            ['href' => $this->getIriFor('singleText1')],
            ['href' => $this->getIriFor('singleText2')],
            ['href' => $this->getIriFor('materialNode1')],
            ['href' => $this->getIriFor('materialNode2')],
            ['href' => $this->getIriFor('storyboard1')],
        ], $response->toArray()['_links']['items']);
    }

    public function testListContentNodesFilteredByParentIsAllowedForCollaborator() {
        $parent = static::$fixtures['columnLayout1'];
        $response = static::createClientWithCredentials()->request('GET', '/content_nodes?parent='.$this->getIriFor('columnLayout1'));
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'totalItems' => 4,
            '_links' => [
                'items' => [],
            ],
            '_embedded' => [
                'items' => [],
            ],
        ]);
        $this->assertEqualsCanonicalizing([
            ['href' => $this->getIriFor('columnLayoutChild1')],
            ['href' => $this->getIriFor('singleText1')],
            ['href' => $this->getIriFor('materialNode1')],
            ['href' => $this->getIriFor('storyboard1')],
        ], $response->toArray()['_links']['items']);
    }
}