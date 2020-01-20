<?php

namespace App\Transformers;

use App\Models\Program;

class ProgramTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = ['media', 'program_category'];

    protected $defaultIncludes = [
        'program_category',
        'sales',
        'merchant'
    ];

    public function transform(Program $program)
    {

        $response =  [
            'name' => $program->name,
            'uuid' => (string)$program->uuid,
            'description' => $program->description,
            'link' => $program->link,
            'merchant_id' => $program->merchant_id,
            'program_category_id' => $program->program_category_id,
            'program_reward' => $program->programReward->percentage ?? null,
            'subscribed' => $program->subscribed,
            'subscribed_uuid' => $program->subscribedUUID,
            'created_at' => $program->created_at->toIso8601ZuluString()
        ];

        if (auth()->user()->hasRole('admin') || auth()->user()->id == $program->merchant->user->id) {
            $response['approved'] = (boolean)$program->approved;
            $response['rejected'] = (boolean)$program->rejected;
            $response['rejected_reason'] = $program->rejected_reason;
            $response['clicks'] = $program->clicks;
            $response['affiliates_count'] = $program->subscribers->count();
        }

        return $response;
    }

    public function includeSales(Program $program)
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->id == $program->merchant->user->id) {
            return $this->collection($program->sales, new SaleTransformer);
        }
        return null;
    }

    public function includeMedia(Program $program)
    {
        return $this->collection($program->media, new ProgramMediaTransformer);
    }

    public function includeMerchant(Program $program)
    {
        return $this->item($program->merchant, new MerchantTransformer());
    }

    public function includeProgramCategory(Program $program)
    {
        if ($program->ProgramCategory){
            return $this->item($program->ProgramCategory, new ProgramCategoryTransformer());
        }
        else{
            return null;
        }
    }

}
