@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('orders.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.orders.create_title')
            </h4>
            
          
            
            <form  action="{{ route('orders.store') }}" method="POST">
                @csrf
                <label for="Customer"></label>
                @foreach ($user as $usr)
               
                <input onclick="usercheckbox(this)" class="user" type="checkbox" value="{{ $usr->id }}">  {{$usr->name}}   
              
                @endforeach
                
                <br>
                <br>
                @foreach ($menu as $menu)
                <div class="userdiv d-none">
                <input onclick="menucheckbox(this)" class="menu" type="checkbox" value="{{ $menu->menu_category_id }}">  {{$menu->menuCategory->name}}   
                </div>
                @endforeach
                <br>
                <br>
                <div class="menuname d-none">
                
                </div>
                
                <br>
                <br>
                <label for="delivery">Delivery</label> <br>
                <input type="date" name="delivery_date">
                <br>
                <br>
                <label for="guest">Number of Guest</label> <br>
                <input type="text" name="guest">
                <br>
                <br>
                   
                <br>
                <br>
              
                <button type="submit">Save</button>
            </form>
        </div>
    </div>
</div>

<script>
   $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    
    function usercheckbox($this){
        $('.userdiv').removeClass('d-none');
    }
    
    function menucheckbox($this){
        $('.menuname').removeClass('d-none');
    }
    
    $('.menu').on('click', function(){
        if ($(this).prop('checked')) {
            $.ajax({
                url:`{{ route('orders.catname') }}`,
                type: "GET",
                data:{
                    'menuid': this.value
                }
            }).done(function(data) {
                $('.menuname').empty();
                data.forEach(function(data){
                    $('.menuname').append(
                        `
                        <input type="checkbox" value="1"> ${data.id} menu
                        `
                    )

                })
            });
        }
    })

    





</script>
@endsection
