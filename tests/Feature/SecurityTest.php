<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
    }

    /**
     * Test that custom 404 page is rendered.
     */
    public function test_custom_404_page_is_rendered(): void
    {
        $response = $this->get('/non-existent-page');

        $response->assertStatus(404);
        $response->assertSee('Lost in Space');
        $response->assertSee('// error 404');
    }

    /**
     * Test that public pages are rate limited.
     */
    public function test_public_pages_are_rate_limited(): void
    {
        // Perform 30 attempts (allowed)
        for ($i = 0; $i < 30; $i++) {
            $response = $this->get('/about');
            $response->assertStatus(200);
        }

        // 31st attempt should be rate limited
        $response = $this->get('/about');

        $response->assertStatus(429);
        $response->assertSee('Slow Down');
        $response->assertSee('// error 429');
    }

    /**
     * Test that login is rate limited.
     */
    public function test_login_is_rate_limited(): void
    {
        $user = User::factory()->create();

        // Perform 5 attempts (allowed)
        for ($i = 0; $i < 5; $i++) {
            $response = $this->post('/login', [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);
            $response->assertSessionHasErrors();
        }

        // 6th attempt should be rate limited
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(429);
    }

    /**
     * Test that contact form is rate limited.
     */
    public function test_contact_form_is_rate_limited(): void
    {
        // Perform 5 attempts (allowed)
        for ($i = 0; $i < 5; $i++) {
            $response = $this->post('/contact', [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'message' => 'This is a test message that is long enough.',
            ]);
            $response->assertRedirect(route('contact.thanks'));
        }

        // 6th attempt should be rate limited
        $response = $this->post('/contact', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'This is a test message that is long enough.',
        ]);

        $response->assertStatus(429);
    }

    /**
     * Test that contact form input is sanitized.
     */
    public function test_contact_form_input_is_sanitized(): void
    {
        $response = $this->post('/contact', [
            'name' => '<b>John Doe</b>',
            'email' => 'john@example.com',
            'message' => '<script>alert("xss")</script>This is a test message with script.',
        ]);

        $response->assertRedirect(route('contact.thanks'));

        $this->assertDatabaseHas('contacts', [
            'name' => 'John Doe',
            'message' => 'alert("xss")This is a test message with script.',
        ]);
    }

    /**
     * Test that contact form honeypot works.
     */
    public function test_contact_form_honeypot_works(): void
    {
        $response = $this->post('/contact', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'This is a test message.',
            'website' => 'http://malicious-bot.com',
        ]);

        $response->assertRedirect(route('contact.thanks'));

        // Should not save to database
        $this->assertDatabaseMissing('contacts', [
            'name' => 'John Doe',
        ]);
    }

    /**
     * Test that resume download is rate limited.
     */
    public function test_resume_download_is_rate_limited(): void
    {
        // Create an active resume first
        \App\Models\Resume::factory()->create(['is_active' => true, 'file_path' => 'resumes/test.pdf']);

        // Mock the storage to avoid file not found errors
        \Illuminate\Support\Facades\Storage::fake('public');
        \Illuminate\Support\Facades\Storage::disk('public')->put('resumes/test.pdf', 'dummy content');

        // Perform 10 attempts (allowed)
        for ($i = 0; $i < 10; $i++) {
            $response = $this->get('/resume/download');
            $response->assertStatus(200);
        }

        // 11th attempt should be rate limited
        $response = $this->get('/resume/download');

        $response->assertStatus(429);
    }
}
