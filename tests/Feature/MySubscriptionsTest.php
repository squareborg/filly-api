 <?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;
use App\Models\Program;

class MySubscriptionsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShowsListOfSubscribedCampaigns()
    {
        $user = factory(User::class)->create(
            [
                'email' => 'steve@st12312312312e.com'
            ]
        );
        $response = $this->actingAs($user, 'api')->get('/api/mySubscriptions');

        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [

                    ]
                ]
            );
    }

    public function test_user_can_subscribe_to_program()
    {
        $program = factory(Program::class)->create();

        $response = $this->actingAs($program->user, 'api')->post(route('subscribe',[$program]));

        $response->assertStatus(200);
        $this->assertDatabaseHas('advert_user', [
            'user_id' => $program->user->id,
            'advert_id' => $program->id
        ]);
    }

    public function test_user_cannot_subscribe_to_program_that_does_not_exits()
    {
        $program = factory(Program::class)->create();

        $response = $this->actingAs($program->user, 'api')->post(route('subscribe',[0]));

        $response->assertStatus(404);
        $this->assertDatabaseMissing('advert_user', [
            'user_id' => $program->user->id,
            'advert_id' => 0
        ]);
    }
}
