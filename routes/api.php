<?php

Route::namespace('Api')->group(function () {
    Route::get('rates', 'RateController@index')->name('api.rates');
});
