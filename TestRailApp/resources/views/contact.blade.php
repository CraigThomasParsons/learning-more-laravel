@extends('layouts.main')

@section('content')
  <span style="visibility: hidden;">Contact</span>
    <div class="container">
        <div class="row center">
            <div class="entry-content">
              <?php
                  // Used for testing.
                  echo '<p class="about-page-paragraph">'.print_r($postContent, true).'</p>';
              ?>
            </div>
        </div>
    </div>
@stop
