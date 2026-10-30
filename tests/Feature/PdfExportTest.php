<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('invoice_pdf_returns_pdf_response', function () {
    $this->actingAs($this->user);
    $response = $this->get('/sales/invoices/1/pdf');

    $response->assertOk();
    $response->assertHeader('Content-Type', 'application/pdf');
})->skip('PDF routes not implemented');

test('purchase_order_pdf_returns_pdf_response', function () {
    $this->actingAs($this->user);
    $response = $this->get('/purchasing/orders/1/pdf');

    $response->assertOk();
    $response->assertHeader('Content-Type', 'application/pdf');
})->skip('PDF routes not implemented');
