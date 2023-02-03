<?php
include "CMS/db/connection.php";
$pdo = pdo_connect_mysql();
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Profile</title>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="./assets/fontawesome-free-6.2.0-web/css/fontawesome.css">
    <link rel="stylesheet" href="./assets/fontawesome-free-6.2.0-web/css/brands.css">
    <link rel="stylesheet" href="./assets/fontawesome-free-6.2.0-web/css/regular.css">
    <link rel="stylesheet" href="./assets/fontawesome-free-6.2.0-web/css/solid.css">
    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/stuff.css">
</head>

<body>


    <main>
        <section id='home' class='container py-5'>
            <?php
            $output = "";
            $stmt = $pdo->prepare("SELECT * FROM introduction");
            $stmt->execute();
            // Fetch the records so we can display them in our template.
            $intro = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($intro as $row) {
                $description = $row['description'];
                $profilePicture = $row['profilePicture'];

                $output .= "<div class='row row-cols-1 row-cols-xl-2'>
                                <div class='col pb-5'>
                                    <div class='image'>
                                        <img src='$profilePicture' class='img-fluid' alt=''>
                                    </div>
                                </div>
                                <div class='col'>
                                    <h1 class='mb-5 text-left'>About Me:</h1>
                                    <h1 class='mb-5 text-left'>Gabriela Ribeiro</h1>
                                    <p>$description</p>
                                </div>
                            </div>";
            }
            $output .= "";
            echo $output;
            ?>
        </section>
        <section id="skills" class="container py-5">
            <h2>Skills</h2>

            <div class="row row-cols-1 row-cols-md-2 text-white">
                <div class="col my-3">
                    <div class="card">
                        <div class="card-title my-2">
                            <h3>Soft Skills</h3>
                        </div>
                        <div class="card-body">
                            <ul>
                                <?php
                                $output = "";
                                $stmt = $pdo->prepare("SELECT * FROM soft_skills");
                                $stmt->execute();
                                // Fetch the records so we can display them in our template.
                                $softskills = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($softskills as $row) {
                                    $softskill_name = $row['softskill_name'];

                                    $output .= "<li>$softskill_name</li>";
                                }
                                $output .= "";
                                echo $output;
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col my-3">
                    <div class="card">
                        <div class="card-title my-2">
                            <h3>Hard Skills</h3>
                        </div>
                        <div class="card-body">
                            <ul>
                                <?php
                                $output = "";
                                $stmt = $pdo->prepare("SELECT * FROM hard_skills");
                                $stmt->execute();
                                // Fetch the records so we can display them in our template.
                                $hardskills = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($hardskills as $row) {
                                    $hardskill_name = $row['hardskill_name'];

                                    $output .= "<li>$hardskill_name</li>";
                                }
                                $output .= "";
                                echo $output;
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="languages" class="container py-5">
            <h2>Languages</h2>

            <div class="text-center justify-content-center">
                <?php
                $output = "";
                $stmt = $pdo->prepare("SELECT * FROM languages");
                $stmt->execute();
                // Fetch the records so we can display them in our template.
                $languages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($languages as $row) {
                    $language_name = $row['language_name'];
                    $language_level = $row['language_level'];

                    $output .= "<li>$language_name - $language_level</li>";
                }
                $output .= "";
                echo $output;
                ?>
            </div>
        </section>

        <section id="certifications" class="container py-5">
            <h2>Certifications</h2>

            <div class="text-center">
                <?php
                $output = "";
                $stmt = $pdo->prepare("SELECT * FROM certifications");
                $stmt->execute();
                // Fetch the records so we can display them in our template.
                $certifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($certifications as $row) {
                    $certification_name = $row['certification_name'];

                    $output .= "<p class='mb-0'>$certification_name</p>";
                }
                $output .= "";
                echo $output;
                ?>
            </div>
        </section>

        <section id="education" class="container py-5">
            <h2>Education</h2>
            <div class="text-center">
                <?php
                $output = "";
                $stmt = $pdo->prepare("SELECT * FROM education");
                $stmt->execute();
                // Fetch the records so we can display them in our template.
                $educations = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($educations as $row) {
                    $school_title = $row['school_title'];
                    $course_name = $row['course_name'];

                    $output .= "<p class='mb-0'>$school_title: $course_name</p>";
                }
                $output .= "";
                echo $output;
                ?>
            </div>
        </section>

        <section id="contact-me-form" class="container py-5">
            <h2>Contact Form</h2>

            <form autocomplete="off" role="form" action="/SIR-gabs/CMS/pages/contact-requests/createForm.php" method="post">
                <div class="form-group mb-3">
                    <label for="contact_name">Name</label>
                    <input type="text" id="contact_name" name="contact_name" class="form-control" aria-describedby="nameHelp" placeholder="Your name.." required>
                </div>

                <div class="form-group mb-3">
                    <label for="contact_email">Email</label>
                    <input type="email" id="contact_email" name="contact_email" class="form-control" aria-describedby="nameHelp" placeholder="Your email.." required>
                </div>

                <div class="form-group mb-3">
                    <label for="message">Subject</label>
                    <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                </div>

                <button type="submit" id="form-submit" class="btn">Submit</button>
                <button type="reset" id="form-reset" class="btn">Reset</button>
            </form>
        </section>

        <footer class="text-center py-5 w-100">
            <h4 class="text-white">Contacts</h4>
            <div class="mb-4 d-flex justify-content-center gap-5">
                <?php
                $output = "";
                $stmt = $pdo->prepare("SELECT * FROM contacts");
                $stmt->execute();
                // Fetch the records so we can display them in our template.
                $contact = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($contact as $row) {
                    $type = $row['type'];
                    $value = $row['value'];
                    $icon = $row['icon'];

                    $output .= "<a href='$value'>
                                    <img width='25' height='25' src='$icon'>
                                </a>";
                }
                $output .= "";
                echo $output;
                ?>
            </div>
            <h4 class="text-white">Gabriela Ribeiro &copy; 2022 </h4>
        </footer>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>