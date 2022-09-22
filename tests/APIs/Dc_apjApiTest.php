<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Dc_apj;

class Dc_apjApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_dc_apj()
    {
        $dcApj = Dc_apj::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/dc_apjs', $dcApj
        );

        $this->assertApiResponse($dcApj);
    }

    /**
     * @test
     */
    public function test_read_dc_apj()
    {
        $dcApj = Dc_apj::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/dc_apjs/'.$dcApj->id
        );

        $this->assertApiResponse($dcApj->toArray());
    }

    /**
     * @test
     */
    public function test_update_dc_apj()
    {
        $dcApj = Dc_apj::factory()->create();
        $editedDc_apj = Dc_apj::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/dc_apjs/'.$dcApj->id,
            $editedDc_apj
        );

        $this->assertApiResponse($editedDc_apj);
    }

    /**
     * @test
     */
    public function test_delete_dc_apj()
    {
        $dcApj = Dc_apj::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/dc_apjs/'.$dcApj->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/dc_apjs/'.$dcApj->id
        );

        $this->response->assertStatus(404);
    }
}
