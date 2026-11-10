<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BrmDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_brm_user_can_view_dashboard_and_projects(): void
    {
        $user = User::factory()->create([
            'name' => 'Anita Rao',
            'email' => 'anita.brm@cmnhousing.test',
        ]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Overview')
            ->assertSee('Welcome back, Anita')
            ->assertSee('Enterprise BRM Console')
            ->assertSee('Active Builders')
            ->assertSee('Quick Action')
            ->assertSee('Builder Pipeline');

        $this->actingAs($user)
            ->get(route('projects.index'))
            ->assertOk()
            ->assertSee('Projects');
    }

    public function test_projects_page_reads_shared_housing_projects(): void
    {
        if (! is_file((string) config('database.connections.housing.database'))) {
            $this->markTestSkipped('Shared housing database is not configured.');
        }

        $id = DB::connection('housing')->table('project_details')->insertGetId([
            'name' => 'BRM Shared Towers',
            'builder_name' => 'Shared Builders',
            'location' => 'Hyderabad',
            'status' => 'under_review',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('projects.index', ['status' => 'pending']))
            ->assertOk()
            ->assertSee('BRM Shared Towers')
            ->assertSee('Shared Builders');

        DB::connection('housing')->table('project_details')->where('id', $id)->delete();
    }
}
