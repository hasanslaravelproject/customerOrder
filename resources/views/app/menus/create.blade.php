@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('menus.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.menus.create_title')
            </h4>
            
            <form  action="{{route('savefinalmenu')}}" method="POST">
                        @csrf
            
            <div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="order">
                <div class="row">
                    <div class="col-lg-4">
                  
                @include('app.menus.form-inputs')
                
                <div class="mt-4">
                    <a href="{{ route('menus.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>
                   
                </div>
        </div>
        
    </div>
</div>
</div>
</div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <div class="shop-list border">
                <h2>Food Check Box</h2>
                <div class="boxes">
                    @foreach ($food as $food)
                    
                    <input type="checkbox" class="select" name="select" data-id="#{{$food->id }}" value="{{ $food->id }}" data-name="{{$food->name}}">
                    <label for="vehicle1"> {{$food->name}}</label><br>
                    
                    @endforeach
                    
                    @foreach ($fixedfood as $ff)
                    <input type="checkbox" class="select" name="select" data-id="#{{$ff->id }}" value="{{ $ff->id }}" data-name="{{$ff->name}}">
                    <label for="vehicle1"> {{$ff->name}}</label><br>
                    @endforeach
                </div>
               
                    </div>
                </div>
                
                <div class="col-lg-8">
                   
                        <br>
                        
                        
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Food Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Unit Name</th>
                                    
                                    
                                </tr>
                            </thead>
                            <tbody id="addedbox">
                                
                                
                                
                                
                                
                                </tbody>
                            </table>
                            
                       
                        
                        
                        
                        <i class="icon ion-md-save"></i>
                        @lang('crud.common.create')
                        <br>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary float-right">Submit </button>
            </form>
</div>
@php
    $i=1;
@endphp
@foreach ($fgroup as $fg)
<p>Group: {{$i++}}</p>
<ul>
@foreach ($fg as $g)
    @if ($loop->first)
    <input type="checkbox"  data-id="#{{ $g->id }}g" class="foodgroup" data-val='{{ $g->id }}g' value="{{$g->menu_category_id}}" name="" id="">
        
    @endif
<li data-name="{{ $g->name }}">{{$g->name}}</li>

@endforeach
</ul>
@endforeach



<style>
    .food{
        margin-bottom: 8px;
        display: block;
    }
    .qi{
        margin-bottom: 20px;
    }

    span.full {
        border: 1px solid #000;
        padding: 3px;
    }
    span.half {
        border: 1px solid #000;
        padding: 3px;
    }
</style>


<script>


    
    
        let getSiblings = function (e) {
            // for collecting siblings
            let siblings = []; 
            // if no parent, return no sibling
            if(!e.parentNode) {
                return siblings;
            }
            // first child of the parent node
            let sibling  = e.parentNode.firstChild;
            // collecting siblings
            while (sibling) {
                if (sibling.nodeType === 1 && sibling !== e) {
                    siblings.push(sibling);
                }
                sibling = sibling.nextSibling;
            }
            return siblings;
        };
     
        
    $('.foodgroup').on('change', function(){
        if($(this).prop('checked') === true){
            let sibs = getSiblings(document.querySelector('.foodgroup'));
            let gid = '';
            gid = $(this).attr('data-id')
            $('#addedbox').append(
                `<tr id='${$(this).attr('data-val')}'>
                    
                </tr>`
            )
            sibs.forEach(function(sib, index){
                $(gid).append(
                    
                    `
                    <tr>
                    <td>${sib.innerText}</td>
                    <td><input class="quantity"  name="quantity[]" type="text"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    </tr>
                    `
                )
            })
        }else{
            ($($(this).attr('data-id')).remove());
            $($(this).attr('data-val')).remove();
        }
    })
    
    
    
    
    
    let foodid = '';
     
    $('.select').on('change', function(){
        if($(this).prop('checked') === true){
            foodid= this.value;
            
            $('#addedbox').append(
            ` <tr id='${$(this).attr('value')}'>
                    <td>${$(this).attr('data-name')}</td>
                    <input type="hidden" value="${this.value}" name="food_id[]">
                    <td><input class="quantity" onkeyup="quantityfood(this)" name="quantity[]" type="text"></td>
                    <td>
                 
                    </td>
                    <td>
                    
                    </td>
                    <td style="width:150px">
                    </td>
                </tr>`
        )
        
        }else{
            $($(this).attr('data-id')).remove();
            
        }
      
    })
       
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    
    
       function quantityfood($this){
        $.ajax({
            url:`{{ route('menus.showunit') }}`,
            type: "GET",
            data:{
                'foodid':foodid
            }
        }).done(function(data){
            console.log(data);
            //$($this).closest('td').next('td').next('td').empty();
            //$($this).closest('td').next('td').empty();
            //$($this).closest('td').next('td').next('td').next('td').empty();
           // console.log($($this).closest('td').prev('td').prev('input'));
            $($this).closest('td').next('td').empty();
            $($this).closest('td').next('td').append(
                `${data}`
            );
        
                    
        });
       
       }
       
       
       let countarr = [];
      let sum = 0;
      
      function countquantity(){
          countarr = [];
          sum = 0;
          $('.quantity').each(function(){
              countarr.push(parseInt($(this).val()));
          })
             
        for (let i = 0; i < countarr.length; i++) {
            sum += countarr[i];
        }
        callquantity(countarr)
        }
        
 
</script>
            
            

           
        </div>



    </div>
    
  
</div>



@endsection