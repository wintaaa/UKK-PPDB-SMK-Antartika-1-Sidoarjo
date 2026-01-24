<?php

namespace Tests\Feature;

use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JurusanPricingTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed database
        $this->artisan('db:seed', ['--class' => 'JurusanSeeder']);
        
        // Create user
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
            'role' => 'panitia',
        ]);
    }

    /**
     * Test: Lihat daftar harga jurusan
     */
    public function test_can_view_pricing_list()
    {
        $response = $this->actingAs($this->user)
            ->get('/panitia/pricing/');

        $response->assertStatus(200);
        $response->assertViewIs('panitia.pricing.index');
        $response->assertViewHas('jurusans');
    }

    /**
     * Test: Daftar harga menampilkan semua jurusan
     */
    public function test_pricing_list_shows_all_jurusan()
    {
        $response = $this->actingAs($this->user)
            ->get('/panitia/pricing/');

        $response->assertStatus(200);
        
        $jurusans = $response->viewData('jurusans');
        $this->assertCount(5, $jurusans);
    }

    /**
     * Test: Harga Rekayasa Perangkat Lunak adalah Rp 350.000
     */
    public function test_rpl_pricing_is_350000()
    {
        $rpl = Jurusan::where('nama_jurusan', 'Rekayasa Perangkat Lunak')->first();
        
        $this->assertNotNull($rpl);
        $this->assertEquals(350000, $rpl->biaya_pendaftaran);
    }

    /**
     * Test: Harga jurusan lain adalah Rp 300.000
     */
    public function test_other_jurusan_pricing_is_300000()
    {
        $technicalJurusans = Jurusan::where('nama_jurusan', '!=', 'Rekayasa Perangkat Lunak')->get();
        
        foreach ($technicalJurusans as $jurusan) {
            $this->assertEquals(300000, $jurusan->biaya_pendaftaran, 
                "Harga {$jurusan->nama_jurusan} harus 300000");
        }
    }

    /**
     * Test: Buka form edit harga
     */
    public function test_can_open_edit_pricing_form()
    {
        $jurusan = Jurusan::first();

        $response = $this->actingAs($this->user)
            ->get("/panitia/pricing/{$jurusan->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('panitia.pricing.edit');
        $response->assertViewHas('jurusan');
    }

    /**
     * Test: Update harga jurusan
     */
    public function test_can_update_pricing()
    {
        $jurusan = Jurusan::first();
        $newPrice = 400000;

        $response = $this->actingAs($this->user)
            ->put("/panitia/pricing/{$jurusan->id}", [
                'biaya_pendaftaran' => $newPrice,
            ]);

        $response->assertRedirect('/panitia/pricing/');
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('jurusan', [
            'id' => $jurusan->id,
            'biaya_pendaftaran' => $newPrice,
        ]);
    }

    /**
     * Test: Validasi harga tidak boleh kosong
     */
    public function test_pricing_validation_required()
    {
        $jurusan = Jurusan::first();

        $response = $this->actingAs($this->user)
            ->put("/panitia/pricing/{$jurusan->id}", [
                'biaya_pendaftaran' => '',
            ]);

        $response->assertSessionHasErrors('biaya_pendaftaran');
    }

    /**
     * Test: Validasi harga harus angka
     */
    public function test_pricing_validation_must_be_numeric()
    {
        $jurusan = Jurusan::first();

        $response = $this->actingAs($this->user)
            ->put("/panitia/pricing/{$jurusan->id}", [
                'biaya_pendaftaran' => 'bukan_angka',
            ]);

        $response->assertSessionHasErrors('biaya_pendaftaran');
    }

    /**
     * Test: Validasi harga tidak boleh negatif
     */
    public function test_pricing_validation_cannot_be_negative()
    {
        $jurusan = Jurusan::first();

        $response = $this->actingAs($this->user)
            ->put("/panitia/pricing/{$jurusan->id}", [
                'biaya_pendaftaran' => -100,
            ]);

        $response->assertSessionHasErrors('biaya_pendaftaran');
    }

    /**
     * Test: Harga 0 boleh (gratis)
     */
    public function test_pricing_can_be_zero()
    {
        $jurusan = Jurusan::first();

        $response = $this->actingAs($this->user)
            ->put("/panitia/pricing/{$jurusan->id}", [
                'biaya_pendaftaran' => 0,
            ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('jurusan', [
            'id' => $jurusan->id,
            'biaya_pendaftaran' => 0,
        ]);
    }
}
