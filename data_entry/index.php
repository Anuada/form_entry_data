<?php
include "./util/dbhelper.php";
$db = new DbHelper();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Form with Multi-step</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        .form-control, .btn {
            margin-bottom: 1rem;
        }

        .btn-danger {
            margin-top: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <form id="multiStepForm" action="./logic/add.php" method="post">
        <input type="hidden" name="id" value="id">

            <!-- Step 1: User Information -->
            <div class="step active" id="step1">
                <h2 class="mb-4">User Information</h2>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" class="form-control" id="age" name="age" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="sex" class="form-label">Sex:</label>
                        <select class="form-select" id="sex" name="sex" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="date_birth" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="date_birth" name="date_birth" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="p_birth" class="form-label">Place of Birth</label>
                        <input type="text" class="form-control" id="p_birth" name="p_birth" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="h_address" class="form-label">Home Address</label>
                        <input type="text" class="form-control" id="h_address" name="h_address" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="occupation" class="form-label">Occupation</label>
                        <input type="text" class="form-control" id="occupation" name="occupation" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="religion" class="form-label">Religion</label>
                        <input type="text" class="form-control" id="religion" name="religion" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="contact_num" class="form-label">Contact Number</label>
                        <input type="number" class="form-control" id="contact_num" name="contact_num" required>
                    </div>
                </div>
                <h2 class="mb-4">4ps Pantawid:</h2>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="pantawidYes" name="pantawid" value="Yes">
                            <label for="pantawidYes" class="form-check-label">Yes</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="pantawidNo" name="pantawid" value="No">
                            <label for="pantawidNo" class="form-check-label">No</label>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
            </div>

            <!-- Step 2: Family Information -->
            <div class="step" id="step2">
                <h2 class="mb-4">Family Composition</h2>
                <table class="table table-bordered" id="familyTable">
                    <thead>
                        <tr>
                            <th>Name/Wife/Children</th>
                            <th>Relationship</th>
                            <th>Age</th>
                            <th>Birthday</th>
                            <th>Occupation</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" class="form-control" name="family_name[]"></td>
                            <td><input type="text" class="form-control" name="family_relationship[]"></td>
                            <td><input type="number" class="form-control" name="family_age[]"></td>
                            <td><input type="date" class="form-control" name="family_birthday[]"></td>
                            <td><input type="text" class="form-control" name="family_occupation[]"></td>
                            <td><button type="button" class="btn btn-danger" onclick="deleteFamilyMember(this)">Delete</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-secondary" onclick="addFamilyMember()">Add Member</button>

                <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
            </div>

            <!-- Step 3: Educational and Community Information -->
            <!-- Step 3: Educational and Community Information -->
<div class="step" id="step3">
    <h2 class="mb-4">Educational Attainment</h2>
    <div class="row g-3">
        <div class="col-md-6">
            <label for="elementary" class="form-label">Elementary:</label>
            <input type="text" class="form-control" name="elementary" id="elementary">
        </div>
        <div class="col-md-6">
            <label for="high_school" class="form-label">High School:</label>
            <input type="text" class="form-control" name="high_school" id="high_school">
        </div>
        <div class="col-md-6">
            <label for="vocational" class="form-label">Vocational:</label>
            <input type="text" class="form-control" name="vocational" id="vocational">
        </div>
        <div class="col-md-6">
            <label for="college" class="form-label">College:</label>
            <input type="text" class="form-control" name="college" id="college">
        </div>
        <div class="col-md-12">
            <label for="others" class="form-label">Others:</label>
            <input type="text" class="form-control" name="others" id="others">
        </div>
    </div>

    <h2 class="mb-4 mt-4">Community Involvement</h2>
    <div class="row g-3">
        <div class="col-md-6">
            <label for="school_community" class="form-label">School Involvement:</label>
            <input type="text" class="form-control" name="school_community" id="school_community">
        </div>
        <div class="col-md-6">
            <label for="civic_community" class="form-label">Civic Organization:</label>
            <input type="text" class="form-control" name="civic_community" id="civic_community">
        </div>
        <div class="col-md-6">
            <label for="community_activities" class="form-label">Community Activities:</label>
            <input type="text" class="form-control" name="community_activities" id="community_activities">
        </div>
        <div class="col-md-6">
            <label for="workspace_community" class="form-label">Workspace Activities:</label>
            <input type="text" class="form-control" name="workspace_community" id="workspace_community">
        </div>
    </div>

    <div class="mt-4">
        <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
    </div>


</div><div class="step" id="step4">
                <h2 class="mb-4">Siminar and Trainings</h2>
                <table class="table table-bordered" id="SemTable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Organizers</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" class="form-control" name="title_training[]"></td>
                            <td><input type="date" class="form-control" name="date_train[]"></td>
                            <td><input type="text" class="form-control" name="organizer[]"></td>
                            <td><button type="button" class="btn btn-danger" onclick="deleteSeMinarTraining(this)">Delete</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-secondary" onclick="addSeMinarTraining()">Add seminar Trainings</button>

                <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
            </div>



            <!-- Step 4: Review and Confirmation -->
            <div class="step" id="step5">
                <h2>Review Your Information</h2>
                <p>Review the data you have entered.</p>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentStep = 0;
        const steps = document.querySelectorAll('.step');

        function showStep(stepIndex) {
            steps.forEach((step, index) => {
                step.classList.remove('active');
                if (index === stepIndex) {
                    step.classList.add('active');
                }
            });
        }

        function nextStep() {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        }

        function prevStep() {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        }

        // Family Table functions
        function addFamilyMember() {
            const table = document.getElementById('familyTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow(table.rows.length);
            newRow.innerHTML = `
                <td><input type="text" class="form-control" name="family_name[]"></td>
                <td><input type="text" class="form-control" name="family_relationship[]"></td>
                <td><input type="number" class="form-control" name="family_age[]"></td>
                <td><input type="date" class="form-control" name="family_birthday[]"></td>
                <td><input type="text" class="form-control" name="family_occupation[]"></td>
                <td><button type="button" class="btn btn-danger" onclick="deleteFamilyMember(this)">Delete</button></td>
            `;
        }

        function deleteFamilyMember(button) {
            const row = button.parentElement.parentElement;
            row.remove();
        }
    </script>

    <!-- Add Seminar Trainings -->
    <script>
    function addSeMinarTraining() {
            const table = document.getElementById('SemTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow(table.rows.length);
            newRow.innerHTML = `
                <td><input type="text" class="form-control" name="title_training[]"></td>
                <td><input type="date" class="form-control" name="date_train[]"></td>
                <td><input type="text" class="form-control" name="organizer[]"></td>
                <td><button type="button" class="btn btn-danger" onclick="deleteSeMinarTraining(this)">Delete</button></td>
            `;
        }

        function deleteSeMinarTraining(button) {
            const row = button.parentElement.parentElement;
            row.remove();
        }
    </script>
</body>

</html>
