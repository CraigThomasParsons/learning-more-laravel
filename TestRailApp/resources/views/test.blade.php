@extends('layouts.main')

@section('content')

<div class="section no-pad-bot" id="index-banner">
  <div class="container">
  <br><br>
  <div class="row center">
    <h1> Test {{$test['title']}} </h1>
  </div>
  <pre>
  </pre>

  <table id="Steps" class="striped">
    <thead>
      <tr>
        <th>
          Content
        </th>
        <th>
          Expected
        </th>
        <th>
          {{-- Additional Info --}}
        </th>
      </tr>
    </thead>
    <tbody>
<?php
foreach ($test['custom_steps_separated'] as $key => $step) {
  echo '<tr>';
  echo '  <td>' . $step['content'] . '</td>';
  echo '  <td>' . $step['expected'] . '</td>';
  echo '  <td>' . $step['additional_info'] . '</td>';
  echo '</tr>';
}
?>
    </tbody>
  </table>

  <table id='Results' class='striped'>
    <thead>
        <tr>
        </tr>
      </thead>
    <tbody>
      <pre>
    <?php

      // This needs a lot of work.
      // foreach ($results as $key => $result) {
      //   print_r($result);
      // }
    ?>
      </pre>
    </tbody>
  </table>
@stop