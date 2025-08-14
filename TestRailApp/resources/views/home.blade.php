@extends('layouts.main')
<?php
$columns = ['Name', 'TestRail Link'];
?>
@section('content')
    <div class="section no-pad-bot" id="index-banner">
        <div class="container">
            <br><br>
            <div class="row center">
                <h2> Test Rail | Projects.</h2>
            </div>
            <div class="entry-content">
                Filters:
                <a class="waves-effect waves-light btn-flat blue-text" href="{{ URL::route('incompleteProjects') }}"
                    title="Shows all projects without completed">
                    Only Incompleted
                </a>
                <a class="waves-effect waves-light btn-flat blue-text" href="{{ URL::route('allProjects') }}"
                    title="Including Completed">
                    All Projects
                </a>
                <div>
                    <input id="projectSearch" type="text" placeholder="Search" value=""/>
                </div>

                <table id='Projects' class='striped'>
                    <tbody>

                        <?php
                        foreach ($list as $index => $project) {
                            echo '<tr>';
                            echo '  <td>' . '<a href="' . URL::route('project', ['projectId' => $project['id']]) . '">' . $project['name'] . '</a></td>';

                            echo '  <td>';
                            echo '    <a href="' . $project['url'] . '" target="_blank" rel="noopener noreferrer">';
                            echo '      <img src="https://static.testrail.io/7.1.3.1037/images/layout/testrail-logo.svg">';
                            echo '    </a>';
                            echo '  </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>

            </div>
            <br><br>
        </div>
    </div>
    <script>
        $("#projectSearch").on("keyup", function() {
            let searchText = $(this).val().toLowerCase();
            console.log("going to search for: ", searchText);
            $("#Projects tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
            });
        });
    </script>
@stop