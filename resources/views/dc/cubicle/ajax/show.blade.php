<style>
    .card-img {
        width: 120px;
        height: 120px;
    }

    .card-img img {
        width: 120px;
        height: 120px;
        object-fit: cover;
    }

</style>
 

<div class="d-lg-flex">

    <div class="project-left w-100 py-0 py-lg-5 py-md-0">
        <!-- ROW START -->
        <div class="row">
            <!--  USER CARDS START -->
            <div class="col-lg-12 col-md-12 mb-4 mb-xl-0 mb-lg-4 mb-md-0"> 
               
                <div class="row">
                    <div class="col-xl-6 col-md-6 mb-4 mb-lg-0"> 
                        <x-cards.data :title="__('modules.dc.cubicle')" class=" mt-4">
                            <x-cards.data-row :label="__('modules.dc.outgoing_id')"
                                :value="(!is_null($cubicle->OUTGOING_ID)) ? ucwords($cubicle->OUTGOING_ID) : '--'" />
        
                            <x-cards.data-row :label="__('modules.dc.outgoing-name')" :value="ucwords($cubicle->CUBICLE_NAME)" /> 

                            <x-cards.data-row :label="__('modules.dc.incoming-name')" :value="(!is_null($cubicle->dcIncomingFeeder) && !is_null($cubicle->dcIncomingFeeder->NAMA_ALIAS_INCOMING)) ? ucwords($cubicle->dcIncomingFeeder->NAMA_ALIAS_INCOMING) : '--'" />

                            <x-cards.data-row :label="__('modules.dc.apj')" :value="(!is_null($cubicle->ApjId) && !is_null($cubicle->ApjId->APJ_NAMA)) ? ucwords($cubicle->ApjId->APJ_NAMA. ' '.$cubicle->ApjId->APJ_DCC) : '--'" />
            
                            <x-cards.data-row :label="__('modules.dc.supply-nama')" :value="(!is_null($cubicle->SupplyApj) && !is_null($cubicle->SupplyApj->APJ_NAMA)) ? ucwords($cubicle->SupplyApj->APJ_NAMA.' '.$cubicle->ApjId->APJ_DCC) : '--'" /> 
                            <x-cards.data-row :label="__('modules.dc.supply-nama')" :value="(!is_null($lr)  ) ? ucwords($lr) : '--'" /> 
                            <x-cards.data-row :label="__('modules.dc.condition')" :value="(!is_null($condition)  ) ? ucwords($condition) : '--'" />
                            @if($cubicle->PD_LEVEL != null)
                            <div class="col-12 px-0 pb-3 d-flex">
                                <p class="mb-0 text-lightest f-14 w-30 d-inline-block text-capitalize">@lang('modules.dc.level')</p>
                                <p class="mb-0 text-dark-grey f-14">
                                    <x-status :value="ucfirst($cubicle->PD_LEVEL)"
                                        :style="'color:'.$levelClr" />
                                </p> 
                            </div>
                            @endif
                            <x-cards.data-row :label="__('modules.dc.ia')" :value="(!is_null($cubicle->IA)  ) ? ucwords($cubicle->IA ) : '--'" />
                            <x-cards.data-row :label="__('modules.dc.ib')" :value="(!is_null($cubicle->IB)  ) ? ucwords($cubicle->IB ) : '--'" />
                            <x-cards.data-row :label="__('modules.dc.ic')" :value="(!is_null($cubicle->IC)  ) ? ucwords($cubicle->IC ) : '--'" /> 
                            <x-cards.data-row :label="__('modules.dc.vll')" :value="(!is_null($cubicle->VLL)  ) ? ucwords($cubicle->VLL ) : '--'" />
 
                        </x-cards.data>
                    </div> 
                </div>
                

            </div>
            <!--  USER CARDS END -->  
        </div>
        <!-- ROW END -->
    </div>
 
</div>
