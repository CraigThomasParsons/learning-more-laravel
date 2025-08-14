@extends('layouts.main')

@section('content')

  <div class="section no-pad-bot" id="index-banner">
  <div class="container">
  <br><br>
  <div class="row center">
    <h2> Test Rail </h2>
  </div>

<?php
echo "<table>";

echo "<tr>";

foreach (array_keys($list->first()) as $column_name) {
    echo '<td>'.$column_name.'</td>';
}
echo "</tr>";

foreach ($list as $index => $row) {

    echo "<tr>";
    foreach($row as $data) {
        echo '<td>'.$data.'</td>';

    }
    echo "</tr>";
}
echo "</table"; ?>
  
@stop