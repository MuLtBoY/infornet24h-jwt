<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Purveyor;
use App\Services\Purveyor\PurveyorService;
use App\Repositories\Contracts\PurveyorRepositoryInterface;
use Mockery;

class PurveyorServiceTest extends TestCase
{
    protected $repositoryMock;
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repositoryMock = Mockery::mock(PurveyorRepositoryInterface::class);
        $this->service = new PurveyorService($this->repositoryMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_get_by_id_returns_purveyor()
    {
        $purveyor = new Purveyor(['id' => 1, 'name' => 'Teste prestador']);

        $this->repositoryMock
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn($purveyor);

        $result = $this->service->getById(['purveyor_id' => 1]);

        $this->assertInstanceOf(Purveyor::class, $result);
        $this->assertEquals(1, $result->id);
    }

    public function test_create_returns_purveyor()
    {
        $data = ['name' => 'Novo prestador'];
        $purveyor = new Purveyor($data);

        $this->repositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn($purveyor);

        $result = $this->service->create($data);

        $this->assertInstanceOf(Purveyor::class, $result);
        $this->assertEquals('Novo prestador', $result->name);
    }

    public function test_update_returns_updated_purveyor()
    {
        $data = ['id' => 1, 'name' => 'Atualizado'];
        $purveyor = new Purveyor($data);

        $this->repositoryMock
            ->shouldReceive('update')
            ->once()
            ->with(1, $data)
            ->andReturn($purveyor);

        $result = $this->service->update($data);

        $this->assertInstanceOf(Purveyor::class, $result);
        $this->assertEquals('Atualizado', $result->name);
    }

    public function test_delete_returns_true()
    {
        $this->repositoryMock
            ->shouldReceive('delete')
            ->once()
            ->with(1)
            ->andReturn(true);

        $result = $this->service->delete(['purveyor_id' => 1]);

        $this->assertTrue($result);
    }
}