<?php

namespace Tests\Feature;

use Tests\TestCase;

class MovieScreeningTest extends TestCase
{
    private string $mainRoutePath = '/movie-screenings';
    
    private array $testData = [
        'movie_id' => null,
        'room_id' => null,
        'start' => null,
        'free_positions' => 0
    ];
    
    private array $testMovieData = [
        'title' => 'Teszt Film 01',
        'description' => 'Teszt film leírás',
        'ageLimit' => 0,
        'lang' => 'hu',
        'coverImage' => null
    ];
    
    private array $testRoomData = [
        'title' => 'Teszt Terem 01',
        'capacity' => 150
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
    
    public function test_bad_data_store(): void
    {
        $this->testData['free_positions']++;
        $response = $this->post($this->mainRoutePath, $this->testData);
        $response->assertStatus(422);
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
    
    protected function getValidMovieId(): int
    {
        $postResponse = $this->post('/movies', $this->testMovieData);
        return (int)$postResponse->json('id');
    }
    
    protected function getValidRoomId(): int
    {
        $postResponse = $this->post('/rooms', $this->testRoomData);
        return (int)$postResponse->json('id');
    }
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->testData['movie_id'] = $this->getValidMovieId();
        $this->testData['room_id'] = $this->getValidRoomId();
        $this->testData['free_positions'] = $this->testRoomData['capacity'];
        $this->testData['start'] = (new \DateTimeImmutable())->format(\DateTimeInterface::ATOM);
    }
    
    protected function getValidItemId(): int
    {
        $postResponse = $this->post($this->mainRoutePath, $this->testData);
        return (int)$postResponse->json('id');
    }
}
