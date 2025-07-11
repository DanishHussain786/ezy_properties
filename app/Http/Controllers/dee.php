<?php


    try {
      // Begin the transaction
      DB::beginTransaction();

      $markup = isset($request_data['markup_rent']) ? $request_data['markup_rent'] : 0;
      $expected_rent = isset($request_data['expected_rent']) ? $request_data['expected_rent'] : 0;
      $net_total = isset($request_data['net_total']) ? $request_data['net_total'] : 0;

      $last_id = 0;
      $last_data = $this->BookingObj->latest('id')->first();
      if (isset($last_data->id))
        $last_id = $last_data->id + 1;
      else
        $last_id = 1;

      $booking_data['booked_id'] = generate_random_key().$last_id;
      // $booking_data['booked_by'] = \Auth::user()->id;
      $booking_data['booked_for'] = $request_data['user_id'];
      // $booking_data['rent'] = $expected_rent;
      // $booking_data['markup_rent'] = $markup;
      // $booking_data['balance'] = $net_total;

      $booking = $this->BookingObj->getBooking(['status' => 'Unpaid', 'booked_for' => $request_data['user_id'], 'detail' => true]);

      if (!$booking) {
        $booking_data['total_payable'] = $net_total;
      }
      else {
        $booking->total_payable += $net_total;
        $booking->save();
      }

      $data = $this->BookingObj->saveUpdateBooking($booking_data);
      $data['redirect_url'] = url('property');

      $property = $this->PropertyObj->getProperty(['id' => $request_data['property_id'], 'detail' => true]);
      $property->prop_status = 'Pre-Reserve';
      $property->save();

      // this code will do entry for bookings logs
      $book_log['booking_id'] = isset($data->id) ? $data->id : 0;
      $book_log['property_id'] = isset($request_data['property_id']) ? $request_data['property_id'] : 0;
      $book_log['service_id'] = isset($request_data['service_id']) ? $request_data['service_id'] : 0;
      $book_log['checkin_date'] = isset($request_data['checkin_date']) ? $request_data['checkin_date'] : 0;
      $book_log['checkout_date'] = isset($request_data['checkout_date']) ? $request_data['checkout_date'] : 0;
      $book_log['for_days'] = datetime_difference($book_log['checkin_date'], $book_log['checkout_date'])['days'];
      $book_log['for_months'] = floor($book_log['for_days']/30);
      $book_log['rent'] = isset($request_data['prop_rent']) ? $request_data['prop_rent'] : 0;
      $book_log['disc_rent'] = isset($request_data['disc_rent']) ? $request_data['disc_rent'] : 0;
      $book_log['markup_rent'] = $markup;
      $book_log['charge_rent'] = $net_total;

      if ($book_log['property_id'] > 0)
        $book_log['purpose'] = 'Rent-Charges';
      else if ($book_log['property_id'] > 0)
        $book_log['purpose'] = 'Service-Charges';

      $this->BookingLogObj->saveUpdateBookingLog($book_log);

      // If everything is successful, commit the transaction
      DB::commit();

      // if ($deposit > 0) {
      // 	$deposit_data['property_id'] = $request_data['property_id'];
      // 	$deposit_data['booking_id'] = $data->id;
      // 	$deposit_data['paid_by'] = $request_data['user_id'];
      // 	$deposit_data['deposit_by'] = $request_data['deposit_by'];
      // 	$deposit_data['dep_name'] = $request_data['dep_name'];
      // 	$deposit_data['dep_email'] = $request_data['dep_email'];
      // 	$deposit_data['dep_contact'] = $request_data['dep_contact'];
      // 	$deposit_data['dep_method'] = $request_data['dep_method'];
      // 	$deposit_data['amount'] = $deposit;
      // 	$deposit_data['balance'] = $tot_rent - $deposit;
      // 	$deposit_data['paid_for'] = 'Property';
      // 	$deposit_data['type'] = 'Initial-Deposit';
      // 	$this->TransactionObj->saveUpdateTransaction($deposit_data);
      // }
    } catch (\Exception $e) {
      // If there's an exception, rollback the transaction
      DB::rollback();

      // Optionally, you can log the error or rethrow it
      // Log::error('Error in transaction: '.$e->getMessage());
      throw $e; // or handle the exception as needed
    }
