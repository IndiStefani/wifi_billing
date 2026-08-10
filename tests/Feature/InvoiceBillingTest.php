<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceBillingTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_payment_and_collection_pages_are_accessible(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->get(route('invoices.index'))->assertOk();
        $this->get(route('payments.index'))->assertOk();
        $this->get(route('collections.index'))->assertOk();
    }
}
