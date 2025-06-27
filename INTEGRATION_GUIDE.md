# HarmoStays PayGate Integration Guide

## Overview
This document outlines the integration between the HarmoStays Checkout App and the main HarmoStays application for handling PayGate payment callbacks.

## Current Status ✅
- ✅ PayGate API integration working
- ✅ Wallet address configured (0x6734be2F7C16de208483453DC64588C3c856ee0D)
- ✅ Payment flow redirecting to PayGate successfully (using pay.php for regional compatibility)
- ✅ URL encoding issues resolved
- ✅ Transaction tracking implemented
- ✅ Modern landing page created for accidental visitors

## Required Implementation on test.harmostays.com

## Important Update: Regional Payment Access
PayGate provides two payment endpoints:
- `process-payment.php`: Uses MoonPay (may be restricted in some regions)
- `pay.php`: Alternative endpoint with broader regional support

This integration uses `pay.php` as recommended by PayGate support for better regional compatibility.

### 1. Callback Endpoint Setup
You need to create an endpoint on test.harmostays.com to receive payment confirmations:

**URL:** `https://test.harmostays.com/checkout-callback`
**Method:** GET
**Parameters:**
- `status` (string): "success" or "failed"
- `booking_id` (string): The original booking ID
- `amount_paid` (decimal): Amount actually paid
- `transaction_id` (integer): Internal transaction ID from checkout app

### 2. Example Implementation (PHP/Laravel)
```php
// Route
Route::get('/checkout-callback', [BookingController::class, 'handlePaymentCallback']);

// Controller Method
public function handlePaymentCallback(Request $request)
{
    $status = $request->query('status');
    $bookingId = $request->query('booking_id');
    $amountPaid = $request->query('amount_paid');
    $transactionId = $request->query('transaction_id');
    
    // Validate parameters
    if (!$status || !$bookingId) {
        return response('Invalid parameters', 400);
    }
    
    // Find the booking
    $booking = Booking::where('id', $bookingId)->first();
    if (!$booking) {
        return response('Booking not found', 404);
    }
    
    if ($status === 'success') {
        // Update booking status
        $booking->status = 'paid';
        $booking->payment_amount = $amountPaid;
        $booking->payment_transaction_id = $transactionId;
        $booking->paid_at = now();
        $booking->save();
        
        // Send confirmation email, update inventory, etc.
        
        // Redirect to success page
        return redirect('/booking-success?booking_id=' . $bookingId);
    } else {
        // Handle failed payment
        $booking->status = 'payment_failed';
        $booking->save();
        
        return redirect('/booking-failed?booking_id=' . $bookingId);
    }
}
```

### 3. Checkout App Configuration
Once the callback endpoint is ready on test.harmostays.com, update the checkout app:

**File:** `app/Http/Controllers/CheckoutController.php`
**Change:** Update the callback URL generation:

```php
// Current (localhost for testing)
$callbackUrl = route('checkout.paygateCallback', [], true);

// Production (when ready)
$callbackUrl = 'https://test.harmostays.com/paygate/callback';
```

### 4. PayGate Callback Flow
```
Customer pays → MoonPay → PayGate → Checkout App → test.harmostays.com
                                        ↓
                                   /paygate/callback
                                        ↓
                                   Updates transaction
                                        ↓
                                   Redirects to:
                                   /checkout-callback?status=success&booking_id=...
```

### 5. Security Considerations
- Validate all incoming parameters
- Check booking ownership/permissions
- Log all callback attempts for debugging
- Consider implementing HMAC signature verification for additional security

### 6. Testing
1. Complete a test payment through the checkout flow
2. Verify the callback is received on test.harmostays.com
3. Check that booking status is updated correctly
4. Test both success and failure scenarios

### 7. Environment Variables Needed
On the checkout app, you'll need:
```env
CHECKOUT_SECRET=your-hmac-secret-key
PAYGATE_USDC_WALLET=0x6734be2F7C16de208483453DC64588C3c856ee0D
```

### 8. Database Schema
The checkout app uses this transaction structure:
```sql
- id (primary key)
- booking_id (string)
- user_id (string) 
- amount (decimal)
- currency (string)
- status (enum: pending, paid, failed)
- ipn_token (string)
- txid_in (string)
- txid_out (string)
- amount_paid (decimal)
- payment_coin (string)
- payment_address (string)
- created_at/updated_at
```

## Next Steps
1. Implement the callback endpoint on test.harmostays.com
2. Test the integration end-to-end
3. Update the callback URL in the checkout app
4. Deploy to production

## Contact
If you need any clarification or run into issues, refer back to this integration guide.
