@extends('layouts.main')

@section('content')

<div class="section no-pad-bot" id="index-banner">
  <div class="container">
  <br><br>
  <div class="row center">
    <h1> Test Plan {{$plan['name']}} </h1>
  </div>

<?php
    echo \Illuminate\Mail\Markdown::parse($plan['description']);
?>

  <table id='Tests' class='striped'>
    <thead>
        <tr>
        </tr>
      </thead>
    <tbody>
    <?php

    foreach ($plan['entries'] as $index => $entry) {
        foreach ($entry['runs'] as $index => $run) {
            echo "<tr>";
            echo '  <td>';
            echo '    <a href="' . URL::route('run', ['runId' => $run['id']]).'">' . $run['name'] . '</a>';
            echo '  </td>';
            echo '<td>';
            echo '  <a href="' . $run['url'] . '" target="_blank" rel="noopener noreferrer">';
            echo '    <img src="https://static.testrail.io/7.1.3.1037/images/layout/testrail-logo.svg">';
            echo '  </a>';
            echo '</td>';
            echo "</tr>";
        }
    }
    ?>
    </tbody>
  </table>
@stop