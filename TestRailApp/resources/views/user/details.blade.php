@extends('layouts.main')

@section('content')
<div class="section no-pad-bot" id="index-banner">
  <div class="container">
    <br><br>
    <div class="row center">
      <h2>Test Rail User {{ $person->user_id }}</h2>
    </div>

      <table>
        <thead>
          <th>Name</th>
          <th>Role</th>
        <thead>
        <tr>
          <td>{{$person->fullName}}</td>
          <td>{{ $person->role }}</td>
        </tr>
      </table>
      </div>
  </div>
@stop