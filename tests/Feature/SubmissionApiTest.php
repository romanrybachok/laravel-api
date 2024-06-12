<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubmissionApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test a valid submission.
     *
     * @return void
     */
    public function testValidSubmission()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'message' => 'This is a test message.'
        ];

        $response = $this->postJson('/api/submit', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Submission is being processed'
            ]);
    }

    /**
     * Test submission with missing fields.
     *
     * @return void
     */
    public function testInvalidSubmission()
    {
        $data = [
            'name' => '',
            'email' => '',
            'message' => ''
        ];

        $response = $this->postJson('/api/submit', $data);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid data input'
            ]);
    }

    /**
     * Test submission with invalid email.
     *
     * @return void
     */
    public function testInvalidEmailSubmission()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'not-an-email',
            'message' => 'This is a test message.'
        ];

        $response = $this->postJson('/api/submit', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
