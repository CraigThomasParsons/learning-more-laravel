@extends('layouts.main')

@section('content')
<div id='main' class='wrapper'>
    <div id='maincontainer' class='maincontainer'>

        <div class='container gallery'>
        @foreach ($images as $imageRow)
            <div class="row valign-wrapper">
                @foreach ($imageRow as $image)
                <div class="col s12 m6 l3">
                 <img
                   class='materialboxed responsive-img'
                   src='{{ $image->guid }}'
                   data-title='{{ $image->post_title }}'
                   data-description='description'
                   width='101%'
                   height='101%'
                   style="margin-top:5px"
                 />
                </div>
                @endforeach
            </div>
        @endforeach
        </div>
        <script>
          $(document).ready(function(){
            $('.materialboxed').materialbox();
          });
        </script>
    </div>
</div>
@stop
