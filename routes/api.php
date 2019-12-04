<?php

Route::namespace('Api')->group(function () {
    Route::get('rates', 'RateController@index')->name('api.rates');

    Route::get('spaces/available', 'SpacesAvailableController@index')->name('api.spaces.available');

    Route::post('tickets', 'TicketController@store')->name('api.tickets');
});
