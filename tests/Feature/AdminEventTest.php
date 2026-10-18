<?php

namespace Tests\Feature;

use App\Models\Banom;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminEventTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_admin_can_access_agenda_index(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.agenda.index'));
        $response->assertStatus(200);
        $response->assertSee('Agenda & Jadwal Kegiatan', false);
    }

    public function test_admin_can_create_new_agenda(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('agenda_pamflet.jpg');

        $data = [
            'title' => 'Pengajian Rutin Ahad Pagi Banjaranyar',
            'tanggal' => now()->addDays(5)->format('Y-m-d'),
            'waktu_mulai' => '06:00',
            'waktu_selesai' => '08:30',
            'lokasi' => 'Masjid Jami Baiturrahman',
            'description' => 'Kajian Kitab Riyadhus Shalihin bersama Mauidhoh Hasanah.',
            'status' => 'Akan Datang',
            'thumbnail' => $file,
        ];

        $response = $this->actingAs($this->user)->post(route('admin.agenda.store'), $data);

        $response->assertRedirect(route('admin.agenda.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('events', [
            'title' => 'Pengajian Rutin Ahad Pagi Banjaranyar',
            'lokasi' => 'Masjid Jami Baiturrahman',
            'status' => 'Akan Datang',
        ]);

        $event = Event::where('title', 'Pengajian Rutin Ahad Pagi Banjaranyar')->first();
        $this->assertNotNull($event->slug);
        $this->assertNotNull($event->thumbnail);
        Storage::disk('public')->assertExists($event->thumbnail);
    }

    public function test_admin_can_open_edit_agenda_form_with_bound_data(): void
    {
        $event = Event::create([
            'title' => 'Lailatul Ijtima Ranting',
            'slug' => 'lailatul-ijtima-ranting-12345',
            'tanggal' => now()->addDays(2)->format('Y-m-d'),
            'lokasi' => 'Musholla Al-Ikhlas',
            'status' => 'Akan Datang',
            'description' => 'Sholat tasbih dan istighotsah berjamaah.',
        ]);

        $response = $this->actingAs($this->user)->get(route('admin.agenda.edit', $event->id));

        $response->assertStatus(200);
        $response->assertSee('Edit Agenda Kegiatan');
        $response->assertSee('Lailatul Ijtima Ranting');
        $response->assertSee('Musholla Al-Ikhlas');
    }

    public function test_admin_can_update_agenda(): void
    {
        $event = Event::create([
            'title' => 'Agenda Awal',
            'slug' => 'agenda-awal-12345',
            'tanggal' => now()->addDays(3)->format('Y-m-d'),
            'lokasi' => 'Balai Desa',
            'status' => 'Akan Datang',
        ]);

        $updateData = [
            'title' => 'Agenda Diperbarui',
            'tanggal' => now()->addDays(4)->format('Y-m-d'),
            'lokasi' => 'Gedung Serbaguna NU',
            'status' => 'Selesai',
            'description' => 'Telah selesai dengan sukses.',
        ];

        $response = $this->actingAs($this->user)->put(route('admin.agenda.update', $event->id), $updateData);

        $response->assertRedirect(route('admin.agenda.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'Agenda Diperbarui',
            'lokasi' => 'Gedung Serbaguna NU',
            'status' => 'Selesai',
        ]);
    }

    public function test_admin_can_delete_agenda(): void
    {
        $event = Event::create([
            'title' => 'Agenda Untuk Dihapus',
            'slug' => 'agenda-hapus-12345',
            'tanggal' => now()->addDays(1)->format('Y-m-d'),
            'lokasi' => 'Kantor MWC',
            'status' => 'Akan Datang',
        ]);

        $this->assertDatabaseHas('events', ['id' => $event->id, 'deleted_at' => null]);

        $response = $this->actingAs($this->user)->delete(route('admin.agenda.destroy', $event->id));

        $response->assertRedirect(route('admin.agenda.index'));
        $response->assertSessionHas('success');

        // Model uses soft delete
        $this->assertSoftDeleted('events', ['id' => $event->id]);
    }

    public function test_public_event_displays_properly_with_admin_navigation(): void
    {
        $event = Event::create([
            'title' => 'Halaqah Fikih Peradaban',
            'slug' => 'halaqah-fikih-peradaban-12345',
            'tanggal' => now()->addDays(7)->format('Y-m-d'),
            'lokasi' => 'Aula Pesantren',
            'status' => 'Akan Datang',
            'description' => 'Diskusi tematik fikih kontekstual.',
        ]);

        // As guest
        $guestResponse = $this->get(route('event.show', $event->slug));
        $guestResponse->assertStatus(200);
        $guestResponse->assertSee('Halaqah Fikih Peradaban');
        $guestResponse->assertDontSee('Kembali ke Manajemen Agenda');

        // As admin
        $adminResponse = $this->actingAs($this->user)->get(route('event.show', $event->slug));
        $adminResponse->assertStatus(200);
        $adminResponse->assertSee('Kembali ke Manajemen Agenda');
    }
}
