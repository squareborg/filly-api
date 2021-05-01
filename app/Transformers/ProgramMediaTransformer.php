<?php

namespace App\Transformers;

use App\Models\ProgramMedia;

class ProgramMediaTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = ['media'];

    public function transform(ProgramMedia $programMedia)
    {
        return [
            'uuid' => (string)$programMedia->uuid,
            'program_uuid' => $programMedia->program_uuid,
            'file_extension' => $programMedia->file_extension,
            'filepath' => $programMedia->filename
        ];
    }

}
