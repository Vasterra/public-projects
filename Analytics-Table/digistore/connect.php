<?php
/**
 * Digistore24 REST api example: Establish a connection
 * @author Christian Neise
 * @version 1.0
 * @link https://docs.digistore24.com/api-en/
 *
 * This example establishes a connection to the Digistore24 server.
 *
 */

/*

Copyright (c) 2020 Digistore24 GmbH

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and
associated documentation files (the "Software"), to deal in the Software without restriction,
including without limitation the rights to use, copy, modify, merge, publish, distribute,
sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or
substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT
NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

define( 'YOUR_API_KEY', '106475-2iNhxGx96SAjXpRWvMeZ1fm2CVtTM45NZcD6W74u' ); // replace by your api key (any type) - see https://www.digistore24.com/vendor/settings/account_access/api

require_once 'ds24_api.php';

try
{
    $api = DigistoreApi::connect( YOUR_API_KEY );

    $data = $api->ping();

    $server_time = $data->server_time;

    echo "Success: Server time is $server_time\n";

    $api->disconnect();
}

catch (DigistoreApiException $e)
{
    $error_message = $e->getMessage();

    echo "Error: $error_message\n";
}