@permission($data['permission'])
    <a style="display:none;" class="panel-title collapsed accordion button" data-toggle="collapse" data-parent="#accordion" href="#accordion">
        Detail
    </a>
    <div class="row">
        <div class="col-sm-12">
            <table class="table" align="center" width="100%" cellpadding="2" cellspacing="0" border="0" style="margin:0px; padding:0px; background:#FFF;">
                <thead>
                @php
                    $variationQry = App\Models\ProductVariation::get();
                @endphp
                    <tr>
                        <th width="100%" class="dtl-head text-center" align="center" colspan="6" style="background-color:#90EE90;">Product Detail</th>
                        <!--<th width="70%" class="dtl-head text-center" align="center" colspan="6" rowspan="2" style="background-color:#FFA500;">Property Detail</th> -->
                    </tr>
                    <tr>
                        <th width="6%" class="dtl-head text-center" align="center">Sr#</th>
                        <th width="10%" class="dtl-head text-center" align="center">Booking No</th>
                        <th width="10%" class="dtl-head text-center" align="center">File Status</th>
                        <th width="10%" class="dtl-head text-center" align="center">Payment Mode</th>
                        <th width="10%" class="dtl-head text-center" align="center">Sale Price</th>
                        <th width="10%" class="dtl-head text-center" align="center" >Booking Price</th>
                    </tr>
                </thead>
	            <tbody>
                @php
                // dd($current);
                    $outerQry = App\Models\SaleSeller::where('sale_sellerable_id',$current->id)->get();
                    // dd($outerQry);
                    $innervariationQry = App\Models\ProductVariation::get();
                    $i=1;
                @endphp
                @foreach($outerQry as $value)
                @php
                    $innerQry = App\Models\Sale::where('id',$value['sale_id'])->with('property_payment_mode', 'file_status','product')->first();
                @endphp
                    <tr>
                        <td class="dtl-contents" align="center">
                            {{ $i }}
                        </td>
                        <td class="dtl-contents" align="center">
                            {{ $innerQry->code }}
                        </td>
                        <td class="dtl-contents" align="center">
                            {{ $innerQry->file_status->name }}
                        </td>
                        <td class="dtl-contents" align="center">
                            {{ $innerQry->property_payment_mode->name }}
                        </td>
                        <td class="dtl-contents" align="center">
                            {{ number_format($innerQry->sale_price,0) }}
                        </td>
                        <td class="dtl-contents" align="center">
                            {{ number_format($innerQry->booked_price,0) }}
                        </td>
                        <!--<td class="dtl-contents" align="left">
                        @php
                        $prod = $innerQry->product_id;

                        $sql = "SELECT p.id p_id,p.code p_code,p.name p_name,p.buyable_type_id,pvs.value,pvs.product_variation_id,pv.display_title,pvs.sr_no FROM products p
                                left join property_variations pvs on pvs.product_id = p.id
                                left join product_variations pv on pv.id = pvs.product_variation_id
                                where p.id = $prod order by pv.display_title";

                                $variations = \Illuminate\Support\Facades\DB::select($sql);
                                $lists = [];
                                foreach ($variations as $variation){
                                    $lists[$variation->display_title][] = $variation->value;
                                    $p_name = $variation->p_name;
                                    $p_code = $variation->p_code;
                                }

                        @endphp
                            <b>Product Code : </b> {{ $p_code }} &nbsp;&nbsp;
                            <b>Product Name : </b> {{ $p_name }} <br>
                            @foreach($lists as $title=>$rows)
                                <b>{{ $title }} : </b>
                                @if(count($rows) == 1)
                                    @foreach($rows as $k=>$val)
                                        <span>{{$val}}</span>&nbsp;&nbsp;
                                    @endforeach
                                @else
                                    @foreach($rows as $ki=>$val)
                                        <span>{{$val}}, </span>&nbsp;&nbsp;
                                    @endforeach
                                @endif
                            @endforeach
                        </td>-->
                    </tr>
                    @php $i++; @endphp
                @endforeach
	            </tbody>
            </table>
        </div>
    </div>
@endpermission

@section('pageJsScript')
    <script src="{{ asset('/pages/sale/customer/create.js') }}"></script>
@endsection

@section('scriptCustom')
    <script src="{{ asset('/js/jquery-inputmask.js') }}"></script>
@endsection
