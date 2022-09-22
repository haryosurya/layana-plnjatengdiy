<?php namespace Tests\Repositories;

use App\Models\Dc_apj;
use App\Repositories\Dc_apjRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class Dc_apjRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var Dc_apjRepository
     */
    protected $dcApjRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->dcApjRepo = \App::make(Dc_apjRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_dc_apj()
    {
        $dcApj = Dc_apj::factory()->make()->toArray();

        $createdDc_apj = $this->dcApjRepo->create($dcApj);

        $createdDc_apj = $createdDc_apj->toArray();
        $this->assertArrayHasKey('id', $createdDc_apj);
        $this->assertNotNull($createdDc_apj['id'], 'Created Dc_apj must have id specified');
        $this->assertNotNull(Dc_apj::find($createdDc_apj['id']), 'Dc_apj with given id must be in DB');
        $this->assertModelData($dcApj, $createdDc_apj);
    }

    /**
     * @test read
     */
    public function test_read_dc_apj()
    {
        $dcApj = Dc_apj::factory()->create();

        $dbDc_apj = $this->dcApjRepo->find($dcApj->id);

        $dbDc_apj = $dbDc_apj->toArray();
        $this->assertModelData($dcApj->toArray(), $dbDc_apj);
    }

    /**
     * @test update
     */
    public function test_update_dc_apj()
    {
        $dcApj = Dc_apj::factory()->create();
        $fakeDc_apj = Dc_apj::factory()->make()->toArray();

        $updatedDc_apj = $this->dcApjRepo->update($fakeDc_apj, $dcApj->id);

        $this->assertModelData($fakeDc_apj, $updatedDc_apj->toArray());
        $dbDc_apj = $this->dcApjRepo->find($dcApj->id);
        $this->assertModelData($fakeDc_apj, $dbDc_apj->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_dc_apj()
    {
        $dcApj = Dc_apj::factory()->create();

        $resp = $this->dcApjRepo->delete($dcApj->id);

        $this->assertTrue($resp);
        $this->assertNull(Dc_apj::find($dcApj->id), 'Dc_apj should not exist in DB');
    }
}
