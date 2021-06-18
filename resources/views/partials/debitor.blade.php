
<div class="table-responsive">
    <table class="table dbt">
        <thead>
        <tr>
            <th>{{__('adnetwork.campaign_name')}}</th>
            <th>{{__('adnetwork.amount')}}</th>
            <th class="dbt-200">{{__('adnetwork.charged_amount')}}</th>
            <th>{{__('adnetwork.description')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td style="font-weight:500;">{{$item['campaign_name']}}</td>
                <td class="campaign_amount" data-campaign-id="{{$item['campaign_id']}}" style="cursor: pointer" data-amount="{{$item['chargeable_amount']}}">{{$item['chargeable_amount']}}</td>
                <td>
                    <div class="form-input">
                        <input value='0' name="campaigns[{{$item['campaign_id']}}]" type="text" class="campaign_debit" id="campaigns{{$item['campaign_id']}}" >
                    </div>
                </td>
                <td>
                    <div class="form-input">
                        <input value='{{$transaction['description']}}' name="descriptions[{{$item['campaign_id']}}]" type="text" id="descriptions{{$item['campaign_id']}}" >
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


