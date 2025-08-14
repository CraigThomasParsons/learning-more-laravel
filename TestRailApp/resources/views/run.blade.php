@extends('layouts.main')

@section('content')

<div class="section no-pad-bot" id="index-banner">
  <div class="container">
  <br/><br/>
  <div class="row center">
    <h2>Test Run {{$run['name']}}</h2>
  </div>

  <table id='Tests'>
    <tbody>
<?php
   if ($tests != null) {
     foreach ($tests as $index => $test) {
          echo "<tr>";
          echo '  <td>';
          echo '    <a href="' . URL::route('test', ['testId' => $test['id']]).'"><h2>' . $test['title'] . '</h2></a>';
          echo '  </td>';
          echo '</tr>';

          ?>
          <tr>
            <td>
              <table class="striped">
                <thead>
                  <tr>
                    <th>
                      Content
                    </th>
                    <th center-align">
                      Expected
                    </th>
                    <th>
                      {{-- Additional Info --}}
                    </th>
                  </tr>
                </thead>
                <tbody>
          <?php
          if ($test['custom_steps_separated'] != null) {
            foreach ($test['custom_steps_separated'] as $key => $step) {
              echo '<tr>';
              echo '  <td>';
              if (isset($step['content'])) {
                  echo \Illuminate\Mail\Markdown::parse($step['content']);
              }
              echo '  </td>';
              echo '  <td>';
              if (isset($step['expected'])) {
                  echo \Illuminate\Mail\Markdown::parse($step['expected']);
              }
              echo '  </td>';
              echo '  <td>';
              if (isset($step['additional_info'])) {
                  echo \Illuminate\Mail\Markdown::parse($step['additional_info']);
              }
              echo '  </td>';
              echo '</tr>';
            }
          }
          ?>
                </tbody>
              </table>
            </td>
          </tr>
        </tbody>
      </table>
    <?php
     }

   }
    // echo '<pre>';
    // print_r($tests);
    // echo '</pre>';
    
    // echo '<pre>';
    // print_r($plan);
    // echo '</pre>';
    ?>
    </tbody>
  </table>
@stop