<div class="card-body">                
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                  <div class="row">
                  @foreach($order as $val)
                    <div class="col-md-2" style="padding-top:7px;color:white" >
                      <div class="card card-body bg-success itemCard" data-toggle="modal"
                      data-target="#exampleModal" data-id="{{$val->id}}">
                            @if($val->token_no==0)
                            <strong>{{$val->order_type}} #tb{{$val->table_no}}</strong>
                            @else
                            <strong>{{$val->order_type}} #{{$val->token_no}}</strong>
                            @endif
                            <table>
                            @foreach($val->items as $val)
                            <tr>
                            <td><small>{{$val->item_name}}</small></td>
                            <td><small>{{$val->quantity}}</small></td>
                            </tr>
                            @endforeach
                            </table>
                      </div>
                    </div>
                    @endforeach                    
                  </div>
                </div>
            </div>
</div>
        