<?php

namespace App\Traits;

use JsonException;

trait CanReadJSONFIle {

    /**
     * @throws JsonException
     */
    public function readJSONFile(string $fileLocation) {

        return json_decode(
            file_get_contents(dirname(__DIR__)."/$fileLocation"),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }
}