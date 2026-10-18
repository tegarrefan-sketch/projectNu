<?php

namespace Tests\Feature;

use App\Models\Banom;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPostTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->admin = User::first();
    }

    public function test_admin_can_view_berita_index(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.berita.index'));
        $response->assertStatus(200);
        $response->assertSeeText('Warta & Artikel Nahdlatul Ulama');
    }

    public function test_admin_can_create_and_publish_post_with_image(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('berita.jpg', 600, 400);

        $response = $this->actingAs($this->admin)->post(route('admin.berita.store'), [
            'title' => 'Pengajian Akbar Ranting NU Banjaranyar 2026',
            'kategori' => 'Kegiatan',
            'excerpt' => 'Ringkasan pengajian akbar',
            'content' => '<p>Uraian lengkap kegiatan pengajian akbar warga nahdliyin.</p>',
            'author' => 'Tim Media PRNU',
            'status' => 'published',
            'thumbnail' => $file,
        ]);

        $response->assertRedirect(route('admin.berita.index'));
        $this->assertDatabaseHas('posts', [
            'title' => 'Pengajian Akbar Ranting NU Banjaranyar 2026',
            'status' => 'published',
        ]);

        $post = Post::where('title', 'Pengajian Akbar Ranting NU Banjaranyar 2026')->first();
        $this->assertNotNull($post);
        $this->assertNotNull($post->thumbnail);
        Storage::disk('public')->assertExists($post->thumbnail);

        // Check public portal
        $publicList = $this->get(route('post.index'));
        $publicList->assertStatus(200);
        $publicList->assertSee('Pengajian Akbar Ranting NU Banjaranyar 2026');

        $publicDetail = $this->get(route('post.show', $post->slug));
        $publicDetail->assertStatus(200);
        $publicDetail->assertSee('Pengajian Akbar Ranting NU Banjaranyar 2026');
    }

    public function test_admin_can_toggle_publish_status(): void
    {
        $post = Post::create([
            'title' => 'Berita Status Draf Test',
            'slug' => 'berita-status-draf-test',
            'kategori' => 'Umum',
            'content' => 'Isi berita test draf',
            'author' => 'Redaksi',
            'status' => 'draft',
        ]);

        // Toggle via toggle-publish
        $response = $this->actingAs($this->admin)->patch(route('admin.berita.toggle-publish', $post->id));
        $response->assertStatus(302);

        $post->refresh();
        $this->assertEquals('published', $post->status);
        $this->assertNotNull($post->published_at);
    }

    public function test_admin_can_edit_post(): void
    {
        $post = Post::create([
            'title' => 'Judul Lama',
            'slug' => 'judul-lama-12345',
            'kategori' => 'Umum',
            'content' => 'Isi lama',
            'author' => 'Penulis Lama',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.berita.update', $post->id), [
            'title' => 'Judul Baru Diperbarui',
            'kategori' => 'Kajian',
            'excerpt' => 'Kutipan baru',
            'content' => 'Isi baru lengkap',
            'author' => 'Penulis Baru',
            'status' => 'published',
        ]);

        $response->assertRedirect(route('admin.berita.index'));
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Judul Baru Diperbarui',
            'kategori' => 'Kajian',
        ]);
    }

    public function test_admin_can_delete_post(): void
    {
        $post = Post::create([
            'title' => 'Berita Untuk Dihapus',
            'slug' => 'berita-untuk-dihapus-12345',
            'kategori' => 'Umum',
            'content' => 'Isi warta',
            'author' => 'Penulis',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.berita.destroy', $post->id));
        $response->assertRedirect(route('admin.berita.index'));

        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }
}
