<?php
/**
 * To display error in the page.
 * In linux by default its not available to show.
 * Comment out below lines for debug ro something.
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Create simple autoloader to load the files from the Classes
 * folder.
 * There are two classes in this folder : 
 * Database  : To Make connection with database and handle database.
 * Jobs : Which is used to Fetch jobs from the sql table jobs of pankaj database.
 */
spl_autoload_register(function($className) 
{
    // subfolder paths where your file located. File name should be same as class name.
    $folders = ['Classes'];

    foreach($folders as $folder) {
        require_once(__DIR__.'/'.$folder."/".$className. ".php");
    }

});


// Create object of Jobs class which extends database class.
$Jobs = new Jobs();


// get skills set when post request send by the user from form.
if($_SERVER['REQUEST_METHOD'] === "POST") 
{ 
    if(isset($_POST['search'])) {
        echo(
            json_encode($Jobs->search(
                $Jobs->parseSkillsQuery($_POST['search'])
            ))
        );
    }
    die(); // it is an ajax request so we don't have to show any content. JUST DIE!
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>A simple ost assignment of CA</title>

    <!--@CSS-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/app.css">

    <!--@ICONS-->
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>

<body>
    <!--Search form section-->
    <section class="section section-main">
        <form action="" method="post" autocomplete="off" id="search">
            <h5 class="subtitle is-5">Search For Jobs</h5>
            <small class="has-text-danger is-hidden" id="searchMessage">No result found for this query</small>
            <div class="field has-addons is-12">
                
                <div class="control has-icons-left is-expanded">
                    <input type="search" id="input" name="search" class="input is-medium"
                        placeholder="Enter Skill Set seperated by comma if it is multiple" required>
                    <span class="icon is-left"> <i class="fa fa-search"></i></span>
                </div>

                <div class="control">
                    <button class="button is-medium is-black">Search</button>
                </div>
            </div>
            <label for="input" class="label">Note: Enter skills seperated by comma. If you wanna search jobs for multile skills at one time</label>
                
        </form>
    </section>

    <!--@jobs-List-Section-->
    <section class="section is-hidden" id="jobs">
        <div class="jobs">
            <h5 class="subtitle is-5">All Matched For: <span id="queryString"></span></h5>
            <div class="joblist" id="joblist">
                <p>Search to see the results</p>
            </div>
        </div>
    </section>

    <!--@SCRIPTS-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $("#search").on("submit", function () {
            event.preventDefault();

            // get the skills query
            let query = document.getElementById("input").value;
            $("#queryString").html(query);

            // send the ajax request to server
            $.post( window.location.href, {
                search: query // pass the query
            }, function (results) {

                // get the result.
                results = JSON.parse(results);

                // if result is empty then notify the user
                if (results === null) {
                    $("#searchMessage").removeClass("is-hidden");
                    $("#jobs").addClass("is-hidden");
                } 
                else {
                    // display the jobs
                    $("#searchMessage").addClass("is-hidden");
                    $("#jobs").removeClass("is-hidden");
                    $("#joblist").html("");

                    $('html, body').animate({
                        scrollTop: $("#jobs").offset().top
                    }, 600);

                    // loop through each jobs and append that in the list.
                    $.each(results, function (key, value) {
                        $("#joblist").append(`
                        <article class="media">
                            <div class="media-content">
                                <div class="content">
                                    <aside class="menu">
                                        <p class="menu-label has-text-weight-semibold">${value['title']}</p>
                                        <p>${value['description']}</p>
                                        <ul class="menu-list">
                                            <li>Required Skills : ${value['required_skills']}</li>
                                            <li>Company: ${value['company_name']}</li>
                                            <li>Posted On: ${value['created_at']}</li>
                                        </ul>
                                    </aside>
                                </div>
                            </div>
                        </article>
                        `);
                    });

                }
            });
        });
    </script>
</body>

</html>