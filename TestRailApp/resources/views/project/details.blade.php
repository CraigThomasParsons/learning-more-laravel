@extends('layouts.main')

@section('content')
    <div class="section no-pad-bot" id="index-banner">
        <div class="container">
            <br><br>
            <div class="row center">
                <h3> Test Rail | {{ $project['name'] }}</h3>
            </div>

            <?php
            if ($project['show_announcement'] > 1) {
                echo \Illuminate\Mail\Markdown::parse($project['announcement']);
            }
            ?>

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
                        echo '<td>';
                        echo '  <a href="' . $plan['url'] . '" target="_blank" rel="noopener noreferrer">';
                        echo '    <img src="https://static.testrail.io/7.1.3.1037/images/layout/testrail-logo.svg">';
                        echo '  </a>';
                        echo '</td>';
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
        </div>
    </div>
@stop
