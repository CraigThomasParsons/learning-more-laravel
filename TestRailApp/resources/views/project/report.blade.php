@extends('layouts.main')

@section('content')
    <div class="section no-pad-bot" id="index-banner">
        <div class="container">
            <br><br>
            <div class="row center">
                <h3> Test Rail | <a href="{{ URL::route('showProject', ['projectId' => $project['id']])}}">{{ $project['name'] }}</a></h3>
            </div>
            <form method="GET" action="{{ URL::route('project', ['projectId' => $project['id']]) }}">
                <div class="row">
                    <div class="col s6">
                        <div class="checkbox-list-inner">
                            <div class="checkbox-list-toolbar toolbar toolbar-compact">
                                <div class="toolbar-inner text-secondary">
                                    Select <a class="link" href="javascript:void(0)"
                                        onclick="this.blur(); App.Controls.Checkboxes.checkAll('statusSelection'); return false;">All</a>
                                    <a class="link" href="javascript:void(0)"
                                        onclick="this.blur(); App.Controls.Checkboxes.checkNone('statusSelection'); return false;">None</a>
                                </div>
                            </div>
                    <?php
                        foreach ($statuses as $index => $status) {
                    ?>
                            <div class="Checkbox">
                                <label>
                                    <input
                                        id="statusSelection-{{ $status['id'] }}"
                                        name="statusSelection[]"
                                        type="checkbox"
                                        value="{{ $status['id'] }}"
                                    />
                                    <span>{{ $status['label'] }}</span>
                                </label>
                            </div>
                    <?php
                        }
                    ?>
                        </div>
                        <br/>
                        <button class="btn" type="submit">
                            Filter
                        </button>
                    </div>

                    <div class="col s6">
                        <div class="checkbox-list-toolbar toolbar toolbar-compact">
                            <div class="toolbar-inner text-secondary">
                                Select
                                <a class="link" href="javascript:void(0)"
                                    onclick="this.blur(); App.Controls.Checkboxes.checkAll('userSelection'); return false;">All
                                </a>
                                <a class="link" href="javascript:void(0)"
                                    onclick="this.blur(); App.Controls.Checkboxes.checkNone('userSelection'); return false;">None
                                </a>
                            </div>
                        </div>

                        <select name='selectedPeople[]' class="people" multiple="multiple" style="width: 75%">
                            <?php
            foreach ($peopleFilter as $key => $person) {
        ?>

                            <option value="{{ $person->user_id }}"
                                <?php if (($selectedPeople!=null) && in_array($person->user_id, $selectedPeople)) { ?>
                                    selected="selected"
                                <?php } ?>>
                                {{ $person->fullName }}
                            </option>
                            <?php
            }
        ?>
                        </select>
                    </div>
                </div>
            </form>

            <table id='Suites' class='striped'>
                <thead>
                    <tr>
                        <h2>Test Suites</h2>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        foreach ($suites as $index => $suite) {
                            if (isset($suite['runs']) && count($suite['runs']) > 0) {
                                echo '<tr>';
                                echo '  <td>';
                                echo '    <a href="' . URL::route('run', ['runId' => $suite['id']]) . '">';
                                echo 'S' . $suite['id'] . '&nbsp;' . $suite['name'];
                                echo '</a>';
                                echo '  </td>';

                                echo '  <td>';
                                if (isset($suite['assignedto_id']) && $suite['assignedto_id'] > 0) {
                                    echo '<a href="' . URL::route('person', ['id' => $suite['assignedto_id']]) . '">';
                                }
                                if (isset($suite['assignedToName'])) {
                                    echo $suite['assignedToName'];
                                }
                                if (isset($suite['assignedto_id']) && $suite['assignedto_id'] > 0) {
                                    echo '</a>';
                                }
                                echo '  </td>';
                                echo '  <td>';
                                echo '    <a href="' . $suite['url'] . '" target="_blank" rel="noopener noreferrer">';
                                echo '      <img src="https://static.testrail.io/7.1.3.1037/images/layout/testrail-logo.svg">';
                                echo '    </a>';
                                echo '  </td>';
                                echo '</tr>';

                                if (isset($suite['runs'])) {
                                    foreach ($suite['runs'] as $index => $run) {
                                        echo '<tr>';
                                        echo '  <td>';
                                        echo '    <a href="' . URL::route('run', ['runId' => $run['id']]) . '">';
                                        echo 'R' . $run['id'] . '&nbsp;' . $run['name'];
                                        echo '    </a>';
                                        echo '  </td>';

                                        echo '  <td>';
                                        if (isset($run['assignedto_id']) && $run['assignedto_id'] > 0) {
                                            echo '<a href="' . URL::route('person', ['id' => $run['assignedto_id']]) . '">';
                                        }
                                        if (isset($run['assignedToName'])) {
                                            echo $run['assignedToName'];
                                        }
                                        if (isset($run['assignedto_id']) && $run['assignedto_id'] > 0) {
                                            echo '</a>';
                                        }
                                        echo '  </td>';

                                        echo '  <td>';
                                        echo '    <a href="' . $run['url'] . '" target="_blank" rel="noopener noreferrer">';
                                        echo '      <img src="https://static.testrail.io/7.1.3.1037/images/layout/testrail-logo.svg">';
                                        echo '    </a>';
                                        echo '  </td>';

                                        echo '</tr>';
                                    }
                                }
                            }
                        }
                    ?>
                </tbody>
            </table>
            <table id='Runs' class='striped'>
                <thead>
                    <tr>
                        <h2>Test Runs</h2>
                    </tr>
                </thead>
                <tbody>
<?php

                    foreach ($runs as $index => $run) {
                        echo '<tr>';
                        echo '  <td>';
                        echo '    <a href="' . URL::route('run', ['runId' => $run['id']]) . '">' . $run['name'] . '</a>';
                        echo '  </td>';

                        echo '  <td>';
                        if (isset($run['assignedto_id']) && $run['assignedto_id'] > 0) {
                            echo '<a href="' . URL::route('person', ['id' => $run['assignedto_id']]) . '">';
                        }
                        if (isset($run['assignedToName'])) {
                            echo $run['assignedToName'];
                        }
                        if (isset($run['assignedto_id']) && $run['assignedto_id'] > 0) {
                            echo '</a>';
                        }
                        echo '  </td>';

                        echo '  <td>';
                        echo '  <td>';
                        echo '  <td>';
                        echo '    <a href="' . $run['url'] . '" target="_blank" rel="noopener noreferrer">';
                        echo '      <img src="https://static.testrail.io/7.1.3.1037/images/layout/testrail-logo.svg">';
                        echo '    </a>';
                        echo '  </td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>

            <table id='Plans' class='striped'>
                <thead>
                    <tr>
                        <h2>Test Plans</h2>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($plans as $index => $plan) {
                            echo '<tr>';
                            echo '  <td>';
                            echo '    <a href="' . URL::route('plan', ['planId' => $plan['id']]) . '">' . $plan['name'] . '</a>';
                            echo '  </td>';
                            echo '  <td>';
                            echo '    <a href="' . $plan['url'] . '" target="_blank" rel="noopener noreferrer">';
                            echo '      <img src="https://static.testrail.io/7.1.3.1037/images/layout/testrail-logo.svg">';
                            echo '    </a>';
                            echo '  </td>';
                            echo '  <td>';
                            echo '    <pre>';
                            print_r($plan);
                            echo '    </pre>';
                            echo '  </td>';
                            echo '</tr>';

                        }
                    ?>
                </tbody>
            </table>
            <script>
                $(document).ready(function() {
                    $('.people').select2();
                });
            </script>
        @stop
