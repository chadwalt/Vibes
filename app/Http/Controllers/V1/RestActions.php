<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * The RestActions Trait handles Rest Actions.
 */
trait RestActions
{
    /**
     * Return HTTP Responses.
     *
     * @param int    $status_code the appropriate status code for the response
     * @param object $data        JSON object
     *
     * @return Response
     */
    protected function respond($status_code, $data=[])
    {
        return response()->json($data, $status_code);
    }
}
