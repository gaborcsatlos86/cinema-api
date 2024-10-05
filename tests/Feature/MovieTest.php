<?php

namespace Tests\Feature;

use Tests\TestCase;

class MovieTest extends TestCase
{
    private string $mainRoutePath = '/movies';
    
    private array $testData = [
        'title' => 'Teszt Film 01',
        'description' => 'Teszt film leírás',
        'ageLimit' => 0,
        'lang' => 'hu',
        'coverImage' => null
    ];
    
    public function test_index(): void
    {
        $response = $this->get($this->mainRoutePath);
        $response->assertStatus(200);
    }
    
    public function test_create(): void
    {
        $response = $this->get($this->mainRoutePath . '/create');
        $response->assertStatus(200);
    }
    
    public function test_store(): void
    {
        $response = $this->post($this->mainRoutePath, $this->testData);
        $response->assertStatus(201);
    }
    
    public function test_show(): void
    {
        $id = $this->getValidItemId();
        $response = $this->get($this->mainRoutePath . '/'. $id);
        $response->assertStatus(200);
    }
    
    public function test_update(): void
    {
        $id = $this->getValidItemId();
        $data = $this->testData;
        $data['title'] = 'Lorem ipsum';
        $data['description'] = 'nincs leírás';
        $response = $this->put($this->mainRoutePath . '/'. $id, $data);
        $response->assertStatus(200);
    }
    
    public function test_destroy(): void
    {
        $id = $this->getValidItemId();
        $response = $this->delete($this->mainRoutePath . '/'. $id);
        $response->assertStatus(204);
    }
    
    public function test_edit(): void
    {
        $id = $this->getValidItemId();
        $response = $this->get($this->mainRoutePath . '/'. $id . '/edit');
        $response->assertStatus(200);
    }
    
    protected function getValidItemId(): int
    {
        $postResponse = $this->post($this->mainRoutePath, $this->testData);
        return (int)$postResponse->json('id');
    }
    
}
