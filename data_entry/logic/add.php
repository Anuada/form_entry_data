<?php

include "../util/dbhelper.php";
$db = new DbHelper();

if (isset($_POST["submit"])) {
    // Collect user data
    $name = $_POST["name"];
    $age = $_POST["age"];
    $sex = $_POST["sex"];
    $status = $_POST["status"];
    $date_birth = $_POST["date_birth"];
    $p_birth = $_POST["p_birth"];
    $h_address = $_POST["h_address"];
    $occupation = $_POST["occupation"];
    $religion = $_POST["religion"];
    $contact_num = $_POST["contact_num"];
    $pantawid = $_POST["pantawid"];
    $elementary = $_POST["elementary"];
    $high_school = $_POST["high_school"];
    $vocational = $_POST["vocational"];
    $college = $_POST["college"];
    $others = $_POST["others"];
    $school_community = $_POST["school_community"];
    $civic_community = $_POST["civic_community"];
    $community_activities = $_POST["community_activities"];
    $workspace_community = $_POST["workspace_community"];

    // Collect family members data
    $family_names = $_POST["family_name"] ?? [];
    $family_relationships = $_POST["family_relationship"] ?? [];
    $family_ages = $_POST["family_age"] ?? [];
    $family_birthdays = $_POST["family_birthday"] ?? [];
    $family_occupations = $_POST["family_occupation"] ?? [];

    // Collect seminar data
    $title_trainings = $_POST["title_training"] ?? [];
    $date_trains = $_POST["date_train"] ?? [];
    $organizers = $_POST["organizer"] ?? [];

    // Check if all required fields are filled
    if (
        !empty(trim($name)) &&
        !empty(trim($age)) &&
        !empty(trim($sex)) &&
        !empty(trim($status)) &&
        !empty(trim($date_birth)) &&
        !empty(trim($h_address)) &&
        !empty(trim($occupation)) &&
        !empty(trim($religion)) &&
        !empty(trim($contact_num)) &&
        !empty(trim($elementary)) &&
        !empty(trim($high_school)) &&
        !empty(trim($vocational)) &&
        !empty(trim($college)) &&
        !empty(trim($others)) &&
        !empty(trim($school_community)) &&
        !empty(trim($civic_community)) &&
        !empty(trim($community_activities)) &&
        !empty(trim($workspace_community)) &&
        !empty(trim($pantawid))
    ) {
        try {
            // Insert user data into 'data_entry_table'
            $addUserQuery = "INSERT INTO data_entry_table 
                (name, age, sex, status, date_birth, p_birth, h_address, occupation, religion, contact_num, pantawid, 
                elementary, high_school, vocational, college, others, school_community, civic_community, community_activities, workspace_community) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($addUserQuery);
            $stmt->bind_param(
                "sissssssssssssssssss",
                $name,
                $age,
                $sex,
                $status,
                $date_birth,
                $p_birth,
                $h_address,
                $occupation,
                $religion,
                $contact_num,
                $pantawid,
                $elementary,
                $high_school,
                $vocational,
                $college,
                $others,
                $school_community,
                $civic_community,
                $community_activities,
                $workspace_community
            );

            if ($stmt->execute()) {
                $userId = $db->getInsertId(); // pagkuha sa inserted user's ID
                $stmt->close();

                // pagsulod sa family members data into 'family_composition' table
                if (!empty($family_names) && count($family_names) === count($family_relationships)) {
                    $addFamilyQuery = "INSERT INTO family_composition (user_id, family_name, relationship, age, birthday, occupation) 
                                       VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $db->prepare($addFamilyQuery);

                    foreach ($family_names as $index => $family_name) {
                        $family_age = $family_ages[$index] ?? null;
                        $family_birthday = $family_birthdays[$index] ?? null;
                        $family_occupation = $family_occupations[$index] ?? null;

                        $stmt->bind_param(
                            "ississ",
                            $userId,
                            $family_name,
                            $family_relationships[$index],
                            $family_age,
                            $family_birthday,
                            $family_occupation
                        );
                        $stmt->execute();
                    }
                    $stmt->close();
                }

                // Insert seminar data into 'seminar_trainings' table
                if (
                    !empty($title_trainings) &&
                    count($title_trainings) === count($date_trains) &&
                    count($title_trainings) === count($organizers)
                ) {
                    $addSeminarQuery = "INSERT INTO seminar_trainings (user_id, title_trainings, date_train, organization) 
                                        VALUES (?, ?, ?, ?)";
                    $stmt = $db->prepare($addSeminarQuery);

                    foreach ($title_trainings as $index => $title_training) {
                        $date_train = $date_trains[$index] ?? null;
                        $organizer = $organizers[$index] ?? null;

                        $stmt->bind_param(
                            "isss",
                            $userId,
                            $title_training,
                            $date_train,
                            $organizer
                        );
                        $stmt->execute();
                    }
                    $stmt->close();
                }

                // Redirect to success page
                header("Location: ../?m=DATA+ADDED+SUCCESSFULLY");
                exit();
            } else {
                throw new Exception("Failed to execute user insertion query.");
            }
        } catch (Exception $e) {
            // Log the error and redirect
            error_log("Error: " . $e->getMessage());
            header("Location: ../?m=ERROR+OCCURRED");
            exit();
        }
    } else {
        // Redirect if form validation fails
        header("Location: ../?m=VALIDATION+FAILED");
        exit();
    }
} else {
    // Redirect if the form wasn't submitted
    header("Location: ../?m=NO+FORM+SUBMITTED");
    exit();
}

?>
